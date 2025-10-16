<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use App\Models\Image as ModelsImage;
use Illuminate\Support\Facades\Storage;

class Image extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;

    public $id;
    public $name;
    public $image;

    public $modal = [
        'create' => false,
        'delete' => false
    ];

    public $search;
    public $per_page = 10;

    public function openModal($modal, $id = null)
    {
        if ($modal == 'delete' && $id) {
            $this->id = $id;
        }
        $this->modal[$modal] = true;
    }

    public function closeModal($modal)
    {
        $this->modal[$modal] = false;
    }

    public function resetForm()
    {
        $this->reset(['name', 'image']);
    }
    public function getImages()
    {
        $query = ModelsImage::query();

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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = ModelsImage::create([
            'name' => $this->name,
            'image' => $this->image->store('images'),
        ]);

        $this->closeModal('create');
        $this->resetForm();
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil ditambahkan.');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = ModelsImage::find($this->id);
        $old_image = $image->image;
        $image->name = $this->name;

        if ($this->image != $old_image) {
            $image->image = $this->image->store('images');
            Storage::delete($old_image);
        }

        $image->save();

        $this->closeModal('update');
        $this->resetForm();
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil diubah.');
    }

    public function delete()
    {
        $image = ModelsImage::find($this->id);
        $image->delete();

        $this->closeModal('delete');
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.pages.image', [
            'images' => $this->getImages()
        ]);
    }
}
