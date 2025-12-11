<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $article->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Article Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                                {{ $article->title }}
                            </h1>
                            <p class="text-gray-500 text-sm">
                                By <span class="font-semibold text-gray-700">{{ $article->author->name }}</span>
                                • {{ $article->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            @if ($article->is_published)
                                <span class="inline-block px-4 py-2 bg-green-100 text-green-800 rounded-lg text-sm font-medium">
                                    Published
                                </span>
                            @else
                                <span class="inline-block px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg text-sm font-medium">
                                    Draft
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Article Content -->
                <div class="p-6">
                    <div class="prose max-w-none">
                        <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-wrap">
                            {{ $article->content }}
                        </p>
                    </div>
                </div>

                <!-- Article Footer -->
                <div class="p-6 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $article->author->name }}</p>
                            <p class="text-sm text-gray-500">{{ $article->author->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="px-6 py-4 bg-white border-t border-gray-200 flex items-center gap-4">
                    <a href="{{ route('articles.edit', $article) }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        Edit
                    </a>
                    <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Are you sure you want to delete this article?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Delete
                        </button>
                    </form>
                    <a href="{{ route('articles.index') }}" class="ml-auto px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition font-medium">
                        Back to Articles
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

