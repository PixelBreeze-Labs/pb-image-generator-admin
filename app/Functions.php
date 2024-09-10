<?php

function prd($value='')
{
	echo "<pre>";
	print_r($value);
	exit();
}

function getTemplateName(){
	$templateArray = [
		1 => [
			'name'  => 'Feed Basic',
			'image' => 'feed_basic.png',
			'template_type' => 'feed_basic',
		],

		2 => [
			'name'  => 'Feed Swipe',
			'image' => 'feed_swipe.png',
			'template_type' => 'feed_swipe',
		],

		3 => [
			'name'  => 'Iconic Location',
			'image' => 'iconic_location.png',
			'template_type' => 'iconic_location',
		],

		4 => [
			'name'  => 'Citim',
			'image' => 'citim.png',
			'template_type' => 'citim',
		],
		5 => [
			'name'  => 'Web News Story',
			'image' => 'web_news_story.png',
			'template_type' => 'web_news_story',
		],
		6 => [
			'name'  => 'Feed Headline',
			'image' => 'feed_headline.png',
			'template_type' => 'feed_headline',
		],

		7 => [
			'name'  => 'Logo Only',
			'image' => 'logo_only_image.jpg',
			'template_type' => 'logo_only',
		],

		8 => [
			'name'  => 'Web News',
			'image' => 'web_news.png',
			'template_type' => 'web_news',
		],

		9 => [
			'name'  => 'Feed Location',
			'image' => 'feed_location.png',
			'template_type' => 'feed_location',
		],


		10 => [
			'name'  => 'Quotes & Writings',
			'image' => 'quotes_writings_art.png',
			'template_type' => 'quotes_writings_art',
		],
		11 => [
			'name'  => 'Morning Quote',
			'image' => 'quotes_writings_morning.png',
			'template_type' => 'quotes_writings_morning',
		],
		12 => [
			'name'  => 'Pa Thonjëza',
			'image' => 'quotes_writings_thonjeza.png',
			'template_type' => 'quotes_writings_thonjeza',
		],
		13 => [
			'name'  => 'Citim Blank',
			'image' => 'quotes_writings_citim.png',
			'template_type' => 'quotes_writings_citim',
		],

		14 => [
			'name'  => 'Web News Story 2',
			'image' => 'web_news_story_2.png',
			'template_type' => 'web_news_story_2',
		],
		15 => [
			'name'  => 'Highlight',
			'image' => 'highlight.png',
			'template_type' => 'highlight',
		],
		16 => [
			'name'  => 'Reforma Quotes Writings',
			'image' => 'reforma_quotes_writings.jpeg',
			'template_type' => 'reforma_quotes_writings',
		],
		17 => [
			'name'  => 'Reforma New Quote',
			'image' => 'reforma_new_quote.jpeg',
			'template_type' => 'reforma_new_quote',
		],
		18 => [
			'name'  => 'Reforma Feed Swipe',
			'image' => 'reforma_feed_swipe.jpeg',
			'template_type' => 'reforma_feed_swipe',
		],
		19 => [
			'name'  => 'Citim 2',
			'image' => 'citim_version_2.jpeg',
			'template_type' => 'citim_version_2',
		],
		20 => [
			'name'  => 'Reforma News Feed',
			'image' => 'reforma_news_feed.jpeg',
			'template_type' => 'reforma_news_feed',
		],
		21 => [
			'name'  => 'Reforma Web News Story',
			'image' => 'reforma_web_news_story1.jpeg',
			'template_type' => 'reforma_web_news_story1',
		],
		22 => [
			'name'  => 'Reforma Web News Story (Caption)',
			'image' => 'reforma_web_news_story_2.jpeg',
			'template_type' => 'reforma_web_news_story_2',
		],
		23 => [
			'name'  => 'Reforma Web News Story 2',
			'image' => 'reforma_web_news_story2.jpeg',
			'template_type' => 'reforma_web_news_story2',
		],
		24 => [
			'name' => 'Reforma Logo Only',
			'image' => 'reforma_logo_only.jpg',
			'template_type' => 'reforma_logo_only'
		]
	];

	return $templateArray;
}

