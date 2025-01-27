<?php

namespace App\Http\Controllers;

use App\Services\TemplateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    protected $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
    }

    public function dashboard($p_id)
    {
        $Tmpdata = getTemplateName();

        if(isset($Tmpdata[$p_id])) {
            $data = array();
            $data['templateData'] = $Tmpdata[$p_id];

            return view('dashboard',$data);
        } else {
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $RequestData = $request->all();
        $template_type = $RequestData['template_type'];
        $IsArticle = 0;

        if(in_array($template_type, ['web_news', 'web_news_story', 'web_news_story_2'])){
            if(isset($RequestData['artical_url']) && !empty($RequestData['artical_url'])) {
                $IsArticle = 1;
                $formRulesAndMsg = [
                    'rules'=>[
                        'artical_url' => 'required|string|max:255',
                    ],
                    'msg'=>[
                        'artical_url.required' => 'The Article url is required.'
                    ],
                ];
            } else {
                $formRulesAndMsg = getFormValidationRules($template_type);
            }
        } else {
            $formRulesAndMsg = getFormValidationRules($template_type);
        }

        $validator = Validator::make($request->all(), $formRulesAndMsg['rules'], $formRulesAndMsg['msg']);

        if($validator->fails()) {
            $status = 0;
            $errors = $validator->errors()->all();
            $errors = array_unique($errors);
            $msg = implode("<br />", $errors);
            return ['status' => $status, 'msg' => $msg];
        }

        return $this->templateService->processTemplate($request->all(), $request->file('image'));
    }

    public function viewTemplate()
    {
        $data = array();
        $data['templateName'] = getTemplateName();
        return view('newDashboard',$data);
    }
}
