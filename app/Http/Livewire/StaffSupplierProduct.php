<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;
use App\Models\SupplierProduct;
use Illuminate\Support\Facades\Auth;

class StaffSupplierProduct extends Component
{
    use WithPagination;
    // public $id;
    public $supplier_id;
    public $supplier_products;

    public $inputs = [0];
    public $i = 1;

    public $searchTerm;
    public $products;
    public $product_id, $quantity, $product_amount;

    protected $paginationTheme = 'bootstrap';

    public function mount($supplier_id)
    {
       $this->supplier_id = $supplier_id;

       $this->supplier_products = Supplier::with('products')
            ->where('id','=',$supplier_id)->get();

       $this->products = Product::where('branch_id','=',Auth::user()->branch_id)->get();
    }

    public function addNew()
    {
        // dd('here');
        $this->dispatchBrowserEvent('show-add-supplier-product-modal');
    }

    public function addItem($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function removeItem($i)
    {
        unset($this->inputs[$i]);
    }

    public function submit()
    {
        $validateData = $this->validate([
            'product_id.0' => 'required',
        ]);

        foreach ($this->product_id as $key => $value) {
            SupplierProduct::create([
                'product_id' => $this->product_id[$key],
                'supplier_id' => $this->supplier_id,
                'branch_id' => Auth::user()->branch_id,
            ]);
        }

        $this->inputs = [0];

        $this->resetInputFields();
        $this->dispatchBrowserEvent('hide-add-supplier-product-modal');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'New Receipt Data Successfully Added!',
            'text' => 'You can add products to this receipt data.'
        ]);

        $this->mount($this->supplier_id);
    }

    private function resetInputFields(){
        $this->product_id = '';

    }


    public function render()
    {
        return view('livewire.staff-supplier-product');
    }
}
