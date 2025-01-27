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
    <link rel="stylesheet" href="/assets/css/app.css">
    <!-- START : Theme Config js-->
    <script src="{{ asset('assets/js/settings.js') }}" sync></script>
    <!-- END : Theme Config js-->

    <style>
            .radio-group {
                margin: auto;
                display: inline-block;
                margin: 20px;
                overflow: hidden;
            }

            input[type=radio] {
                position: absolute;
                visibility: hidden;
                display: none;
            }
            input[type=checkbox], input[type=radio] {
                box-sizing: border-box;
                padding: 0;
            }

            input[type=radio]:checked + label {
                color: rgb(254, 254, 255);
                  background: #0f3dea;
                  border: solid 1px white;
                  border-radius: 6px;
            }

            input[type=radio]:not(checked) + label {
                color: #4e70fa;
                background: #f20cf900;
                border: solid 1px #4e70fa;
                border-radius: 5px;
            }
            .radio-group label {
                min-width: 95px;
                color: white;
                display: inline-block;
                cursor: pointer;
                padding: 5px 30px;
                margin: 2px;
            }
    </style>

</head>

<body class=" font-inter skin-default">
    <!-- [if IE]> <p class="browserupgrade"> You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security. </p> <![endif] -->
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
                                    <div class="row">
                                        <!-- Loader -->
                                        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
                                            <!-- Basic Inputs -->
                                            <div class="card">
                                                <div class="card-body flex flex-col p-6">
                                                    <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                                                        <div class="flex-1">
                                                            <div class="card-title text-slate-900 dark:text-white">Web News</div>
                                                        </div>
                                                    </header>
                                                    <form action="{{route('dashboard.store')}}" method="post" id="imageSubmitform">
                                                        @csrf
                                                        <input type="hidden" class="hidden" name="template_type" value="{{$templateData['template_type']}}">
                                                        <div class="card-text h-full space-y-4 text-center">
                                                            <div class="flex items-center space-x-7 flex-wrap justify-center">
                                                                <div class="basicRadio">
                                                                    <label class="flex items-center cursor-pointer">
                                                                        <input type="radio" class="hidden" name="crop_mode" value="square" checked>
                                                                        <span class="flex-none bg-white dark:bg-slate-500 rounded-full border inline-flex ltr:mr-2 rtl:ml-2 relative transition-all duration-150 h-[16px] w-[16px] border-slate-400 dark:border-slate-600 dark:ring-slate-700"></span>
                                                                        <span class="text-secondary-500 text-sm leading-6 capitalize">Square</span>
                                                                    </label>
                                                                </div>
                                                                <div class="basicRadio">
                                                                    <label class="flex items-center cursor-pointer">
                                                                        <input type="radio" class="hidden" name="crop_mode" value="portrait">
                                                                        <span class="flex-none bg-white dark:bg-slate-500 rounded-full border inline-flex ltr:mr-2 rtl:ml-2 relative transition-all duration-150 h-[16px] w-[16px] border-slate-400 dark:border-slate-600 dark:ring-slate-700"></span>
                                                                        <span class="text-secondary-500 text-sm leading-6 capitalize">Portrait</span>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <div class="input-area">
                                                                <div class="filegroup">
                                                                    <label>
                                                                        <input type="file" class=" w-full hidden" name="image">
                                                                        <span class="w-full h-[40px] file-control flex items-center custom-class">
                                                                            <span class="flex-1 overflow-hidden text-ellipsis whitespace-nowrap">
                                                                                <span class="text-slate-400">Choose a file or drop it here...</span>
                                                                            </span>
                                                                            <span class="file-name flex-none cursor-pointer border-l px-4 border-slate-200 dark:border-slate-700 h-full inline-flex items-center bg-slate-100 dark:bg-slate-900 text-slate-600 dark:text-slate-400 text-sm rounded-tr rounded-br font-normal">Browse</span>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="input-area text-center">
                                                                <label for="description" class="form-label">Logo Position * </label>
                                                                <div class="radio-group" name="position" style="margin: 0px;">
                                                                    <input type="radio" value="1" name="logo_position" id="1479">
                                                                    <label for="1479">1</label>
                                                                    <input type="radio" value="2" name="logo_position" id="1480">
                                                                    <label for="1480">2</label>
                                                                    <input type="radio" value="3" name="logo_position" id="1481">
                                                                    <label for="1481">3</label>
                                                                    <input type="radio" value="4" name="logo_position" id="1482" checked="checked">
                                                                    <label for="1482">4</label>
                                                                    <input type="radio" value="5" name="logo_position" id="1483">
                                                                    <label for="1483">5</label>
                                                                    <input type="radio" value="6" name="logo_position" id="1484">
                                                                    <label for="1484">6</label>
                                                                    <input type="radio" value="7" name="logo_position" id="1485">
                                                                    <label for="1485">7</label>
                                                                </div>
                                                            </div>

                                                            <p>Fields marked with * are required!</p>
                                                            <hr />
                                                            <button id="submitBtn" class="btn inline-flex justify-center btn-outline-primary">Create Image</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                            <!-- Sized Inputs -->
                                            <div class="card">
                                                <div class="card-body flex flex-col p-6">
                                                    <div class="card-text h-full">
                                                        <h6 class="block text-base text-center font-medium tracking-[0.01em] dark:text-slate-300 text-slate-500 uppercase mb-6">PREVIEW</h6>
                                                        <div class="flex justify-center">
                                                            <img src="{{ asset('images/'.$templateData['image']) }}" class="rounded-md" alt="image" id="NewImgSet">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
    </main>
    <!-- scripts -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/rt-plugins.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.js"></script>
    <script>
        $(document).ready(function () {
            $('#imageSubmitform').submit(function () {
                $('#submitBtn').attr('disabled',true);
                $('#AjaxLoaderDiv').fadeIn('slow');

                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    success: function (result)
                    {
                        $('#submitBtn').attr('disabled',false);
                        $('#AjaxLoaderDiv').fadeOut('slow');
                        if (result.status == 1) {
                            $("#NewImgSet").attr("src", result.img);
                            $("#NewImgSet").show();
                        } else {
                            $.bootstrapGrowl(result.msg, {type: 'danger error-msg', delay: 4000});
                        }
                    },
                    error: function (error)
                    {
                        $('#submitBtn').attr('disabled',false);
                        $('#AjaxLoaderDiv').fadeOut('slow');
                        $.post('/log-error', {
                            error: error,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        });
                        $.bootstrapGrowl("Internal Server Error!", {type: 'danger error-msg', delay: 4000});
                    }
                });

                return false;
            });
        });
    </script>
</body>

</html>
