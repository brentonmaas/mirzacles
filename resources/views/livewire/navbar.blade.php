<nav class="bg-gray-800">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <!--
                      Icon when menu is closed.

                      Menu open: "hidden", Menu closed: "block"
                    -->
                    <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!--
                      Icon when menu is open.

                      Menu open: "block", Menu closed: "hidden"
                    -->
                    <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="Mirzacles">
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        @foreach($navMenu as $item)
                            @if($item['label'] == $currentNav)
                                <div wire:click="{{ $item['handler'] }}"
                                     class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white"
                                     style="cursor:pointer;"
                                     role="menuitem"
                                     tabindex="-1"
                                     aria-current="page"
                                     id="nav-menu-item-{{ $item['label'] }}"
                                >
                                    {{ $item['label'] }}
                                </div>
                            @else
                                <div wire:click="{{ $item['handler'] }}"
                                     class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                                     style="cursor:pointer;"
                                     role="menuitem"
                                     tabindex="-1"
                                     id="nav-menu-item-{{ $item['label'] }}"
                                >
                                    {{ $item['label'] }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-20 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                <!-- Profile dropdown -->
                <div class="relative ml-3" x-data="{ open: false }" @click.away="open = false">
                    <div>
                        <button @click="open = !open" type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            <div class="flex h-12 w-12 rounded-full text-white" style="font-size:18px;align-items:center;justify-content:center;">
                                <img src="{{ $profileImage }}" alt="Profile Image" class="h-12 w-12 rounded-full" />
                            </div>
                        </button>
                    </div>

                    <div x-show="open" x-data="{ highlight: false }" class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none " role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        @foreach($profileMenu as $item)
                            <div wire:click="{{ $item['handler'] }}"
                                 onmouseover="highlightNavbarMenuItem(this)"
                                 onmouseout="normalNavbarMenuItem(this)"
                                 class="block px-4 py-2 text-sm text-gray-700"
                                 style="cursor:pointer;"
                                 role="menuitem"
                                 tabindex="-1"
                                 id="profile-menu-item-{{ $item['label'] }}"
                            >
                                {{ $item['label'] }}
                            </div>
                        @endforeach
                    </div>

                    <script>
                        function highlightNavbarMenuItem(el) {
                            el.classList.add('bg-gray-400');
                            el.classList.add('text-white');
                        }

                        function normalNavbarMenuItem(el) {
                            el.classList.remove('bg-gray-400');
                            el.classList.remove('text-white');
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Dashboard</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projects</a>
            <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>
        </div>
    </div>
</nav>
