<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
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
            // dd($request->all());
            $RequestData = $request->all();
            $apiURL = 'https://api.pixelbreeze.xyz/generate';
            $postData = [];
            if(isset($RequestData['template_type'])) {
                $template_type = $RequestData['template_type'];
                $ArrPostDate = [];


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
		//return  $output_img_path;

                $ArrPostDate["output_img_path"] = $output_img_path;
                $ArrPostDate["template_type"]   = $template_type;
                $ArrPostDate["crop_mode"]       = isset($RequestData['crop_mode'])? $RequestData['crop_mode']:'';

                if($IsArticle== 1) {
                    $ArrPostDate["artical_url"]     = isset($RequestData['artical_url'])?$RequestData['artical_url']:'';
                    if(isset($RequestData['show_arrow']) && !empty($RequestData['show_arrow'])) {
                        $ArrPostDate["arrow"]          = $RequestData['show_arrow'];
                    }
                    if(isset($RequestData['crop_mode']) && !empty($RequestData['crop_mode'])) {
                        $ArrPostDate["crop_mode"]          = $RequestData['crop_mode'];
                    }
                    if(isset($RequestData['title']) && !empty($RequestData['title'])) {
                        $ArrPostDate["text"]          = $RequestData['title'];
                    }
                    if(isset($RequestData['sub_text']) && !empty($RequestData['sub_text'])) {
                        $ArrPostDate["sub_text"]          = $RequestData['sub_text'];
                    }
                    if(isset($RequestData['text_to_hl']) && !empty($RequestData['text_to_hl'])) {
                        $ArrPostDate["text_to_hl"]          = $RequestData['text_to_hl'];
                    }
                    if(!empty($input_img_path)) {
                        $ArrPostDate["input_img_path"]  = $input_img_path;
                    }
                    if (in_array($template_type, ['web_news_story'])) {
                        $ArrPostDate["template_type"]    = isset($RequestData['custom_template_type']) ? $RequestData['custom_template_type'] : $template_type;
                        $ArrPostDate["crop_mode"]       = 'story';
                    }
                } else {
                    $ArrPostDate["input_img_path"]  = $input_img_path;
                    $ArrPostDate["text"]            = isset($RequestData['title'])?$RequestData['title']:'';
                    $ArrPostDate["arrow"]           = isset($RequestData['show_arrow'])?$RequestData['show_arrow']:'';
                    if(in_array($template_type, ['iconic_location','citim','reforma_new_quote','citim_version_2', 'reforma_news_feed'])){
                        if (in_array($template_type, ['reforma_news_feed'])) {
                            $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'LAJM';
                        } else {
                            $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        }

                        if (in_array($template_type, ['citim_version_2'])) {
                            if(isset($RequestData['crop_mode']) && !empty($RequestData['crop_mode'])) {
                                $ArrPostDate["crop_mode"]          = $RequestData['crop_mode'];
                            }
                        }

                    }
                    else if (in_array($template_type, ['web_news_story'])) {
                        $ArrPostDate["template_type"]    = isset($RequestData['custom_template_type']) ? $RequestData['custom_template_type'] : $template_type;
                        $ArrPostDate["crop_mode"]       = 'story';
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text']) ? $RequestData['sub_text'] : '';
                    } else if(in_array($template_type, ['web_news_story_2', 'reforma_web_news_story_2'])){

                        if (in_array($template_type, ['reforma_web_news_story_2']) && isset($RequestData['sub_text'])) {
                            $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        } else if (!in_array($template_type, ['reforma_web_news_story_2'])) {
                            $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        }
                        if(isset($RequestData['artical_url']) && !empty($RequestData['artical_url'])) {
                            $ArrPostDate["artical_url"]          = $RequestData['artical_url'];
                        }
                        $ArrPostDate["category"]    = isset($RequestData['category'])?$RequestData['category']:'';
                    } else if(in_array($template_type, ['feed_location'])) {

                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["arrow"]       = isset($RequestData['show_arrow'])?$RequestData['show_arrow']:'';
                        $ArrPostDate["location"]    = isset($RequestData['location'])?$RequestData['location']:'';

                    } else if(in_array($template_type, ['highlight'])) {
                        $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        $ArrPostDate["text_to_hl"]  = isset($RequestData['text_to_hl'])?$RequestData['text_to_hl']:'';
                        $ArrPostDate["arrow"]       = $RequestData['show_arrow'];
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
                        if(!in_array($template_type, ['reforma_feed_swipe'])){
                            $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        }
                        $ArrPostDate["arrow"]      = isset($RequestData['show_arrow'])?$RequestData['show_arrow']:'';
                    } else if(in_array($template_type, ['reforma_logo_only'])){
                        $ArrPostDate["pos"] = $RequestData['logo_position'];
                    }else if(in_array($template_type, ['logo_only'])){
                        $ArrPostDate["logo_position"] = $RequestData['logo_position'];
                    } else if(in_array($template_type, ['reforma_web_news_story1', 'reforma_web_news_story2', 'reforma_logo_only'])){
                        // $ArrPostDate["template_type"]    = isset($RequestData['custom_template_type']) ? $RequestData['custom_template_type'] : $template_type;
                        $ArrPostDate["crop_mode"]       = 'story';
                        if(isset($RequestData['artical_url']) && !empty($RequestData['artical_url'])) {
                            $ArrPostDate["artical_url"]          = $RequestData['artical_url'];
                        }
                        if (in_array($template_type, ['reforma_web_news_story2']) && isset($RequestData['sub_text'])) {
                            $ArrPostDate["sub_text"]    = isset($RequestData['sub_text'])?$RequestData['sub_text']:'';
                        } else if (in_array($template_type, ['reforma_web_news_story1']) && isset($RequestData['category'])) {
                            $ArrPostDate["category"]    = isset($RequestData['category'])?$RequestData['category']:'';
                        }

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
		//dd($output);
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
        return view('newDashboard',$data);
    }
}
