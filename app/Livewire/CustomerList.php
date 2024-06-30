<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Customer;

class CustomerList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $customers = Customer::withCount('AddressBooks')->paginate(10);
        return view('livewire.customer-list', ['customers' => $customers]);
    }
}
