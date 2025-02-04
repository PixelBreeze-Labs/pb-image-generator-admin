<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class HomeController extends Controller
{
    public function dashboard($p_id)
    {
        $Tmpdata = getTemplateName();
        $data = array();
        $data['user_templates'] = Auth::user()->templates->pluck('template_id')->toArray();
        if(isset($Tmpdata[$p_id]) && in_array($p_id, $data['user_templates'])) {

            $data['templateData'] = $Tmpdata[$p_id];

            return view('admin.template',$data);

        } else {
            return redirect('/');
        }
    }

    public function store(Request $request){

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
            $errors = array_unique($errors); // Remove duplicate error messages
            $msg = implode("<br />", $errors);
            return ['status' => $status, 'msg' => $msg];
        } else {
            $RequestData = $request->all();
            $apiURL = 'https://stageapi.pixelbreeze.xyz/generate';
            $postData = [];
            if(isset($RequestData['template_type'])) {
                $template_type = $RequestData['template_type'];
                $ArrPostDate = [];


                $sessionId = 'session_'.time();
                $ArrPostDate['session_id'] = $sessionId;

                //store uploaded file
                $UploadFolder   = 'uploads';
                $UploadMainPath = Storage::disk('public')->path('/uploads');
                $input_img_path = '';
                $outputImageName    = 'output_'.time().'.jpg';
                $output_img_path    = $UploadMainPath.DIRECTORY_SEPARATOR.$outputImageName;
                $file = $request->file('image');
                if(!empty($file)){
                    $originalName       = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $timestamp          = date('d-m-Y-H-i-s');
                    $extension          = $file->getClientOriginalExtension();
                    $fileNameToStore    = $originalName.$timestamp.'.'.$extension;
                    $filePath           = $UploadFolder.DIRECTORY_SEPARATOR.$fileNameToStore;
                    Storage::disk('public')->put($filePath, file_get_contents($file));
                    // $rootPath = storage_path().'.'.$filePath;
                    $outputImageName    = 'output_'.time().'.'.$extension;
                    $input_img_path     = $UploadMainPath.DIRECTORY_SEPARATOR.$fileNameToStore;
                    $output_img_path    = $UploadMainPath.DIRECTORY_SEPARATOR.$outputImageName;
                }

                $ArrPostDate["output_img_path"] = $output_img_path;
                $ArrPostDate["template_type"]   = $template_type;
                $ArrPostDate["crop_mode"]       = isset($RequestData['crop_mode'])? $RequestData['crop_mode']:'';

                if($IsArticle== 1) {
                    if (in_array($template_type, ['web_news_story'])) {
                        $ArrPostDate["template_type"]    = isset($RequestData['custom_template_type']) ? $RequestData['custom_template_type'] : $template_type;
                        $ArrPostDate["crop_mode"]       = 'story';
                    }
                    $ArrPostDate["artical_url"]     = isset($RequestData['artical_url'])?$RequestData['artical_url']:'';
                } else {
                    $ArrPostDate["input_img_path"]  = $input_img_path;
                    $ArrPostDate["text"]            = isset($RequestData['title'])?$RequestData['title']:'';
                    if(in_array($template_type, ['iconic_location','citim','reforma_new_quote','citim_version_2'])){
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                    }
                    else if (in_array($template_type, ['web_news_story'])) {
                        $ArrPostDate["template_type"]    = isset($RequestData['custom_template_type']) ? $RequestData['custom_template_type'] : $template_type;
                        $ArrPostDate["crop_mode"]       = 'story';
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text']) ? $RequestData['sub_text'] : '';
                    } else if(in_array($template_type, ['web_news_story_2'])){
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["category"]    = isset($RequestData['category'])?$RequestData['category']:'';
                    } else if(in_array($template_type, ['feed_location'])) {

                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["arrow"]       = isset($RequestData['show_arrow'])?$RequestData['show_arrow']:'';
                        $ArrPostDate["location"]    = isset($RequestData['location'])?$RequestData['location']:'';

                    } else if(in_array($template_type, ['highlight'])) {
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["text_to_hl"]      = isset($RequestData['text_to_hl'])?$RequestData['text_to_hl']:'';
                    }  else if(in_array($template_type, ['web_news'])) {
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["text_to_hl"]      = isset($RequestData['text_to_hl'])?$RequestData['text_to_hl']:'';
                        $ArrPostDate["arrow"]      = $RequestData['show_arrow'];
                    } else if(in_array($template_type, ['quotes_writings_morning','quotes_writings_thonjeza'])) {
                        $ArrPostDate["arrow"]      = isset($RequestData['show_arrow'])?$RequestData['show_arrow']:'';
                    } else if(in_array($template_type, ['quotes_writings_art','quotes_writings_citim'])) {
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["arrow"]      = isset($RequestData['show_arrow'])?$RequestData['show_arrow']:'';
                    } else if(in_array($template_type, ['feed_basic', 'feed_swipe','feed_headline','reforma_feed_swipe','reforma_quotes_writings'])){
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["arrow"]      = isset($RequestData['show_arrow'])?$RequestData['show_arrow']:'';
                    } else if(in_array($template_type, ['logo_only'])){
                        $ArrPostDate["pos"] = $RequestData['logo_position'];
                    }
                }

                $conn = curl_init($apiURL);
                curl_setopt( $conn, CURLOPT_CONNECTTIMEOUT, 30 );
                curl_setopt( $conn, CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $conn, CURLOPT_SSL_VERIFYHOST, 2 );
                curl_setopt( $conn, CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $conn, CURLOPT_URL, $apiURL);
                curl_setopt( $conn, CURLOPT_SSLVERSION, 1 );
                curl_setopt( $conn, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt( $conn, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($conn, CURLOPT_POSTFIELDS, $ArrPostDate);

                $output = curl_exec($conn);
                // $result = json_decode($output);
                $result = json_decode($output, true);
                $info   = curl_getinfo($conn);
                $returnUrl = '';
                if ($result === null) {
                    return ['status' => 0, 'msg' => 'tafaklsdfhajklsf'];
                } else {
                    if(isset($result['output_file_path']) && !empty($result['output_file_path'])) {
                        $returnUrl = asset('storage/uploads/'.$outputImageName);
                    }
                    return ['status' => 1, 'img' => $returnUrl];
                }


            }

            $templates = ['sample', 'second', 'highlight']; //list of supported templete
            $random_template_key = array_rand($templates);  //choose any random template
            $postData['template_type'] = $templates[$random_template_key] ?? '';

            $postData['template_type'] = 'line_temp';

            $postData['crop_mode'] = $request->crop_mode ?? '';
            if($postData['template_type'] != 'logo_only') {
                $postData['text'] = $request->title ?? '';
            }

            if($postData['template_type'] == 'highlight') {
                $postData['text_to_hl'] = $request->category ?? '';
            }


        }
    }

    public function viewTemplate(){
        $data = array();
        $data['templateName'] = getTemplateName();
        $data['user_templates'] = Auth::user()->templates->pluck('template_id')->toArray();
        return view('admin.newDashboard',$data);
    }

    public function getImageTemplates()
    {
        $data = array();
        $data['templateName'] = getTemplateName();
        $data['user_templates'] = Auth::user()->templates->pluck('template_id')->toArray();
        return view('admin.newDashboard2', $data);
    }

    public function checkTextSuggestion(Request $request)
    {
        $text = $request['text'];
        $suggestion = $this->checkGrammar($text);

        return ['suggestion' => $suggestion];
    }


    public function checkGrammar($text)
    {
        $client = new Client();
        $headers = [
        'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
        'OpenAI-Organization' => env("OPENAI_ORGANIZATION"),
        'Content-Type' => 'application/json',
        ];
        $body = [
        "model" => "gpt-3.5-turbo",
        "messages" => [
            [
            "role"=> "user",
            "content"=> "Fix the grammar for '".$text."'. If the text doesn't seem to be English, correct it in Albanian. Reply only the corrected text."
            ]
        ],
        "temperature"=> 0.7
        ];
        // dd(json_encode($headers));
        $request = new GuzzleRequest('POST', 'https://api.openai.com/v1/chat/completions', $headers, json_encode($body));
        $res = $client->sendAsync($request)->wait();
        $response = $res->getBody();
        $choices = json_decode($response, true);

        $suggestion = $choices['choices'][0]['message']['content'];

        return $suggestion;
    }

    public function checkTextSuggestionAlbanian(Request $request)
    {
        $text = $request['text'];
        $suggestion = $this->checkGrammar($text);

        return ['suggestion' => $suggestion];
    }

    public function checkGrammarAlbanian($text)
    {
        $client = new Client();
        $headers = [
        'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
        'OpenAI-Organization' => env("OPENAI_ORGANIZATION"),
        'Content-Type' => 'application/json',
        ];
        $body = [
        "model" => "gpt-3.5-turbo",
        "messages" => [
            [
            "role"=> "user",
            "content"=> "Rregullo gabimet drejtshkrimore: '".$text."'. Kthe pergjigje vetem tekstin e korrigjuar."
            ]
        ],
        "temperature"=> 0.7
        ];
        // dd(json_encode($headers));
        $request = new GuzzleRequest('POST', 'https://api.openai.com/v1/chat/completions', $headers, json_encode($body));
        $res = $client->sendAsync($request)->wait();
        $response = $res->getBody();
        $choices = json_decode($response, true);

        $suggestion = $choices['choices'][0]['message']['content'];

        return $suggestion;
    }
}
