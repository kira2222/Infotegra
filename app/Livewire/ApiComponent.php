<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use App\Models\Character;
use Livewire\Component;

class ApiComponent extends Component
{
    public $allData = [];      // Contendrá los 20 registros devueltos por la API
    public $page = 1;          // Página global de la API (cada una retorna 20 registros)
    public $localPage = 1;     // Página local (1 o 2, para mostrar 10 registros por "página")
    public $selectedCharacter = null;

    public function mount()
    {
        $this->callApi();
    }

    /**
     * Realiza la petición a la API y carga 20 registros.
     */
    public function callApi()
    {
        $response = Http::get("https://rickandmortyapi.com/api/character/?page={$this->page}");
        if ($response->successful()) {
            $data = $response->json();
            $this->allData = $data['results']; // Se esperan 20 registros
            $this->localPage = 1; // Reinicia la paginación local al cargar una nueva página de la API
        } else {
            session()->flash('error', 'Error al obtener los datos de la API.');
        }
    }

    /**
     * Devuelve 10 registros, dependiendo del valor de $localPage.
     */
    public function getPaginatedData()
    {
        $chunks = array_chunk($this->allData, 10);
        return $chunks[$this->localPage - 1] ?? [];
    }

    /**
     * Avanza a la siguiente página local o, si ya está en la última de la API, carga la siguiente página global.
     */
    public function nextLocalPage()
    {
        if ($this->localPage < 2) {
            $this->localPage++;
        } else {
            if ($this->page < 5) { // Suponiendo 5 páginas como máximo
                $this->page++;
                $this->callApi();
            }
        }
    }

    /**
     * Retrocede a la página local anterior o, si es la primera, carga la página anterior de la API.
     */
    public function previousLocalPage()
    {
        if ($this->localPage > 1) {
            $this->localPage--;
        } else {
            if ($this->page > 1) {
                $this->page--;
                $this->callApi();
                // Al cargar una nueva página de la API, se muestran los últimos 10 registros locales
                $this->localPage = 2;
            }
        }
    }

    /**
     * Asigna el personaje seleccionado a la propiedad $selectedCharacter para mostrar sus detalles.
     */
    public function selectCharacter($character)
    {
        $this->selectedCharacter = $character;
    }

    /**
     * Guarda en la base de datos los 100 registros obtenidos (5 páginas de la API).
     */
    public function saveAllToDatabase()
    {
        $allCharacters = [];
        $maxPages = 5; // Suponemos que hay 5 páginas en la API (100 registros en total)

        for ($p = 1; $p <= $maxPages; $p++) {
            $response = Http::get("https://rickandmortyapi.com/api/character/?page={$p}");
            if ($response->successful()) {
                $data = $response->json();
                // Combina los registros de cada página
                $allCharacters = array_merge($allCharacters, $data['results']);
            } else {
                session()->flash('error', "Error al obtener los datos de la API en la página {$p}");
                return;
            }
        }

        // Guardar o actualizar cada personaje en la base de datos evitando duplicados
        foreach ($allCharacters as $character) {
            Character::updateOrCreate(
                ['id' => $character['id']], // Evita duplicados
                [
                    'name'        => $character['name'],
                    'status'      => $character['status'],
                    'species'     => $character['species'],
                    'type'        => $character['type'] ?? null,
                    'gender'      => $character['gender'],
                    'origin_name' => $character['origin']['name'],
                    'origin_url'  => $character['origin']['url'] ?? null,
                    'image'       => $character['image'],
                ]
            );
        }

        session()->flash('message', 'Los 100 registros se han guardado en la base de datos.');
    }

    public function render()
    {
        return view('livewire.api-component');
    }
}
