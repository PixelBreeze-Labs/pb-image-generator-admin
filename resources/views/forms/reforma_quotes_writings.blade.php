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
        <label for="description" class="form-label">Title * </label>
        <textarea id="description" name="title" rows="5" class="form-control" placeholder="Title"></textarea>
    </div>
    <div class="input-area">
        <label for="name" class="form-label">Author * </label>
        <input id="name" name="sub_text" type="text" class="form-control" placeholder="Author">
    </div>   
    <p>Fields marked with * are required!</p>
    <hr />
    <button id="submitBtn" class="btn inline-flex justify-center btn-outline-primary">Create Image</button>
</div>
</body>