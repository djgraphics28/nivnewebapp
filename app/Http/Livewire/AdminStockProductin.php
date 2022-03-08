<?php

namespace App\Http\Livewire;

use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class AdminStockProductin extends Component
{

    use WithPagination;
    public $searchTerm;

    public $supplier_id;
    public $product_id;
    public $qty;
    public $price;
    public $selling_price;
    public $date_delivered;
    public $expr_date;
    public $stock_code;

    public $updateMode = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'supplier_id' => 'required',
        'product_id' => 'required',
        'qty' => 'required',
        'price' => 'required',
        'selling_price' => 'required',
        'stock_code' => 'required',
    ];

    public function selectProduct($id)
    {
        // dd('here');

        $this->product_id = $id;
        $this->dispatchBrowserEvent('show-stock-productin-modal');
    }

    public function submit()
    {

        $validateData = $this->validate([
            'supplier_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'selling_price' => 'required',
            'stock_code' => 'required',
        ]);

        $stock = Stock::create([
            'supplier_id' => $this->supplier_id,
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'price' => $this->price,
            'selling_price' => $this->selling_price,
            'stock_code' => $this->stock_code,
            'created_by' => 'darwin',
            'status' => 'pending',
            'branch_id' => 1,
            'classi' => 1,
            'date_delivered' => $this->date_delivered,
            'expr_date' => $this->expr_date,
        ]);

        // dd($stock);
        // // Stock::create($validateData);

        $this->dispatchBrowserEvent('hide-stock-productin-modal');

        session()->flash('message', 'Stock Data Successfully Added!');

        return redirect()->back();
    }

    public function render()
    {
        $suppliers = Supplier::all();
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.admin-stock-productin',[
            'products' => Product::where('product_name','like', $searchTerm)
                        ->orWhere('sku','like', $searchTerm)
                        ->latest()->paginate(5),
            'suppliers' => $suppliers
        ]);
    }
}
