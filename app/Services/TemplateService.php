<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TemplateService
{
    private const API_URL = 'https://api.pixelbreeze.xyz/generate';

    public function processTemplate(array $RequestData, ?UploadedFile $file = null): array
    {
        $template_type = $RequestData['template_type'];
        $ArrPostDate = [];

        // Upload file handling
        $UploadFolder = 'uploads';
        $UploadMainPath = Storage::disk('public')->path('/uploads');
        $input_img_path = '';
        $outputImageName = 'output_'.time().'.jpg';
        $output_img_path = $UploadMainPath.DIRECTORY_SEPARATOR.$outputImageName;

        if($file){
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $timestamp = date('d-m-Y-H-i-s');
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $originalName.$timestamp.'.'.$extension;
            $filePath = $UploadFolder.DIRECTORY_SEPARATOR.$fileNameToStore;
            Storage::disk('public')->put($filePath, file_get_contents($file));
            $outputImageName = 'output_'.time().'.'.$extension;
            $input_img_path = $UploadMainPath.DIRECTORY_SEPARATOR.$fileNameToStore;
            $output_img_path = $UploadMainPath.DIRECTORY_SEPARATOR.$outputImageName;
        }

        $ArrPostDate["output_img_path"] = $output_img_path;
        $ArrPostDate["template_type"] = $template_type;
        $ArrPostDate["crop_mode"] = $RequestData['crop_mode'] ?? '';

        // Prepare request data based on article type
        if(isset($RequestData['artical_url']) && !empty($RequestData['artical_url']) &&
            in_array($template_type, ['web_news', 'web_news_story', 'web_news_story_2'])) {

            $ArrPostDate = $this->prepareArticleData($RequestData, $ArrPostDate, $input_img_path);

        } else {
            $ArrPostDate = $this->prepareStandardData($RequestData, $ArrPostDate, $input_img_path);
        }

        // Send API request
        try {
            $response = Http::timeout(30)
                ->withoutVerifying()
                ->post(self::API_URL, $ArrPostDate);

            if (!$response->successful()) {
                return ['status' => 0, 'msg' => 'API request failed'];
            }

            $result = $response->json();

            if(isset($result['output_file_path'])) {
                return [
                    'status' => 1,
                    'img' => asset('storage/uploads/'.$outputImageName)
                ];
            }

            return ['status' => 0, 'msg' => 'Invalid response format'];

        } catch(\Exception $e) {
            return ['status' => 0, 'msg' => $e->getMessage()];
        }
    }

    private function prepareArticleData(array $RequestData, array $ArrPostDate, string $input_img_path): array
    {
        $ArrPostDate["artical_url"] = $RequestData['artical_url'];

        if(isset($RequestData['show_arrow'])) {
            $ArrPostDate["arrow"] = $RequestData['show_arrow'];
        }

        if(isset($RequestData['crop_mode'])) {
            $ArrPostDate["crop_mode"] = $RequestData['crop_mode'];
        }

        if(isset($RequestData['title'])) {
            $ArrPostDate["text"] = $RequestData['title'];
        }

        if(isset($RequestData['sub_text'])) {
            $ArrPostDate["sub_text"] = $RequestData['sub_text'];
        }

        if(isset($RequestData['text_to_hl'])) {
            $ArrPostDate["text_to_hl"] = $RequestData['text_to_hl'];
        }

        if($input_img_path) {
            $ArrPostDate["input_img_path"] = $input_img_path;
        }

        if (in_array($RequestData['template_type'], ['web_news_story'])) {
            $ArrPostDate["template_type"] = $RequestData['custom_template_type'] ?? $RequestData['template_type'];
            $ArrPostDate["crop_mode"] = 'story';
        }

        return $ArrPostDate;
    }

    private function prepareStandardData(array $RequestData, array $ArrPostDate, string $input_img_path): array
    {
        $template_type = $RequestData['template_type'];

        $ArrPostDate["input_img_path"] = $input_img_path;
        $ArrPostDate["text"] = $RequestData['title'] ?? '';
        $ArrPostDate["arrow"] = $RequestData['show_arrow'] ?? '';

        // Handle different template types
        if(in_array($template_type, ['iconic_location','citim','reforma_new_quote','citim_version_2', 'reforma_news_feed'])){
            if ($template_type === 'reforma_news_feed') {
                $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? 'LAJM';
            } else {
                $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
            }

            if ($template_type === 'citim_version_2' && isset($RequestData['crop_mode'])) {
                $ArrPostDate["crop_mode"] = $RequestData['crop_mode'];
            }
        }
        else if ($template_type === 'web_news_story') {
            $ArrPostDate["template_type"] = $RequestData['custom_template_type'] ?? $template_type;
            $ArrPostDate["crop_mode"] = 'story';
            $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
        }
        else if(in_array($template_type, ['web_news_story_2', 'reforma_web_news_story_2'])){
            if ($template_type === 'reforma_web_news_story_2') {
                if(isset($RequestData['sub_text'])) {
                    $ArrPostDate["sub_text"] = $RequestData['sub_text'];
                }
            } else {
                $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
            }

            if(isset($RequestData['artical_url'])) {
                $ArrPostDate["artical_url"] = $RequestData['artical_url'];
            }
            $ArrPostDate["category"] = $RequestData['category'] ?? '';
        }
        else if($template_type === 'feed_location') {
            $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
            $ArrPostDate["arrow"] = $RequestData['show_arrow'] ?? '';
            $ArrPostDate["location"] = $RequestData['location'] ?? '';
        }
        else if($template_type === 'highlight') {
            $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
            $ArrPostDate["text_to_hl"] = $RequestData['text_to_hl'] ?? '';
            $ArrPostDate["arrow"] = $RequestData['show_arrow'];
        }
        else if($template_type === 'web_news') {
            $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
            $ArrPostDate["text_to_hl"] = $RequestData['text_to_hl'] ?? '';
            $ArrPostDate["arrow"] = $RequestData['show_arrow'];
        }
        else if(in_array($template_type, ['quotes_writings_morning','quotes_writings_thonjeza'])) {
            $ArrPostDate["arrow"] = $RequestData['show_arrow'] ?? '';
        }
        else if(in_array($template_type, ['quotes_writings_art','quotes_writings_citim'])) {
            $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
            $ArrPostDate["arrow"] = $RequestData['show_arrow'] ?? '';
        }
        else if(in_array($template_type, ['feed_basic', 'feed_swipe','feed_headline','reforma_feed_swipe','reforma_quotes_writings'])) {
            if(!in_array($template_type, ['reforma_feed_swipe'])){
                $ArrPostDate["sub_text"] = $RequestData['sub_text'] ?? '';
            }
            $ArrPostDate["arrow"] = $RequestData['show_arrow'] ?? '';
        }
        else if($template_type === 'reforma_logo_only') {
            $ArrPostDate["pos"] = $RequestData['logo_position'];
        }
        else if($template_type === 'logo_only') {
            $ArrPostDate["logo_position"] = $RequestData['logo_position'];
        }
        else if(in_array($template_type, ['reforma_web_news_story1', 'reforma_web_news_story2', 'reforma_logo_only'])) {
            $ArrPostDate["crop_mode"] = 'story';

            if(isset($RequestData['artical_url'])) {
                $ArrPostDate["artical_url"] = $RequestData['artical_url'];
            }

            if ($template_type === 'reforma_web_news_story2' && isset($RequestData['sub_text'])) {
                $ArrPostDate["sub_text"] = $RequestData['sub_text'];
            }
            else if ($template_type === 'reforma_web_news_story1' && isset($RequestData['category'])) {
                $ArrPostDate["category"] = $RequestData['category'];
            }
        }

        return $ArrPostDate;
    }
}
