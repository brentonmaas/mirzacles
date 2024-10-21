<div class="bg-gray-900">
    <div class="mx-auto max-w-7xl">
        <div class="bg-gray-900 py-10">
            <div class="px-4 sm:px-6 lg:px-8">

                @if ($errors->any())
                    <div class="bg-red-400 border border-red-400 text-white px-4 py-3 rounded relative mb-8" role="alert">
                        <strong class="font-bold">Whoops!</strong>
                        <span class="block">There were some problems with your input.</span>
                        <ul class="mt-3 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form enctype=multipart/form-data action="{{ route('users.update', $user['id']) }}" method="POST">
                    @csrf
                    <div class="space-y-12">
                        <div class="border-b border-white/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-white">User Form</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-400">This information will be displayed publicly so be careful what you share.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <!-- Username -->
                                <div class="sm:col-span-3">
                                    <label for="username" class="block text-sm font-medium leading-6 text-white">Username</label>
                                    <div class="mt-2">
                                        <div class="flex rounded-md bg-white/5 ring-1 ring-inset ring-white/10 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500">
                                            <input type="text" name="username" id="username" value="{{ $user['name'] }}" required autocomplete="username" class="flex-1 border-0 bg-transparent py-1.5 pl-1 text-white focus:ring-0 sm:text-sm sm:leading-6" placeholder="janesmith">
                                        </div>
                                    </div>
                                </div>

                                <!-- Type -->
                                <div x-data="{ open: false }" @click.away="open = false" class="col-span-2">
                                    <label for="type" class="block text-sm font-medium leading-6 text-white">Type</label>
                                    <div class="relative mt-2">
                                        <input id="type" name="type" type="text" readonly value="{{ $user['type'] }}" class="w-full rounded-md border-0 bg-white/5 py-1.5 pl-3 pr-12 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" role="combobox" aria-controls="options" aria-expanded="false">
                                        <button @click="open = !open" type="button" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd" d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <ul x-show="open" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox">
                                            @foreach($userTypes as $type)
                                                <li wire:click="setType('{{ $type }}')" @click="open = !open" class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-gray-600 hover:bg-gray-400 hover:text-white" id="option-0" role="option" tabindex="-1">
                                                    <span class="block truncate">{{ $type }}</span>

                                                    @if($user['type'] == $type)
                                                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="sm:col-span-2">
                                    <label for="password" class="block text-sm font-medium leading-6 text-white">Password</label>
                                    <div class="mt-2">
                                        <input id="password" name="password" type="password" value="password" autocomplete="new-password" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="confirm_password" class="block text-sm font-medium leading-6 text-white">Confirm Password</label>
                                    <div class="mt-2">
                                        <input id="confirm_password" name="confirm_password" type="password" value="password" autocomplete="new-password" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="sm:col-span-4">
                                    <label for="email" class="block text-sm font-medium leading-6 text-white">Email address</label>
                                    <div class="mt-2">
                                        <input id="email" name="email" type="email" value="{{ $user['email'] }}" required autocomplete="email" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <!-- Photo -->
                                <div class="col-span-full">
                                    <label for="photo" class="block text-sm font-medium leading-6 text-white">Photo</label>
                                    <div class="mt-2 flex items-center gap-x-3">
                                        @if ($photo)
                                            <img src="{{ $photo->temporaryUrl() }}" alt="Photo Preview" class="h-20 w-20 rounded-full" />
                                        @else
                                            @if($user['profile_photo_path'])
                                                <img src="{{ $user['profile_photo_path'] }}" alt="User Photo" class="h-20 w-20 rounded-full" />
                                            @else
                                                <svg class="h-20 w-20 text-gray-500" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                    <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" />
                                                </svg>
                                            @endif
                                        @endif

                                        <!-- Hidden file input -->
                                        <input type="file" id="photo" wire:model="photo" name="photo" class="hidden" accept="image/*">

                                        <button type="button" onclick="document.getElementById('photo').click()" class="rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/20">Change</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="border-b border-white/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-white">Personal Information</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-400">Use a permanent address where you can receive mail.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="sm:col-span-2">
                                    <label for="firstname" class="block text-sm font-medium leading-6 text-white">First name</label>
                                    <div class="mt-2">
                                        <input type="text" name="firstname" id="firstname" required value="{{ $user['firstname'] }}" autocomplete="given-name" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="middlename" class="block text-sm font-medium leading-6 text-white">Middle name</label>
                                    <div class="mt-2">
                                        <input type="text" name="middlename" id="middlename" value="{{ $user['middlename'] }}" autocomplete="middle-name" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="lastname" class="block text-sm font-medium leading-6 text-white">Last name</label>
                                    <div class="mt-2">
                                        <input type="text" name="lastname" id="lastname" required value="{{ $user['lastname'] }}" autocomplete="family-name" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </div>
                                </div>

                                <!-- prefix names -->
                                <div x-data="{ open: false }" @click.away="open = false" class="sm:col-span-2">
                                    <label for="prefixname" class="block text-sm font-medium leading-6 text-white">Prefix Name</label>
                                    <div class="relative mt-2">
                                        <input id="prefixname" name="prefixname" type="text" readonly value="{{ $user['prefixname'] }}" class="w-full rounded-md border-0 bg-white/5 py-1.5 pl-3 pr-12 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6" role="combobox" aria-controls="options" aria-expanded="false">
                                        <button @click="open = !open" type="button" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                <path fill-rule="evenodd" d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <ul x-show="open" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox">
                                            @foreach($prefixNames as $prefix)
                                                <li wire:click="setPrefixName('{{ $prefix }}')" @click="open = !open" class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-gray-600 hover:bg-gray-400 hover:text-white" id="option-0" role="option" tabindex="-1">
                                                    <span class="block truncate">{{ $prefix }}</span>

                                                    @if($user['prefixname'] == $prefix)
                                                        <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                                                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="suffixname" class="block text-sm font-medium leading-6 text-white">Suffix name</label>
                                    <div class="mt-2">
                                        <input type="text" name="suffixname" id="suffixname" value="{{ $user['suffixname'] }}" autocomplete="family-name" class="block w-full rounded-md border-0 bg-white/5 py-1.5 text-white shadow-sm ring-1 ring-inset ring-white/10 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-x-6">
                        <button type="button" class="text-sm font-semibold leading-6 text-white">Cancel</button>
                        <button type="submit" class="rounded-md bg-indigo-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
