<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserMaster extends Component
{
    use WithPagination;

    public $user_id;
    public $name, $email, $role, $password, $password_confirmation;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email',
        'role' => 'required|in:Admin,Sales,Support',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function render()
    {
        $users = User::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('email', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.user-master', compact('users'));
    }

    public function resetInputFields()
    {
        $this->user_id = null;
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function store()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
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
        $this->email = $user->email;
        $this->role = $user->role;
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
