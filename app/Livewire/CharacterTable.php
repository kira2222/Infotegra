<?php

namespace App\Livewire;

use App\Models\Character;
use Livewire\Component;
use Livewire\WithPagination;

class CharacterTable extends Component
{
    use WithPagination;

    // Esta propiedad se usará para mostrar el formulario de edición
    public $editingCharacter = null;

    // Método para cargar un personaje en edición
    public function editCharacter($id)
    {
        $character = Character::find($id);
        if ($character) {
            // Convertimos el modelo a array para facilitar el enlace en la vista
            $this->editingCharacter = $character->toArray();
        } else {
            session()->flash('error', 'Personaje no encontrado.');
        }
    }

    // Actualiza el personaje utilizando los datos del formulario
    public function updateCharacter()
    {
        // Validación de los campos del formulario
        $this->validate([
            'editingCharacter.name'         => 'required|string|max:255',
            'editingCharacter.status'       => 'required|string',
            'editingCharacter.species'      => 'required|string',
            'editingCharacter.type'         => 'nullable|string',
            'editingCharacter.gender'       => 'required|string',
            'editingCharacter.origin_name'  => 'required|string',
            'editingCharacter.origin_url'   => 'nullable|url',
            'editingCharacter.image'        => 'nullable|url',
        ]);

        // Buscar el personaje en la base de datos
        $character = Character::find($this->editingCharacter['id']);
        if ($character) {
            $character->update($this->editingCharacter);
            session()->flash('message', 'Personaje actualizado correctamente.');
        } else {
            session()->flash('error', 'No se encontró el personaje.');
        }
        // Limpiar la variable de edición
        $this->editingCharacter = null;
    }

    public function render()
    {
        // Se obtienen 10 registros por página
        $characters = Character::paginate(10);
        return view('livewire.character-table', compact('characters'));
    }
}
