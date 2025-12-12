<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users | List') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-6">
                    <div class="overflow-hidden w-full overflow-x-auto rounded-radius border border-outline dark:border-outline-dark">
                        <table class="w-full text-left text-sm text-on-surface dark:text-on-surface-dark">
                            <thead class="border-b border-outline bg-surface-alt text-sm text-on-surface-strong dark:border-outline-dark dark:bg-surface-dark-alt dark:text-on-surface-dark-strong">
                                <tr>
                                    <th scope="col" class="p-4 font-semibold">User ID</th>
                                    <th scope="col" class="p-4">Name</th>
                                    <th scope="col" class="p-4">Email</th>
                                    <th scope="col" class="p-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline dark:divide-outline-dark">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="p-4">{{ $user->id }}</td>
                                        <td class="p-4">{{ $user->name }}</td>
                                        <td class="p-4">{{ $user->email }}</td>
                                        <td class="flex items-center p-4 space-x-3">
                                            <a href="{{ route('users.edit', $user) }}" class="font-medium text-primary underline-offset-2 hover:underline focus:underline focus:outline-hidden dark:text-primary-dark">
                                                Edit
                                            </a>
                                            <form
                                                method="POST"
                                                action="{{ route('users.destroy', $user) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this user?')"
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
                                        <td class="p-4" colspan="4">No Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
