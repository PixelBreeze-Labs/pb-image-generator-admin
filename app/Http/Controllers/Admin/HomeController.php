<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageProcessingService;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    protected $imageService;
    protected $cacheService;

    public function __construct(
        ImageProcessingService $imageService,
        CacheService $cacheService
    ) {
        $this->imageService = $imageService;
        $this->cacheService = $cacheService;
    }

    /**
     * Display dashboard with template
     */
    public function dashboard($p_id)
    {
        try {
            $cacheKey = $this->cacheService->generateKey('template_data', ['id' => $p_id, 'user' => Auth::id()]);

            $templateData = $this->cacheService->remember($cacheKey, function () use ($p_id) {
                return $this->getUserTemplate($p_id);
            });

            if (!$templateData) {
                return redirect('/')->with('error', 'Template not found or access denied');
            }

            return view('admin.template', compact('templateData'));
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return redirect('/')->with('error', 'An error occurred');
        }
    }

    /**
     * Process and store image
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->validateRequest($request);

            if (!$validatedData['status']) {
                return response()->json($validatedData, 400);
            }

            $result = $this->imageService->processImage(
                $validatedData['data'],
                $request->file('image')
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Image generation error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'template' => $request->input('template_type')
            ]);

            return response()->json([
                'status' => 0,
                'msg' => 'Failed to process image'
            ], 500);
        }
    }

    /**
     * Validate incoming request
     */
    private function validateRequest(Request $request): array
    {
        $templateType = $request->input('template_type');
        $formRulesAndMsg = getFormValidationRules($templateType);

        $validator = Validator::make(
            $request->all(),
            $formRulesAndMsg['rules'],
            $formRulesAndMsg['msg']
        );

        if ($validator->fails()) {
            return [
                'status' => 0,
                'msg' => implode("<br />", array_unique($validator->errors()->all()))
            ];
        }

        return [
            'status' => 1,
            'data' => $request->all()
        ];
    }

    /**
     * Get user's template
     */
    private function getUserTemplate($templateId)
    {
        $templates = getTemplateName();
        $userTemplates = Auth::user()->templates->pluck('template_id')->toArray();

        if (!isset($templates[$templateId]) || !in_array($templateId, $userTemplates)) {
            return null;
        }

        return $templates[$templateId];
    }
}