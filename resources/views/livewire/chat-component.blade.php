<section>
    <div style="overscroll-behavior: none;">
        <div class="fixed w-full bg-green-400 h-16 pt-2 text-white flex justify-between shadow-md"
            style="top:0px; overscroll-behavior: none;">
            <!-- back button -->
            <a href="{{ route('dashboard') }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-12 h-12 my-1 text-green-100 ml-2">
                    <path class="text-green-100 fill-current"
                        d="M9.41 11H17a1 1 0 0 1 0 2H9.41l2.3 2.3a1 1 0 1 1-1.42 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.42 1.4L9.4 11z" />
                </svg>
            </a>
            <div class="my-3 text-green-100 font-bold text-lg tracking-wide">{{ $user->name }}</div>
            <!-- 3 dots -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-dots-vertical w-8 h-8 mt-2 mr-2">
                <path class="text-green-100 fill-current" fill-rule="evenodd"
                    d="M12 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
            </svg>
        </div>

        <div class="mt-20 space-y-4">
            @foreach ($messages as $message)
                @if ($message['sender'] === auth()->user()->name)
                    <!-- Sender's message -->
                    <div class="flex justify-end">
                        <div
                            class="bg-green-500 text-white mx-4 my-2 pl-3 rounded-2xl shadow-lg break-words pr-10 py-2">

                            <p class="mt-1"><span
                                    class="text-blue-200 mr-2 font-semibold">{{ $message['sender'] }}:</span>{{ $message['message'] }}
                            </p>
                            <small
                                class="block float-left text-gray-200 text-xs mt-2 text-right">{{ $message['created_at'] }}</small>
                        </div>
                    </div>
                @else
                    <!-- Receiver's message -->
                    <div class="flex justify-start">
                        <div
                            class="bg-gray-200 text-gray-800 mx-4 my-2 pl-3 rounded-2xl shadow-lg break-words pr-10 py-2">

                            <p class="mt-1"><span
                                    class=" text-red-600 mr-2 font-semibold">{{ $message['sender'] }}:</span>{{ $message['message'] }}
                            </p>
                            <small
                                class="block text-gray-600 text-xs mt-2 text-left">{{ $message['created_at'] }}</small>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="h-16"></div>
    <div id="last-message"></div>

    <form wire:submit.prevent="sendMessage">
        <div class="fixed w-full flex justify-between bg-green-100" style="bottom: 0px;">
            <textarea class="flex-grow m-2 py-2 px-4 mr-1 rounded-full border border-gray-300 bg-gray-200 resize-none"
                rows="1" placeholder="Message..." style="outline: none;" wire:model="message"></textarea>
            <button class="m-2" type="submit" style="outline: none;">
                <svg class="svg-inline--fa text-green-400 fa-paper-plane fa-w-16 w-12 h-12 py-2 mr-2" aria-hidden="true"
                    focusable="false" data-prefix="fas" data-icon="paper-plane" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z" />
                </svg>
            </button>
        </div>
    </form>
</section>
