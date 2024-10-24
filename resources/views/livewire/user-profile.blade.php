<div class="bg-gray-900">
    <div class="mx-auto max-w-7xl">
        <div class="bg-gray-900 py-10">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-white">User Information</h3>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-400">Personal details of selected user.</p>
                </div>
                <div class="mt-6 flex">
                    <div class="mr-10 py-4">
                        <img class="max-h-80 rounded-md" src="{{ $user->avatar }}" alt="{{ $fullname }}">
                    </div>
                    <div class="border-t border-white/10 grow">
                        <dl class="divide-y divide-white/10">
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Full name</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $fullname }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Username</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->name }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Email address</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->email }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Prefix Name</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->prefixname }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Suffix Name</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->suffixname }}</dd>
                            </div>
                            <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                <dt class="text-sm font-medium leading-6 text-white">Type</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-400 sm:col-span-2 sm:mt-0">{{ $user->type }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none ml-auto float-right">
                    <button wire:click="backToUsers" type="button" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                        Back To Users
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


