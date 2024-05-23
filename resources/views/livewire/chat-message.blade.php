<div>
    @if($showChat)
        <header class="bg-white dark:bg-gray-800 shadow fixed left-0 md:left-96 right-0 md:z-40 z-0 ">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-4">
                <div class="flex items-center">
                    <button 
                        data-drawer-target="drawer-navigation"
                        data-drawer-show="drawer-navigation"
                        data-drawer-backdrop="false"
                        data-drawer-body-scrolling="true"
                        aria-controls="drawer-navigation"
                        class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        >
                        <svg
                            aria-hidden="true"
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                            fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"
                            ></path>
                        </svg>
                        <svg
                            aria-hidden="true"
                            class="hidden w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>

                    <div class="flex-shrink-0">
                        <img class="w-8 h-8 rounded-full" src="https://avatars.githubusercontent.com/u/167683279?v=4" alt="Neil image">
                    </div>
                    <div class="flex-1 min-w-0 ms-4">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                            {{ $userModel->name }}
                        </p>
                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                            {{ $userModel->email }}
                        </p>
                    </div>
                </div>
            </div>
        </header>

        
        <main class="md:ml-96 h-auto pt-12 bg-gray-900">

            <div class="grid grid-cols-1 sm:grid-cols-1 gap-4 mb-14 mt-8 p-5 pb-24">
                <div id="old_last">&nbsp;</div>

                @if($models->hasMorePages())
                    <div x-intersect.threshold.70="$wire.loadMore();$wire.dispatch('loadMore');"></div>
                    {{-- <button wire:click.prevent="loadMore" x-init='document.getElementById("old_last").scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" })''>Load more</button> --}}
                @endif

              

                @foreach($models->reverse()->values() as $row)
                {{-- <div id="message_{{ $row->id }}" wire:key='{{ $row->id }}' class="flex justify-end {{ $row->sender_id==auth()->id() ? '' : 'flex-row-reverse' }} flex-none gap-2.5 w-full" x-init='document.getElementById("message_last").scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" })'> --}}

                    <div id="message{{ $row->id }}" wire:key='{{ $row->id }}' class="flex justify-end {{ $row->sender_id==auth()->id() ? '' : 'flex-row-reverse' }} flex-none gap-2.5 w-full">
                        {{-- <img class="w-8 h-8 rounded-full" src="https://avatars.githubusercontent.com/u/167683279?v=4" alt="Jese image"> --}}
                        <div class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl dark:bg-gray-700">
                            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ optional($row->sender)->name }}</span>
                                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ date('d M Y H:i',strtotime($row->timestamp)) }}</span>
                            </div>
                            @if($row->parent)
                                <blockquote class="p-2 my-2 border-s-4 border-gray-300 bg-gray-50 dark:border-gray-500 dark:bg-gray-800">
                                    <span class="text-xs text-gray-900 dark:text-green-400">{{ $row->parent->sender->name==auth()->user()->name ? "You" : $row->parent->sender->name }}</span>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $row->parent->content }}</p>
                                </blockquote>
                            @endif
                            <p class="text-sm font-normal py-2.5 text-gray-900 dark:text-white">{{ $row->content }}</p>
                            {{-- <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Delivered</span> --}}
                        </div>
                        <button title="Test" id="dropdownMenuIconButton{{ $row->id }}" data-dropdown-toggle="dropdownDots{{ $row->id }}" data-dropdown-placement="bottom-start" class="inline-flex p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-900 dark:hover:bg-gray-800 dark:focus:ring-gray-600" type="button">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                                <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                            </svg>
                        </button>
                        <div id="dropdownDots{{ $row->id }}" class="z-50 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40 dark:bg-gray-600 dark:divide-gray-600">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton{{ $row->id }}">
                                <li>
                                    <button type="button" wire:click='reply({{ $row->id }})' @click='document.getElementById("message").focus();' class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reply</button>
                                </li>
                                <li>
                                    <button type="button" wire:click='remove({{ $row->id }})' class="{{ $row->sender_id==auth()->id() ? 'block' : 'hidden' }} px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="message_last">&nbsp;</div>


            <footer class="bg-white dark:bg-gray-800 shadow fixed bottom-0 md:left-96 left-0 right-0 z-0 p-2">
                <form wire:submit.prevent='send'>  

                    @if($targetMessageId)
                        <blockquote class="p-2 my-2 border-s-4 border-gray-300 bg-gray-50 dark:border-gray-500 dark:bg-gray-800">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-900 dark:text-green-400">{{ $targetSender==auth()->user()->name ? "You" : $targetSender }}</span>
                                <button wire:click='clearReply' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                           
                            
                            <p id="targetMessage" class="text-sm text-gray-900 dark:text-white">{{  $targetMessageText }}</p>
                        </blockquote>
                    @endif

                    <label for="send" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Send</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            {{-- <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg> --}}

                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-text" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                            </svg>
                        </div>
                        <input wire:model='targetMessageId' type="hidden" class="block w-full p-3 ps-10 text-sm text-gray-500 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type a message" autocomplete="false" />
                        <input wire:model='message' type="text" id="message" class="block w-full p-3 ps-10 text-sm text-gray-500 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type a message" autocomplete="false" />
                        <button type="submit" class="text-white absolute end-2.5 bottom-2 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send</button>
                    </div>
                </form>
              
            </footer>
        </main>
    
    @else

    <header class="bg-white dark:bg-gray-800 shadow fixed left-0 md:left-96 right-0 md:z-40 z-0 md:hidden">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-4">
            <div class="flex items-center">
                <button 
                    data-drawer-target="drawer-navigation"
                    data-drawer-toggle="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="p-2 mr-2 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >
                    <svg
                        aria-hidden="true"
                        class="w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                        fill-rule="evenodd"
                        d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                        clip-rule="evenodd"
                        ></path>
                    </svg>
                    <svg
                        aria-hidden="true"
                        class="hidden w-6 h-6"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                        fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                        ></path>
                    </svg>
                    <span class="sr-only">Toggle sidebar</span>
                </button>

            </div>
        </div>
    </header>
    
    <main class="md:ml-96 h-auto pt-14 bg-gray-900">

        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
                <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">We invest in the world’s potential</h1>
                <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">Here at Flowbite we focus on markets where technology, innovation, and capital can unlock long-term value and drive economic growth.</p>
                <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
                    <a href="#"
                    data-drawer-target="drawer-navigation"
                    data-drawer-toggle="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                        Get started
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

    </main>

    @endif
