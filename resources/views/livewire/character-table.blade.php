<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Listado de Personajes</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nombre</th>
                <th class="py-2 px-4 border-b">Estado</th>
                <th class="py-2 px-4 border-b">Especie</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($characters as $character)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $character->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $character->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $character->status }}</td>
                    <td class="py-2 px-4 border-b">{{ $character->species }}</td>
                    <td class="py-2 px-4 border-b">
                        <button wire:click="editCharacter({{ $character->id }})" class="bg-blue-500 text-white px-2 py-1 rounded">
                            Editar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Enlaces de paginación -->
    <div class="mt-4">
        {{ $characters->links() }}
    </div>

    <!-- Formulario de edición -->
    @if ($editingCharacter)
        <div class="mt-4 p-4 bg-gray-100 rounded shadow">
            <h3 class="text-xl font-bold mb-4">Editar Personaje</h3>
            
            <!-- Nombre -->
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" id="name" wire:model.defer="editingCharacter.name" class="border p-2 my-2 w-full" placeholder="Nombre del personaje">

            <!-- Estado -->
            <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
            <select id="status" wire:model.defer="editingCharacter.status" class="border p-2 my-2 w-full">
                <option value="">Selecciona un estado</option>
                <option value="Alive">Vivo</option>
                <option value="Dead">Muerto</option>
                <option value="unknown">Desconocido</option>
            </select>

            <!-- Especie -->
            <label for="species" class="block text-sm font-medium text-gray-700">Especie</label>
            <input type="text" id="species" wire:model.defer="editingCharacter.species" class="border p-2 my-2 w-full" placeholder="Especie del personaje">

            <!-- Tipo (opcional) -->
            <label for="type" class="block text-sm font-medium text-gray-700">Tipo</label>
            <input type="text" id="type" wire:model.defer="editingCharacter.type" class="border p-2 my-2 w-full" placeholder="Tipo (opcional)">

            <!-- Género -->
            <label for="gender" class="block text-sm font-medium text-gray-700">Género</label>
            <select id="gender" wire:model.defer="editingCharacter.gender" class="border p-2 my-2 w-full">
                <option value="">Selecciona un género</option>
                <option value="Male">Masculino</option>
                <option value="Female">Femenino</option>
                <option value="Genderless">Sin género</option>
                <option value="unknown">Desconocido</option>
            </select>

            <!-- Origen: nombre -->
            <label for="origin_name" class="block text-sm font-medium text-gray-700">Origen</label>
            <input type="text" id="origin_name" wire:model.defer="editingCharacter.origin_name" class="border p-2 my-2 w-full" placeholder="Origen del personaje">

            <!-- Origen: URL -->
            <label for="origin_url" class="block text-sm font-medium text-gray-700">URL de Origen</label>
            <input type="text" id="origin_url" wire:model.defer="editingCharacter.origin_url" class="border p-2 my-2 w-full" placeholder="URL del origen">

            <!-- Imagen -->
            <label for="image" class="block text-sm font-medium text-gray-700">Imagen URL</label>
            <input type="text" id="image" wire:model.defer="editingCharacter.image" class="border p-2 my-2 w-full" placeholder="URL de la imagen">

            <div class="flex items-center mt-4">
                <button wire:click="updateCharacter" class="bg-green-500 text-white px-4 py-2 rounded">
                    Actualizar
                </button>
                <button wire:click="$set('editingCharacter', null)" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">
                    Cancelar
                </button>
            </div>
        </div>
    @endif
</div>
