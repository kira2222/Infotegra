<?php

namespace App\Livewire;

use App\Models\Character;
use Livewire\Component;
use Livewire\WithPagination;

class CharacterTable extends Component
{
    use WithPagination;

    // Propiedad para almacenar el personaje que se está editando.
    public $editingCharacter = null;

    // Escucha el evento 'dataSaved' para refrescar la información.
    protected $listeners = ['dataSaved' => 'refreshData'];

    /**
     * Este método se ejecuta al montar el componente.
     * Se podría llamar a refreshData(), pero en este caso lo usaremos para resetear la paginación.
     */
    public function mount()
    {
        // Reseteamos la página para asegurarnos de cargar los datos actualizados.
        $this->resetPage();
    }

    /**
     * Método para refrescar la data.
     * En lugar de asignar Character::all() a una propiedad, simplemente reseteamos la página.
     * Esto hará que el método render() se ejecute nuevamente y obtenga los datos actualizados.
     */
    public function refreshData()
    {
        logger('Evento dataSaved recibido en CharacterTable');

        $this->resetPage();
    }

    /**
     * Carga el personaje a editar según su ID.
     *
     * @param int $id Identificador del personaje a editar.
     */
    public function editCharacter($id)
    {
        $character = Character::find($id);
        if ($character) {
            // Convertimos el modelo a array para facilitar el enlace con los inputs en la vista.
            $this->editingCharacter = $character->toArray();
        } else {
            session()->flash('error', 'Personaje no encontrado.');
        }
    }

    /**
     * Actualiza el personaje con los datos del formulario.
     * Valida los datos, busca el personaje en la BD, lo actualiza y limpia el formulario.
     */
    public function updateCharacter()
    {
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

        $character = Character::find($this->editingCharacter['id']);
        if ($character) {
            $character->update($this->editingCharacter);
            session()->flash('message', 'Personaje actualizado correctamente.');
        } else {
            session()->flash('error', 'No se encontró el personaje.');
        }

        // Limpiar el formulario de edición.
        $this->editingCharacter = null;
    }

    /**
     * Renderiza el componente.
     * Se obtiene un paginador con 10 registros por página.
     * Al llamar a $characters->links() en la vista, se mostrará la paginación.
     *
     * @return \Illuminate\View\View Vista del componente.
     */
    public function render()
    {
        // Se obtiene un paginador para asegurar que siempre se muestre la data actualizada.
        $characters = Character::paginate(10);
        return view('livewire.character-table', compact('characters'));
    }
}
