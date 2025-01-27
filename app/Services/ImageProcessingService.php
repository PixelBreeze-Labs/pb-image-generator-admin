<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class ImageProcessingService
{
    private $apiUrl;
    private $uploadPath = 'uploads';

    public function __construct()
    {
        $this->apiUrl = config('services.pixelbreeze.api_url');
    }

    /**
     * Process image with template
     */
    public function processImage(array $data, ?UploadedFile $image = null): array
    {
        try {
            $postData = $this->preparePostData($data, $image);

            // Cache API response for identical requests
            $cacheKey = 'api_response_' . md5(json_encode($postData));

            return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($postData) {
                return $this->sendToApi($postData);
            });
        } catch (Exception $e) {
            Log::error('Image processing failed: ' . $e->getMessage(), [
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Handle file upload and prepare data for API
     */
    private function preparePostData(array $data, ?UploadedFile $image): array
    {
        $postData = [
            'template_type' => $data['template_type'],
            'crop_mode' => $data['crop_mode'] ?? ''
        ];

        if ($image) {
            $filePath = $this->handleFileUpload($image);
            $outputPath = $this->generateOutputPath($image);

            $postData['input_img_path'] = Storage::disk('public')->path($filePath);
            $postData['output_img_path'] = Storage::disk('public')->path($outputPath);
        }

        // Handle article-based templates
        if ($this->isArticleTemplate($data['template_type']) && isset($data['artical_url'])) {
            $postData['artical_url'] = $data['artical_url'];
            return $postData;
        }

        // Handle regular templates
        $postData['text'] = $data['title'] ?? '';

        // Add template-specific fields
        $this->addTemplateSpecificFields($postData, $data);

        return $postData;
    }

    /**
     * Upload file and return path
     */
    private function handleFileUpload(UploadedFile $file): string
    {
        $fileName = $this->generateFileName($file);
        $filePath = $this->uploadPath . '/' . $fileName;

        Storage::disk('public')->put(
            $filePath,
            file_get_contents($file)
        );

        return $filePath;
    }

    /**
     * Generate unique filename
     */
    private function generateFileName(UploadedFile $file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $timestamp = date('d-m-Y-H-i-s');
        $extension = $file->getClientOriginalExtension();

        return $originalName . $timestamp . '.' . $extension;
    }

    /**
     * Generate output file path
     */
    private function generateOutputPath(UploadedFile $file): string
    {
        return $this->uploadPath . '/output_' . time() . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Send request to backend API
     */
    private function sendToApi(array $data): array
    {
        try {
            $response = Http::timeout(30)
                ->retry(3, 100)
                ->post($this->apiUrl, $data);

            if ($response->successful()) {
                $result = $response->json();

                if (!empty($result['output_file_path'])) {
                    return [
                        'status' => 1,
                        'img' => asset('storage/uploads/' . basename($result['output_file_path']))
                    ];
                }
            }

            Log::warning('API call failed', [
                'response' => $response->body(),
                'status' => $response->status()
            ]);

            return ['status' => 0, 'message' => 'API processing failed'];
        } catch (Exception $e) {
            Log::error('API call error: ' . $e->getMessage());
            throw new Exception('Failed to process image');
        }
    }

    /**
     * Check if template is article-based
     */
    private function isArticleTemplate(string $templateType): bool
    {
        return in_array($templateType, [
            'web_news',
            'web_news_story',
            'web_news_story_2'
        ]);
    }

    /**
     * Add template-specific fields to post data
     */
    private function addTemplateSpecificFields(array &$postData, array $data): void
    {
        $templateType = $data['template_type'];

        $specificFields = [
            'iconic_location' => ['sub_text'],
            'citim' => ['sub_text'],
            'reforma_new_quote' => ['sub_text'],
            'citim_version_2' => ['sub_text'],
            'web_news_story' => ['sub_text'],
            'feed_location' => ['sub_text', 'arrow' => 'show_arrow', 'location'],
            'highlight' => ['sub_text', 'text_to_hl'],
            'web_news' => ['sub_text', 'text_to_hl', 'arrow' => 'show_arrow']
        ];

        if (isset($specificFields[$templateType])) {
            foreach ($specificFields[$templateType] as $key => $field) {
                $sourceField = is_numeric($key) ? $field : $field;
                $targetField = is_numeric($key) ? $field : $key;

                if (isset($data[$sourceField])) {
                    $postData[$targetField] = $data[$sourceField];
                }
            }
        }
    }
}