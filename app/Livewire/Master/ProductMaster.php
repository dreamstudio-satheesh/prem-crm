<?php

namespace App\Livewire\Master;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductMaster extends Component
{
    use WithPagination;

    public $product_id;
    public $name, $description, $price;
    public $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'nullable|numeric',
    ];

    public function render()
    {
        $products = Product::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.master.product-master', compact('products'));
    }

    public function resetInputFields()
    {
        $this->product_id = null;
        $this->name = '';
        $this->description = '';
        $this->price = null;
    }

    public function store()
    {
        $this->authorizeAdmin();

        $this->validate();

        Product::updateOrCreate(['id' => $this->product_id], [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        $this->resetInputFields();
        $this->dispatch('show-toastr', ['message' => 'Product '.($this->product_id ? 'Updated' : 'Created').' Successfully.']);
    }

    public function edit($id)
    {
        $this->authorizeAdmin();

        $product = Product::findOrFail($id);
        $this->product_id = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
    }

    public function delete($id)
    {
        $this->authorizeAdmin();

        Product::findOrFail($id)->delete();
        session()->flash('success', 'Product Deleted Successfully.');
        $this->dispatch('$refresh');
    }

    public function create()
    {
        $this->resetInputFields();
    }

    private function authorizeAdmin()
    {
        if (auth()->user()->role->name != 'Admin') {
            abort(403, 'Unauthorized action.');
        }
    }
}