function getFormValidationRules($formType)
{
    $formRules = [
        'feed_basic' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
        ],
        'feed_swipe' => [
			'rules'=>[
				// 'title' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				// 'title.required' => 'The title is required.',
				// 'title.max' => 'The title may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
        ],
		'iconic_location' => [
			'rules'=>[
				// 'title' => 'required|string|max:355',
            	// 'sub_text' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				// 'title.required' => 'The title is required.',
				// 'sub_text.required' => 'The category is required.',
				// 'title.max' => 'The title may not be greater than 355 characters.',
        		// 'sub_text.max' => 'The category may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
        ],
		'citim' => [
			'rules'=>[
				'title' => 'required|string|max:355',
            	'sub_text' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The citim is required.',
				'sub_text.required' => 'The author is required.',
				'title.max' => 'The citim may not be greater than 355 characters.',
        		'sub_text.max' => 'The author may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'web_news_story' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'feed_headline' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'logo_only' => [
			'rules'=>[
            	'logo_position' => 'required',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'logo_position.required' => 'The logo_position is required.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'web_news' => [
			'rules'=>[
				'title' => 'required|string|max:355',
            	// 'sub_text' => 'required|string|max:355',
				// 'text_to_hl' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'sub_text.required' => 'The category is required.',
				'text_to_hl.required' => 'The text to highlight is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
        		'sub_text.max' => 'The subtitle may not be greater than 355 characters.',
        		'text_to_hl.max' => 'The text to highlight may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'feed_location' => [
			'rules'=>[
				// 'title' => 'required|string|max:355',
            	// 'sub_text' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'sub_text.required' => 'The category is required.',
				'location.required' => 'The location is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
        		'sub_text.max' => 'The category may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'quotes_writings_art' => [
			'rules'=>[
				'title' => 'required|string|max:355',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
			],
		],
		'quotes_writings_morning' => [
			'rules'=>[
				'title' => 'required|string|max:355',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
			],
		],
		'quotes_writings_thonjeza' => [
			'rules'=>[
				'title' => 'required|string|max:355',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
			],
		],
		'quotes_writings_citim' => [
			'rules'=>[
				'title' => 'required|string|max:355',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
			],
		],
		'web_news_story_2' => [
			'rules'=>[
				'title' => 'required|string|max:355',
            	'sub_text' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'sub_text.required' => 'The category is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
        		'sub_text.max' => 'The category may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'highlight' => [
			'rules'=>[
				// 'title' => 'required|string|max:355',
				// 'text_to_hl' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				// 'title.required' => 'The title is required.',
				// 'text_to_hl.required' => 'The text to highlight is required.',
				// 'title.max' => 'The title may not be greater than 355 characters.',
        		// 'text_to_hl.max' => 'The text to highlight may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],

		'reforma_quotes_writings' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				'sub_text' => 'required|string|max:355',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'sub_text.required' => 'The category is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
        		'sub_text.max' => 'The category may not be greater than 355 characters.',
			],
		],
		'reforma_new_quote' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				'sub_text' => 'required|string|max:355',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'sub_text.required' => 'The category is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
        		'sub_text.max' => 'The category may not be greater than 355 characters.',
			],
		],
		'reforma_feed_swipe' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'citim_version_2' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				'sub_text' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				'sub_text.required' => 'The sub_text is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
        		'sub_text.max' => 'The sub_text may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'reforma_web_news_story_2' => [
			'rules'=>[
				// 'title' => 'required|string|max:355',
				'sub_text' => 'required|string|max:355',
				// 'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				// 'title.required' => 'The title is required.',
				'sub_text.required' => 'The caption is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
				'sub_text.max' => 'The caption may not be greater than 355 characters.',
				// 'image.required' => 'image is required.',
				// 'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'reforma_news_feed' => [
			'rules'=>[
				'title' => 'required|string|max:355',
				// 'sub_text' => 'required|string|max:355',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'title.required' => 'The title is required.',
				// 'sub_text.required' => 'The category is required.',
				'title.max' => 'The title may not be greater than 355 characters.',
        		// 'sub_text.max' => 'The category may not be greater than 355 characters.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'reforma_web_news_story1' => [
			'rules'=>[
				// 'title' => 'required|string|max:355',
				// 'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				// 'title.required' => 'The title is required.',
				// 'title.max' => 'The title may not be greater than 355 characters.',
				// 'image.required' => 'image is required.',
				// 'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'reforma_web_news_story2' => [
			'rules'=>[
				// 'title' => 'required|string|max:355',
				// 'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				// 'title.required' => 'The title is required.',
				// 'title.max' => 'The title may not be greater than 355 characters.',
				// 'image.required' => 'image is required.',
				// 'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
		'reforma_logo_only' => [
			'rules'=>[
            	'logo_position' => 'required',
				'image'=> 'required|image|max:15000',
			],
			'msg'=>[
				'logo_position.required' => 'The logo_position is required.',
				'image.required' => 'image is required.',
				'image.max' => 'The image  may not be greater than 2048px.'
			],
		],
    ];

    return $formRules[$formType] ?? [];
}
?>
