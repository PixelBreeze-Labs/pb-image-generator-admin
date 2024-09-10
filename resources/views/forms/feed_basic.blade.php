    <style>
        p {
            margin-bottom: 0 !important;
        }
    </style>
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
            <div class="basicRadio">
                <label class="flex items-center cursor-pointer">
                    <input type="radio" class="hidden" name="crop_mode" value="story">
                    <span class="flex-none bg-white dark:bg-slate-500 rounded-full border inline-flex ltr:mr-2 rtl:ml-2 relative transition-all duration-150 h-[16px] w-[16px] border-slate-400 dark:border-slate-600 dark:ring-slate-700"></span>
                    <span class="text-secondary-500 text-sm leading-6 capitalize">Story</span>
                </label>
            </div>
        </div>
        <div class="input-area">
                <label for="name" class="form-label">Article URL</label>
                <input id="name" type="text" class="form-control" placeholder="Article URL" disabled>
            </div>
            <div class="input-area">
                <label class="form-label">-OR-</label>
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
    
        <div class="input-area">
           

            <label for="description" class="form-label">Title * </label>
            <div class="alert alert-success light-mode suggestion" style="display: none;">
                <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <iconify-icon class="text-2xl flex-0" icon="system-uicons:target"></iconify-icon>
                    <p class="flex-1 font-Inter" style="cursor: pointer;" onclick="correctGrammar(this);">Did you mean: <span></span></p>
                    <div class="flex-0 text-xl cursor-pointer">
                        <iconify-icon icon="line-md:close" class="relative top-[4px]"></iconify-icon>
                    </div>
                </div>
            </div>
            <textarea id="description" name="title" rows="5" class="form-control text-suggest" placeholder="Title"></textarea>
            <button class="btn inline-flex justify-center btn-outline-success" type="button" style="margin-top: 0.5rem" onclick="checkSuggestion(this)"> 
                <span class="flex items-center">
                    <span>Spellcheck (GPT)</span>
                    <iconify-icon class="text-xl ltr:ml-2 rtl:mr-2" icon="heroicons-outline:newspaper"></iconify-icon>
                </span>
            </button>
            <button class="btn inline-flex justify-center btn-outline-success" type="button" style="margin-top: 0.5rem" onclick="checkSuggestion2(this)"> 
                <span class="flex items-center">
                    <span>Spellcheck (Other tool)</span>
                    <iconify-icon class="text-xl ltr:ml-2 rtl:mr-2" icon="heroicons-outline:newspaper"></iconify-icon>
                </span>
            </button>
        </div>
        <div class="input-area">
            <label for="name" class="form-label">Show Arrow? </label>
            <div class="radio-group" name="position" style="margin: 0px;">
                <input type="radio" value="show" name="show_arrow" id="show" checked="checked">
                <label for="show">Show</label>
                <input type="radio" value="hide" name="show_arrow" id="hide">
                <label for="hide">Hide</label>
            </div>
        </div>
        <p>Fields marked with * are required!</p>
        <hr />
        <button id="submitBtn" class="btn inline-flex justify-center btn-outline-primary">Create Image</button>
    </div>
</body>