</div>

@script
<script>
    $wire.on('loadMore', (event) => {
        console.log('LOADMORE');
        setTimeout(function() {
            initDropdowns();
        }, 500);
    });

    $wire.on('open-chat', (event) => {
        // console.log(`room.${event.userId1}.${event.userId2}`);
        // window.Echo.private(`room.${event.userId1}.${event.userId2}`)
        console.log('EVENT',event);
      
        if(event.action=='init'){
            if(localStorage.getItem("old_channel")!=null){
                // Echo.disconnect();
                Echo.leave(localStorage.getItem("old_channel")); 
                console.log('LEAVE', localStorage.getItem("old_channel"));
                localStorage.setItem("old_channel", null);
            }
        }
   
       
        Echo.join(`room.${event.userId1}.${event.userId2}`)
        .here((users) => {
            console.log('USER HERE',users);
            localStorage.setItem("old_channel", `room.${event.userId1}.${event.userId2}`);
        })
        .joining((user) => {
            console.log('USER JOINING',user);
        })
        .leaving((user) => {
            console.log('USER LEAVING',user);
            localStorage.setItem("old_channel", null);
        })
        .error((error) => {
            console.error(error);
        });

        window.Echo.private(`room.${event.userId1}.${event.userId2}`).listen("PushMessage", (e) => {
            console.log("joining" + JSON.stringify(event));
            console.log(`room.${event.userId1}.${event.userId2}`);
            console.log(event);
            console.log(e);
            Livewire.dispatch('$refresh');
            $wire.dispatch('$refresh');
            $wire.dispatch('triggerMessage', e);

            setTimeout(function() {
                document.getElementById("message_last").scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });          
                initDropdowns();
            }, 500);
         
        });

        // window.Echo.join(`room.${event.userId1}.${event.userId2}`)
        //     .subscribed(()=>{
        //     window.livewire.dispatch('subscribed')
        //     })
        //     .here(users => {
        //     window.livewire.dispatch('here', users)
        //     })
        //     .joining(user => {
        //     window.livewire.dispatch('joining', user)
        //     console.log("joining" + JSON.stringify(user))
        //     })
        //     .leaving(user => {
        //     window.livewire.dispatch('leaving', user)
        //     console.log("joining" + JSON.stringify(user))
        //     })
        //     .listen('NewMessage', message => {
        //     window.livewire.dispatch('newMessage', message)
        //     console.log("newMessage" + JSON.stringify(message))
        //     })
        //     .listen('MessageDelete', data => {
        //     window.livewire.dispatch('removeMessage', data)
        //     console.log("deleteMessage" + JSON.stringify(data))
        //     })
        //     .error(error => {
        //     // sweetAlert(error)
        //     })

        setTimeout(function() {
            document.getElementById("message_last").scrollIntoView({ behavior: "smooth", block: "end", inline: "nearest" });          
            initDropdowns();
        }, 500);
    });

   
</script>
@endscript