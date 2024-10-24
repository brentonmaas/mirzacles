<div class="px-4 sm:px-6 lg:px-8">
    <!-- use error message blade -->
    <livewire:error-message />

    <!-- use success message blade -->
    <livewire:success-message />

    <!-- modal dialog for actions -->
    @if($modal['show'])
        <livewire:modal-dialog
            :show="$modal['show']"
            :route="$modal['route']"
            :userId="$modal['userId']"
            :method="$modal['method']"
            :title="$modal['title']"
            :text="$modal['text']"
            :button="$modal['button']"
        />
    @endif

    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-base font-semibold leading-6 text-white">Users</h1>
            <p class="mt-2 text-sm text-gray-300">A list of all the users in your account.</p>
        </div>
        @if($addUser)
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button wire:click="createUser" type="button" class="block rounded-md bg-indigo-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                    <i class="fa-solid fa-user-plus mr-1"></i>
                    Add user
                </button>
            </div>
        @endif
    </div>
    <div class="mt-8 flow-root scrollbar-thin" style="height:calc(100vh - 380px);overflow-x:hidden;overflow-y: auto;">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-700" >
                    <thead>
                    <tr>
                        @foreach($columns as $index => $column)
                            @switch($index)
                                @case('user')
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-0">{{ $column }}</th>
                                    @break
                                @case('actions')
                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-white sm:pl-0">{{ $column }}</th>
                                    @break
                                    @break
                                @default
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">{{ $column }}</th>
                                    @break
                            @endswitch
                        @endforeach
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">

                    @if(empty($rows))
                        <tr>
                            <td colspan="6" class="whitespace-nowrap px-3 py-2 text-sm text-gray-300">There are no results to display</td>
                        </tr>
                    @endif

                    @foreach($rows as $row)
                        <tr>
                            @foreach($columns as $index => $column)
                                @switch($index)
                                    @case('user')
                                        <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm font-medium text-white sm:pl-0">
                                            <div class="flex items-center">
                                                <div class="h-11 w-11 flex-shrink-0">
                                                    <img class="h-11 w-11 rounded-full" src="{{ $row['photo'] }}" alt="">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-300">{{ $row['user'] }}</div>
                                                    <div class="mt-1 text-gray-500">{{ $row['email'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        @break
                                    @case('actions')
                                        <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0 text-white">
                                            @foreach($actions as $action)
                                                @if($action['dialog'])
                                                    <div class="inline-block text-indigo-400 hover:text-{{ $action['hoverColor'] }} mr-2"
                                                         wire:click="showModal('{{ $action['route']}}', '{{ $row['id'] }}', '{{ $action['method'] }}')">
                                                        <i class="{{ $action['icon'] }}"></i>
                                                    </div>
                                                @else
                                                    @if($action['method'] == 'GET')
                                                        <div class="inline-block">
                                                            <a href="{{ route($action['route'], ['id' => $row['id']]) }}" class="text-indigo-400 hover:text-{{ $action['hoverColor'] }} mr-2">
                                                                <i class="{{ $action['icon'] }}"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <form action="{{ route($action['route'], ['id' => $row['id']]) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method($action['method'])
                                                            <button type="submit" class="btn btn-success text-indigo-400 hover:text-{{ $action['hoverColor'] }} mr-2"><i class="{{ $action['icon'] }}"></i></button>
                                                        </form>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        @break
                                    @default
                                        <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-300">{{ $row[$index]  }}</td>
                                        @break
                                @endswitch
                            @endforeach
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between bg-gray-800 border-t border-gray-900 px-4 py-3 sm:px-6 rounded-b-lg">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-300">
                    Showing
                    <span class="font-medium">{{ $pagination['from'] }}</span>
                    to
                    <span class="font-medium">{{ $pagination['to'] }}</span>
                    of
                    <span class="font-medium">{{ $pagination['total'] }}</span>
                    results
                </p>
            </div>
            <div>
                @if($pagination['total'] > 0)
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm bg-gray-900 text-white" aria-label="Pagination">

                        @if($currentPage == 1)
                            <div class="relative inline-flex items-center rounded-l-md px-3 py-2 rounded inset-0 focus:z-20 focus:outline-offset-0 text-gray-800">
                                <i class="fa-solid fa-angle-left"></i>
                            </div>
                        @else
                            <div wire:click="previousPage" class="relative inline-flex items-center rounded-l-md px-3 py-2 hover:bg-gray-700 rounded inset-0 focus:z-20 focus:outline-offset-0 cursor-pointer">
                                <i class="fa-solid fa-angle-left"></i>
                            </div>
                        @endif

                        @if($pagination['jump_first'])
                            <div wire:click="changePage(1)" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold hover:bg-gray-700 rounded inset-0 focus:z-20 focus:outline-offset-0 cursor-pointer">1</div>
                            <div class="relative inline-flex items-center px-3 py-2 text-sm font-semibold text-gray-500 rounded inset-0 focus:z-20 focus:outline-offset-0">...</div>
                        @endif

                        @foreach($pagination['pages'] as $page)
                            @if($page == $currentPage)
                                <div aria-current="page" class="relative z-10 inline-flex items-center bg-indigo-600 rounded inset-0 px-4 py-2 text-sm font-semibold focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{ $page }}</div>
                            @else
                                <div wire:click="changePage({{ $page }})" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold hover:bg-gray-700 rounded inset-0 focus:z-20 focus:outline-offset-0 cursor-pointer">{{ $page }}</div>
                            @endif
                        @endforeach

                        @if($pagination['jump_last'])
                            <div class="relative inline-flex items-center px-3 py-2 text-sm font-semibold text-gray-500 rounded inset-0 focus:z-20 focus:outline-offset-0">...</div>
                            <div wire:click="changePage({{ $pagination['total_pages'] }})" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold hover:bg-gray-700 rounded inset-0 focus:z-20 focus:outline-offset-0 cursor-pointer">{{ $pagination['total_pages'] }}</div>
                        @endif

                        @if($currentPage == $pagination['total_pages'])
                            <div class="relative inline-flex items-center px-3 py-2 rounded inset-0 focus:z-20 focus:outline-offset-0 text-gray-800">
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                        @else
                            <div wire:click="nextPage" class="relative inline-flex items-center rounded-r-md px-3 py-2 hover:bg-gray-700 rounded inset-0 focus:z-20 focus:outline-offset-0 cursor-pointer">
                                <i class="fa-solid fa-angle-right"></i>
                            </div>
                        @endif

                    </nav>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function openModal(route, id, method) {
            console.log("Opening modal with:", route, id, method);
            Livewire.emit('openModal', route, id, method);
        }

        document.addEventListener('livewire:load', function () {
            Livewire.on('triggerModal', (route, id, method) => {
                openModal(route, id, method);
            });
        });
    </script>
@endpush


