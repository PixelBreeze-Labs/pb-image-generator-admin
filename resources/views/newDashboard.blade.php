<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<title>Pixel breeze</title>
	<link rel="icon" type="image/png" href="assets/images/logo/favicon.svg">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/rt-plugins.css">
	<link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
	<link rel="stylesheet" href="assets/css/app.css">
	<!-- START : Theme Config js-->
	<script src="{{ asset('assets/js/settings.js') }}" sync></script>
	<!-- END : Theme Config js-->
</head>

<body>
	<!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
		<style>
			.bg-image11{
				height: 40vh; 
				display: flex;
				flex-direction: column; 
				justify-content: space-between;
				background-size: contain;
				background-repeat: no-repeat;
			}

			.task_body_cont{
				float: left;
				width: 100%;
				display: block;
				margin-top: 10px;
				margin-bottom: 25px;
			}

			.task_footer_cont{
				width: 100%;
				height: 50px;
				display: block;
				text-align: center;
				margin-top: 25px;
				position: absolute;
				bottom: 50px;
				right: 50%;
				transform: translate(50%,50%);
			}

			.task_action_btn {
				text-align: right;
				cursor: pointer;
				font-size: 16px;
				color: #fff;
				padding: 12px 30px;
				-webkit-border-radius: 30px;
				-moz-border-radius: 30px;
				border-radius: 30px;
				border: 1px solid transparent;
				-webkit-transition: 0.3s;
				-moz-transition: 0.3s;
				-o-transition: 0.3s;
				transition: 0.3s;
				background: transparent;
				color: white;
				border: 1px solid white;
				display: inline-block;
			}

			.task_action_btn:hover {
			  color: var(--main-gradient-color) !important;
			  background: white;
			}

			.descriptive_label{
				color: white;
				font-size: 10px;
				margin: 0;
				line-height: normal;
			}

			.main_label{
				color: white;
				font-size: 18px;
				font-weight: 600;
				line-height: normal;
			}

			.shadow{
				text-shadow: 0px 0px 10px #000000;
			}
			
			.finished_task:hover{
				background-color: transparent;
			}

			.card_shadow{
				box-shadow: rgba(0,0,0,0) 0px 0px 0rem;
				transition: all 0.2s ease-in-out;
			}

			.card_shadow:hover{
				box-shadow: rgba(0,0,0,0.4) -2px 2px 1rem;
				transition: all 0.2s ease-in-out;
			}
			/*
			.zoom_up{
				transform: scale(1);
				transition: all 0.2s ease-in-out;
			}
			.zoom_up:hover{
				transform: scale(1.05);
				transition: all 0.2s ease-in-out;
			}*/

			.prising_area .single_prising {
			    position: relative;
			    border-radius: 15px;
			    padding: 29px 23px;
			    margin-bottom: 30px;
			    overflow: auto;
			    min-height: 400px;
			}

			.card_img_bg {
			    position: absolute;
			    width: 100%;
			    height: 100%;
			    top: 0;
			    left: 0;
			    z-index: -2;
			    background-size: cover !important;
			    background-position: center center !important;
			}
			.card_gradient_bg {
			    position: absolute;
			    width: 100%;
			    height: 100%;
			    top: 0;
			    left: 0;
			    background-size: cover !important;
			    background-position: center center !important;
			    background: linear-gradient(to bottom, rgba(87,44,131,0.6) 0%, rgba(47,7,67,1));
			    z-index: -1;
			}

		</style>
	<main class="app-wrapper">
		<div class="flex flex-col justify-between min-h-screen">
			<div class="">
				<div class="content-wrapper transition-all duration-150 ltr:ml-[50px] rtl:mr-[50px]" id="content_wrapper">
					<div class="page-content">
						<div class="transition-all duration-150 container-fluid" id="page_layout">
							<div id="content_layout">
								<!-- BEGIN: Breadcrumb -->
								<div class="mb-5">
									<ul class="m-0 p-0 list-none">
										<li class="inline-block relative text-sm text-primary-500 font-Inter ">
											Pixel breeze
										</li>
									</ul>
								</div>
								<!-- END: BreadCrumb -->

								<div class="container">
									<div id="AjaxLoaderDiv" style="display: none;z-index:99999 !important;">
										<div style="width:100%; height:100%; left:0px; top:0px; position:fixed; opacity:0; filter:alpha(opacity=40); background:#000000;z-index:999999999;">
										</div>
										<div style="float:left;width:100%; left:50%; top:50%; text-align:center; position:fixed; padding:0px; z-index:999999999;">
											<img src="{{ asset('/images/ajax-loader.gif') }}" />
										</div>
									</div>
									<div class="grid md:grid-cols-4 sm:grid-cols-2 grid-cols-2 gap-5 prising_area">
										@foreach($templateName as $templateId => $row)
											@php $image = asset('/images/'.$row['image']); @endphp
											
											<div class="col-xl-3 col-md-6 col-lg-6 zoom_up">

												<div project_id="814" class="single_prising finished_task card_shadow">
													<div class="card_bg">
														<div class="card_img_bg" style="background-image: url('{{ $image }}');"></div>
														<div class="card_gradient_bg" style="background: linear-gradient(rgba(87, 44, 131, 0) 20%, rgb(47, 7, 67)); opacity: 1;">
														</div>
													</div>

													<div class="task_body_cont" style="opacity: 1;">
														<p class="descriptive_label shadow">Template Name:</p>
														<p class="main_label shadow">{{ $row['name'] }}</p>
													</div>
													<div class="task_footer_cont">
														<a class="task_action_btn" href="{{ route('dashboard.template', ['p_id' => $templateId]) }}">Create Image</a>
													</div>
												</div>
						                    </div>
										@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- BEGIN: Footer For Desktop and tab -->
			<footer class="md:block hidden" id="footer">
				<div class="site-footer px-6 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 py-4 ltr:ml-[50px] rtl:mr-[50px]">
					<div class="grid md:grid-cols-2 grid-cols-1 md:gap-5">
						<div class="text-center ltr:md:text-start rtl:md:text-right text-sm">
							COPYRIGHT ©
							<span id="thisYear"></span>
						</div>
					</div>
				</div>
			</footer>
			<!-- END: Footer For Desktop and tab -->
		</div>
	</main>
</body>

</html>