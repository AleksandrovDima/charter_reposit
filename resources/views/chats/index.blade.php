<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chats.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('Напиши здесь, о чем думаешь?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Отправить') }}</x-primary-button>
        </form>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($chats as $chat)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $chat->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chat->created_at->format('G:i, j.m.Y') }}</small>
                                @unless ($chat->created_at->eq($chat->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('изменено') }}</small>
                                @endunless
                            </div>
                            @if ($chat->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('chats.edit', $chat)">
                                            {{ __('Редактировать') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('chats.destroy', $chat) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('chats.destroy', $chat)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Удалить') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chat->message }}</p>
                    </div>
                </div>
            @endforeach
            <div>
                {{ $chats->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
