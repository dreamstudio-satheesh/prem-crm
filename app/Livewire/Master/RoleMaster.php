<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Role;

class RoleMaster extends Component
{
    use WithPagination;

    public $role_id;
    public $name;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function render()
    {
        $roles = Role::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.role-master', compact('roles'))->extends('layouts.admin');
    }

    public function resetInputFields()
    {
        $this->role_id = null;
        $this->name = '';
    }

    public function store()
    {
        $this->validate();

        Role::updateOrCreate(['id' => $this->role_id], [
            'name' => $this->name,
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Role ' . ($this->role_id ? 'Updated' : 'Created') . ' Successfully.']);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->role_id = $role->id;
        $this->name = $role->name;
    }

    public function delete($id)
    {
        Role::findOrFail($id)->delete();
        session()->flash('success', 'Role Deleted Successfully.');
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
