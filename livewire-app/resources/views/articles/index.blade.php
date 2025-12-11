<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Articles list') }}
        </h2>
    </x-slot>


    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <br>
        </br>

        <div class="max-w-7xl mx-auto w-full">
            <a href="{{ route('articles.create') }}" class="inline-block px-6 py-2 mt-4 font-medium text-sm text-white bg-blue-600 rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 transition duration-150">
                + Create Article
            </a>
        </div>

        <div class="overflow-hidden max-w-7xl mx-auto w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
            <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                    <tr>
                        <th scope="col" class="p-4 font-semibold">Article ID</th>
                        <th scope="col" class="p-4">Title</th>
                        <th scope="col" class="p-4">Author</th>
                        <th scope="col" class="p-4">Published</th>
                        <th scope="col" class="p-4">Created At</th>
                        <th scope="col" class="p-4">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline dark:divide-outline-dark">
                    @forelse ($articles as $article)
                        <tr>
                            <td class="p-4">{{ $article->id }}</td>
                            <td class="p-4">{{ $article->title }}</td>
                            <td class="p-4">{{ $article->author->name }}</td>
                            <td class="p-4">{{ $article->is_published ? 'Yes' : 'No' }}</td>
                            <td class="p-4">{{ $article->created_at }}</td>
                            <td class="flex items-center p-4 space-x-3">
                                <a href="{{ route('articles.edit', $article) }}" class="font-medium text-primary underline-offset-2 hover:underline focus:underline focus:outline-hidden dark:text-primary-dark">
                                    Edit
                                </a>
                                <a href="{{ route('articles.show', $article) }}" class="font-medium text-primary underline-offset-2 hover:underline focus:underline focus:outline-hidden dark:text-primary-dark">
                                    View
                                </a>
                                <form
                                    method="POST"
                                    action="{{ route('articles.destroy', $article) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this article?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="cursor-pointer font-medium text-danger underline-offset-2 hover:underline focus:underline focus:outline-hidden dark:text-primary-dark"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td class="p-4" colspan="6">No Data</td>
                        </tr
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="max-w-7xl mx-auto w-full mt-4">
            {{ $articles->links() }}
        </div>
    </div>

    
</x-app-layout>
