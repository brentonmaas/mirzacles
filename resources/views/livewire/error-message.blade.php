<div>
    @if (session('error'))
        <div class="flex items-center bg-red-600 border border-red-700 text-white px-4 py-3 rounded relative mb-7" role="alert">
            <div class="flex h-8 w-8 rounded-full text-white bg-red-950 justify-center items-center">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div class="flex grow text-white font-semibold justify-left items-left ml-3">
                {{ session('error') }}
            </div>
            <div wire:click="clearErrors" class="flex text-base text-white hover:text-gray-200 font-semibold justify-right text-right items-center cursor-pointer">
                <div class="inline-block align-middle">Close</div>
                <div class="inline-block align-middle ml-2" style="font-size:24px">
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>
        </div>
   @endif
</div>

