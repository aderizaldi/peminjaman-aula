<?php

namespace App\Livewire\Pages;

use App\Enums\HallStatus;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Hall as HallModel;
use Livewire\WithoutUrlPagination;

class Hall extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id = null;
    public $name = '';
    public $description = '';
    public $status = HallStatus::ACTIVE;

    public $search = '';
    public $per_page = 10;

    public $modal = [
        'create' => false,
        'update' => false,
        'delete' => false
    ];

    public function openModal($modal, $id = null)
    {
        if ($modal == 'delete' && $id) {
            $this->id = $id;
        } else if ($modal == 'update' && $id) {
            $hall = HallModel::find($id);
            $this->id = $id;
            $this->name = $hall->name;
            $this->description = $hall->description;
            $this->status = $hall->status;
        }
        $this->modal[$modal] = true;
    }

    public function closeModal($modal)
    {
        $this->modal[$modal] = false;
    }

    public function resetForm()
    {
        $this->reset(['name', 'description', 'status']);
    }

    public function getHalls()
    {
        $query = HallModel::query();

        if ($this->search) {
            $query = $query->where('name', 'like', '%' . $this->search . '%')->orWhere('description', 'like', '%' . $this->search . '%')->orWhere('status', 'like', '%' . $this->search . '%');
        }

        $query = $query->latest();

        return $query->paginate($this->per_page);
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
        ]);

        HallModel::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status
        ]);

        $this->closeModal('create');
        $this->resetForm();
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil ditambahkan.');
    }

    public function update($id)
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable',
            'status' => 'required',
        ]);

        $hall = HallModel::find($id);
        $hall->update([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status
        ]);

        $this->closeModal('update');
        $this->resetForm();
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil diubah.');
    }

    public function delete($id)
    {
        $hall = HallModel::find($id);
        $hall->delete();

        $this->closeModal('delete');
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.pages.hall', [
            'halls' => $this->getHalls()
        ]);
    }
}
