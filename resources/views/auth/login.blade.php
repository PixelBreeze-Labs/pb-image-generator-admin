<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>Login</title>
    <link rel="icon" type="image/png" href="assets/images/logo/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/rt-plugins.css">
    <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
    <link rel="stylesheet" href="/assets/css/app.css">
    <!-- START : Theme Config js-->
    <script src="{{ secure_asset('assets/js/settings.js') }}" sync></script>
    <!-- END : Theme Config js-->
</head>

<body class="font-inter bg-[#EEF1F9] custom-tippy dashcode-app light">
    <div id="root" class="h-full">
        <main class="App  relative">
            <div class="Toastify"></div>
            <div class="loginwrapper">
                <div class="lg-inner-column">
                    <div class="left-column relative z-[1]">
                    </div>
                    <div class="right-column relative">
                        <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                            <div class="auth-box h-full flex flex-col justify-center">
                                <div class="mobile-logo text-center mb-6 lg:hidden block"><a href="/"><img
                                            src="{{ asset('/assets/images/logo/logo-c.svg') }}" style="height: 5vh; width: auto;" alt="" class="mx-auto"></a></div>
                                <div class="text-center 2xl:mb-10 mb-4">
                                    <h4 class="font-medium">Sign in</h4>
                                    <div class="text-slate-500 text-base">Sign in to your account to start using
                                        PixelBreeze</div>
                                </div>
                                <form class="space-y-4 " action="{{ route("login-post") }}" method="POST">
                                    @csrf
                                    <div class="fromGroup       "><label
                                            class="block capitalize form-label  ">email</label>
                                        <div class="relative "><input type="email" name="email"
                                                class="  form-control py-2 h-[48px]  " placeholder="Email"
                                                value="">
                                            <div
                                                class="flex text-xl absolute ltr:right-[14px] rtl:left-[14px] top-1/2 -translate-y-1/2  space-x-1 rtl:space-x-reverse">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="fromGroup       "><label
                                            class="block capitalize form-label  ">password</label>
                                        <div class="relative "><input type="password" name="password"
                                                class="  form-control py-2 h-[48px]  " placeholder="Password"
                                                value="">
                                            <div
                                                class="flex text-xl absolute ltr:right-[14px] rtl:left-[14px] top-1/2 -translate-y-1/2  space-x-1 rtl:space-x-reverse">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="flex justify-between">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" class="hidden">
                                            <span class="h-4 w-4 border flex-none border-slate-100 dark:border-slate-800 rounded inline-flex ltr:mr-3 rtl:ml-3 relative transition-all duration-150 bg-slate-100 dark:bg-slate-600 dark:border-slate-600"></span>
                                            <span class="text-slate-500 dark:text-slate-400 text-sm leading-6 capitalize">Keep me signed in</span>
                                            </label>
                                        <a class="text-sm text-slate-800 dark:text-slate-400 leading-6 font-medium"  href="/forgot-password">Forgot Password? </a>
                                    </div> --}}
                                    <button type="submit"class="btn btn inline-flex justify-center btn btn-dark block w-full text-center ">
                                        <span class="flex items-center">
                                            <span>Sign in</span>
                                        </span>
                                    </button>
                                </form>
                                {{-- <div class="relative border-b-[#9AA2AF] border-opacity-[16%] border-b pt-6">
                                    <div
                                        class="absolute inline-block bg-white dark:bg-slate-800 dark:text-slate-400 left-1/2 top-1/2 transform -translate-x-1/2 px-4 min-w-max text-sm text-slate-500 font-normal">
                                        Or continue with</div>
                                </div> --}}
                                {{-- <div class="max-w-[242px] mx-auto mt-8 w-full">
                                    <ul class="flex">
                                        <li class="flex-1"><a href="#"
                                                class="inline-flex h-10 w-10 bg-[#1C9CEB] text-white text-2xl flex-col items-center justify-center rounded-full"><img
                                                    src="{{ asset('/assets/tw.8afd612b.svg') }}" alt=""></a></li>
                                        <li class="flex-1"><a href="#"
                                                class="inline-flex h-10 w-10 bg-[#395599] text-white text-2xl flex-col items-center justify-center rounded-full"><img
                                                    src="{{ asset('/assets/fb.f4743ced.svg') }}" alt=""></a></li>
                                        <li class="flex-1"><a href="#"
                                                class="inline-flex h-10 w-10 bg-[#0A63BC] text-white text-2xl flex-col items-center justify-center rounded-full"><img
                                                    src="{{ asset('/assets/in.3ad0732e.svg') }}" alt=""></a></li>
                                        <li class="flex-1"><a href="#"
                                                class="inline-flex h-10 w-10 bg-[#EA4335] text-white text-2xl flex-col items-center justify-center rounded-full"><img
                                                    src="{{ asset('/assets/gp.d450a6e0.svg') }}" alt=""></a></li>
                                    </ul>
                                </div> --}}
                                {{-- <div
                                    class="md:max-w-[345px] mx-auto font-normal text-slate-500 dark:text-slate-400 mt-12 uppercase text-sm">
                                    Don’t have an account? <a
                                        class="text-slate-900 dark:text-white font-medium hover:underline"
                                        href="/register">Sign up</a></div> --}}
                            </div>
                            <div class="auth-footer text-center">Copyright 2023, PixelBreeze All Rights Reserved.</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>



</body>
