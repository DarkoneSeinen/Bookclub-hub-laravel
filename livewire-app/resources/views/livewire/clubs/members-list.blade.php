<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <div class="px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-900">Gestionar Miembros</h1>
                <p class="text-gray-600 text-sm">{{ $club->name }}</p>
            </div>
        </div>

        <!-- Búsqueda -->
        <div class="px-6 py-4 border-b border-gray-200">
            <input type="text" wire:model.live="search" placeholder="Buscar por nombre o email..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <!-- Tabla de Miembros -->
        <div class="overflow-x-auto">
            @if ($members->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    No hay miembros
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Usuario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rol</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Unido</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($members as $member)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        @if($member->avatar)
                                            <img src="{{ Storage::url($member->avatar) }}" alt="{{ $member->name }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-xs font-semibold text-blue-600">{{ $member->initials() }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $member->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $member->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($club->isOwner($member))
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Propietario
                                        </span>
                                    @else
                                        <select wire:change="updateRole({{ $member->id }}, $event.target.value)" 
                                                class="text-xs rounded border border-gray-300 focus:ring-2 focus:ring-blue-500">
                                            <option value="member" @selected($member->pivot->role === 'member')>Miembro</option>
                                            <option value="moderator" @selected($member->pivot->role === 'moderator')>Moderador</option>
                                        </select>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ is_string($member->pivot->joined_at) ? \Carbon\Carbon::parse($member->pivot->joined_at)->format('d/m/Y') : $member->pivot->joined_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if (!$club->isOwner($member))
                                        <button wire:click="removeMember({{ $member->id }})" wire:confirm="¿Expulsar a {{ $member->name }} del club?"
                                                class="text-red-600 hover:text-red-700 font-medium">
                                            Expulsar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Paginación -->
        @if ($members->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $members->links() }}
            </div>
        @endif

        <!-- Botón Volver -->
        <div class="px-6 py-4 border-t border-gray-200">
            <a href="{{ route('clubs.show', $club) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                ← Volver al Club
            </a>
        </div>
    </div>
</div>
