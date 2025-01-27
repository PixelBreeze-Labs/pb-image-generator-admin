<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard($p_id)
    {
        $templateData = Cache::remember("template_data_{$p_id}", 60, function () use ($p_id) {
            return $this->getUserTemplate($p_id);
        });

        if ($templateData) {
            return view('admin.template', ['templateData' => $templateData]);
        }

        return redirect('/');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateRequest($request);

        if (!$validatedData['status']) {
            return response()->json($validatedData, 400);
        }

        try {
            $requestData = $validatedData['data'];
            $templateType = $requestData['template_type'];

            // Use caching for prepared data to reduce redundant operations
            $postData = Cache::remember("post_data_{$templateType}_" . md5(json_encode($requestData)), 10, function () use ($request, $templateType) {
                return $this->preparePostData($request, $templateType);
            });

            $response = Cache::remember("api_response_" . md5(json_encode($postData)), 10, function () use ($postData) {
                return $this->sendToBackendAPI($postData);
            });

            if ($response['status'] === 1) {
                return response()->json(['status' => 1, 'img' => $response['img']], 200);
            }

            return response()->json(['status' => 0, 'msg' => 'API Error'], 500);
        } catch (\Exception $e) {
            Log::error('Error in image generation: ' . $e->getMessage());
            return response()->json(['status' => 0, 'msg' => 'Internal Server Error'], 500);
        }
    }

    private function validateRequest(Request $request)
    {
        $templateType = $request->input('template_type');

        $formRulesAndMsg = getFormValidationRules($templateType);

        $validator = \Validator::make($request->all(), $formRulesAndMsg['rules'], $formRulesAndMsg['msg']);

        if ($validator->fails()) {
            return [
                'status' => 0,
                'msg' => implode("<br />", array_unique($validator->errors()->all())),
            ];
        }

        return ['status' => 1, 'data' => $request->all()];
    }

    private function preparePostData(Request $request, $templateType)
    {
        $postData = [];
        $isArticle = in_array($templateType, ['web_news', 'web_news_story', 'web_news_story_2']) && $request->has('artical_url');

        // Handle file uploads
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $timestamp = date('d-m-Y-H-i-s');
            $extension = $file->getClientOriginalExtension();
            $storedFileName = $fileName . $timestamp . '.' . $extension;
            $filePath = 'uploads/' . $storedFileName;

            Storage::disk('public')->put($filePath, file_get_contents($file));

            $postData['input_img_path'] = Storage::disk('public')->path($filePath);
            $postData['output_img_path'] = Storage::disk('public')->path('uploads/output_' . time() . '.' . $extension);
        }

        $postData['template_type'] = $templateType;
        $postData['crop_mode'] = $request->input('crop_mode', '');

        if ($isArticle) {
            $postData['artical_url'] = $request->input('artical_url');
        } else {
            $postData['text'] = $request->input('title', '');
            if (in_array($templateType, ['iconic_location', 'citim', 'reforma_new_quote', 'citim_version_2'])) {
                $postData['sub_text'] = $request->input('sub_text', '');
            } elseif ($templateType === 'web_news_story') {
                $postData['sub_text'] = $request->input('sub_text', '');
                $postData['crop_mode'] = 'story';
            } elseif ($templateType === 'feed_location') {
                $postData['sub_text'] = $request->input('sub_text', '');
                $postData['arrow'] = $request->input('show_arrow', '');
                $postData['location'] = $request->input('location', '');
            }
        }

        return $postData;
    }

    private function sendToBackendAPI($data)
    {
        $apiURL = config('services.pixelbreeze.api_url');
        $response = Http::post($apiURL, $data);

        if ($response->successful()) {
            $result = $response->json();

            if (!empty($result['output_file_path'])) {
                return [
                    'status' => 1,
                    'img' => asset('storage/uploads/' . $result['output_file_path']),
                ];
            }
        }

        return ['status' => 0];
    }

    private function getUserTemplate($p_id)
    {
        $templates = getTemplateName();
        $userTemplates = Auth::user()->templates->pluck('template_id')->toArray();

        if (isset($templates[$p_id]) && in_array($p_id, $userTemplates)) {
            return $templates[$p_id];
        }

        return null;
    }
}
