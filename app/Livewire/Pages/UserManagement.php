<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class UserManagement extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $id = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'user';

    public $search = '';
    public $perPage = 10;

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
            $user = User::find($id);
            $this->id = $id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->getRoleNames()[0];
        }
        $this->modal[$modal] = true;
    }

    public function closeModal($modal)
    {
        $this->modal[$modal] = false;
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'role']);
    }

    public function getUsers()
    {
        $query = User::query()->withoutRole('admin');

        if ($this->search) {
            $query = $query->where('name', 'like', '%' . $this->search . '%')->orWhere('email', 'like', '%' . $this->search . '%')->orWhere('role', 'like', '%' . $this->search . '%');
        }

        // sort operator, user
        $query = $query->latest();

        return $query->paginate($this->perPage);
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::min(8)],
            'password_confirmation' => 'required|same:password',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        $user->assignRole($this->role);

        $this->closeModal('create');
        $this->resetForm();
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil ditambahkan.');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'role' => 'required'
        ]);

        $user = User::find($this->id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        if ($this->password) {
            $this->validate([
                'password' => ['required', Password::min(8)],
                'password_confirmation' => 'required|same:password'
            ]);
            $user->update([
                'password' => Hash::make($this->password)
            ]);
        }

        $user->syncRoles($this->role);

        $this->closeModal('update');
        $this->resetForm();
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil diubah.');
    }

    public function delete()
    {
        $user = User::find($this->id);
        $user->delete();

        $this->closeModal('delete');
        $this->dispatch('showToast', status: 'success', message: 'Data berhasil dihapus.');
    }


    public function render()
    {
        return view('livewire.pages.user-management', [
            'users' => $this->getUsers()
        ]);
    }
}
