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
        <label for="description" class="form-label">Location </label>
        <textarea id="description" name="title" rows="5" class="form-control" placeholder="Title"></textarea>
    </div>
    
    <p>Fields marked with * are required!</p>
    <hr />
    <button id="submitBtn" class="btn inline-flex justify-center btn-outline-primary">Create Image</button>
</div>