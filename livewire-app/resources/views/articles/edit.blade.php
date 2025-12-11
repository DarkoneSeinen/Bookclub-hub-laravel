<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('articles.update', $article) }}">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-6">
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $article->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div class="mb-6">
                        <x-input-label for="content" :value="__('Content')" />
                        <textarea id="content" name="content" rows="8" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 disabled:border-gray-200" required>{{ old('content', $article->content) }}</textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <!-- Published -->
                    <div class="mb-6">
                        <label for="is_published" class="inline-flex items-center">
                            <input id="is_published" type="checkbox" name="is_published" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                            <span class="ms-2 text-sm text-gray-600">{{ __('Publish this article') }}</span>
                        </label>
                        <x-input-error :messages="$errors->get('is_published')" class="mt-2" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Update Article') }}</x-primary-button>
                        <a href="{{ route('articles.index') }}" class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</x-app-layout>
