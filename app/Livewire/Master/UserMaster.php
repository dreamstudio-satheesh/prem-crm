<?php

namespace App\Livewire\Master;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class UserMaster extends Component
{
    use WithPagination;

    public $user_id;
    public $name, $username, $email, $role_id, $password, $password_confirmation;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'nullable|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'role_id' => 'required|exists:roles,id',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);
    
        $roles = Role::all();

       
    
        return view('livewire.master.user-master', compact('users', 'roles')); 
    }

    public function resetInputFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->role_id = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'password' => Hash::make($this->password),
        ];

        User::updateOrCreate(['id' => $this->user_id], $data);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'User '.($this->user_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();
        $this->dispatch('show-toastr', ['message' => 'User Deleted Successfully.']);
    }

    public function create()
    {
        $this->resetInputFields();
    }
}
