<aside
        class="fixed top-0 left-0 z-40 w-screen md:w-96 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        tabindex="-1" 
        aria-label="Sidenav"
        id="drawer-navigation"
    >
        <div class="overflow-y-auto py-2  h-full bg-white dark:bg-gray-800">
        
            <div class="fixed top-0 right-4 left-1 bg-gray-800 p-2">
                <div class="flex items-center justify-between p-2 mb-2">
                    <a href="https://github.com/twinklescode" class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Twinkles Code</a>

                    <button id="userMenuButton" data-dropdown-toggle="userMenu" data-dropdown-placement="bottom-start" class="inline-flex  rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"></path>
                        </svg>
                    </button>

                    <div id="userMenu" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-600 dark:divide-gray-600">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="userMenuButton">
                            <li>
                                <a href="{{ route('profile') }}"  class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('Profile') }}</a>
                            </li>
                            <li>
                                <a wire:click='logout' class="cursor-pointer block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('Log Out') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form action="#" method="GET" class="mb-2">
                    <label for="sidebar-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div
                        class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none"
                        >
                        <svg
                            class="w-5 h-5 text-gray-500 dark:text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            ></path>
                        </svg>
                        </div>
                        <input
                            wire:model.live='search'
                            type="text"
                            name="search"
                            id="sidebar-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Search"
                        />
                    </div>
                </form>
            </div>

            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 space-y-0 mt-28">
                @php($i=0)
                @foreach($models as $row)
                @php($i++)
                    <li wire:key='{{ $row->id }}' class="py-3 sm:py-4 {{ $isActiveChat==$row->id ? 'bg-slate-700' : '' }} px-3 cursor-pointer">
                        <a 
                        class="flex items-center" 
                        data-drawer-target="drawer-navigation"
                        data-drawer-hide="drawer-navigation"
                        data-drawer-backdrop="false"
                        data-drawer-body-scrolling="true"
                        aria-controls="drawer-navigation"
                        wire:click='chat({{ $row->id }})'
                        >
                            <div class="flex-shrink-0">
                                <img class="w-8 h-8 rounded-full" src="https://avatars.githubusercontent.com/u/167683279?v=4" alt="Neil image">
                            </div>
                            <div class="flex-1 min-w-0 ms-4">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $row->name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ $row->email }}
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">{{$i}}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
                
            </ul>

            @if($models->hasMorePages())
                <div x-intersect="$wire.loadMore()"></div>
            @endif
        </div>
    
    </aside>