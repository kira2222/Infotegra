<div class="container mx-auto p-4">
    @if (!empty($allData))
        <div class="flex flex-wrap -mx-2">
            @foreach ($this->getPaginatedData() as $character)
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-2">
                    <div class="bg-white rounded-lg shadow-md p-4 flex flex-col justify-between min-h-[250px] h-full">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $character['name'] }}</h3>
                            <p class="text-gray-600">ID: {{ $character['id'] }}</p>
                            <p class="text-gray-600">Status: {{ $character['status'] }}</p>
                            <p class="text-gray-600">Species: {{ $character['species'] }}</p>
                        </div>
                        <button wire:click="selectCharacter({{ json_encode($character) }})" 
                            class="bg-blue-500 text-white px-4 py-2 rounded mt-4 w-full">
                            Detalle
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center mt-4">
            <button wire:click="previousLocalPage" 
                @if($page == 1 && $localPage == 1) disabled @endif 
                class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50">
                Previous
            </button>
            
            <span>API Page: {{ $page }} - Local Page: {{ $localPage }}</span>
            
            <button wire:click="nextLocalPage" 
                @if($page == 5 && $localPage == 2) disabled @endif 
                class="bg-blue-500 text-white px-4 py-2 rounded disabled:opacity-50">
                Next
            </button>
        </div>
    @endif

    @if ($selectedCharacter)
        <div class="mt-4 p-4 bg-gray-100 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold">Detalles de {{ $selectedCharacter['name'] }}</h3>
            <p class="text-gray-600">Type: {{ $selectedCharacter['type'] }}</p>
            <p class="text-gray-600">Gender: {{ $selectedCharacter['gender'] }}</p>
            <p class="text-gray-600">Location: {{ $selectedCharacter['location']['name'] }}</p>
            <p class="text-gray-600">Location URL: <a href="{{ $selectedCharacter['location']['url'] }}" class="text-blue-500">{{ $selectedCharacter['location']['url'] }}</a></p>
            <img class="max-w-xs h-auto rounded-lg object-cover" src="{{ $selectedCharacter['image'] }}" alt="{{ $selectedCharacter['name'] }}">
        </div>
    @endif

    <div class="mt-4">
        <button wire:click="saveAllToDatabase" class="bg-green-500 text-white px-4 py-2 rounded mb-4">
            Guardar en Base de Datos
        </button>

        @if (session()->has('message'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <livewire:CharacterTable/>
</div>
