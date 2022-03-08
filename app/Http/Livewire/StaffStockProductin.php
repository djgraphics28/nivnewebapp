<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StaffStockProductin extends Component
{

    use WithPagination;
    public $searchTerm;

    public $supplier_id;
    public $product_id;
    public $branch_id;
    public $qty;
    public $price;
    public $selling_price;
    public $price_per_pcs;
    public $selling_per_pcs;
    public $date_delivered;
    public $expr_date;
    public $stock_code;
    public $categories;
    public $brands;
    public $classification;
    public $sortByCategory = NULL;
    public $sortByBrand = NULL;
    public $sortByUnit = NULL;
    public $perPage = 5;

    public $updateMode = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'supplier_id' => 'required',
        'product_id' => 'required',
        'qty' => 'required',
        'price' => 'required',
        'selling_price' => 'required',
        'stock_code' => 'required',
        'classification' => 'required',
    ];

    public function mount()
    {
        $this->categories = Category::all();
        $this->brands = Brand::all();
        $this->suppliers = Supplier::all();
    }

    public function selectProduct($id)
    {
        // dd('here');

        $this->product_id = $id;

        $product = Product::findOrFail($this->product_id);

        $stock = Stock::all();

        if(count($stock) > 0){
            $string = Stock::latest()->first()->stock_code;
            $id = substr($string, -7, 7);

            $newID = $id+1;
            $newID = str_pad($newID, 7, '0', STR_PAD_LEFT);
            $newID = "BIN-SI-".substr($product->product_name,0,4)."-".$newID;
        }else{
            $newID = "BIN-SI-".substr($product->product_name,0,4)."-0000001";
        }



        // echo "BIN-SI-".$newID;
        $this->stock_code = $newID;
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
            'classification' => 'required',
        ]);

        $stock = Stock::create([
            'supplier_id' => $this->supplier_id,
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'price' => $this->price,
            'selling_price' => $this->selling_price,
            'price_per_pcs' => $this->price_per_pcs,
            'selling_per_pcs' => $this->selling_per_pcs,
            'stock_code' => $this->stock_code,
            'created_by' => Auth::user()->name,
            'status' => 'pending',
            'branch_id' => Auth::user()->branch_id,
            'classi' => 1,
            'date_delivered' => $this->date_delivered,
            'expr_date' => $this->expr_date,
            'classification' => $this->classification,
        ]);

        // dd($stock);
        // // Stock::create($validateData);

        $this->dispatchBrowserEvent('hide-stock-productin-modal');

        session()->flash('message', 'Stock Data Successfully Added!');

        return redirect()->back();

        $this->resetInputFields();
    }

    private function resetInputFields(){
        $this->supplier_id = '';
        $this->product_id = '';
        $this->qty = '';
        $this->price = '';
        $this->selling_price = '';
        $this->stock_code = '';
        $this->date_delivered = '';
        $this->expr_date = '';
        $this->price_per_pcs = '';
        $this->selling_per_pcs = '';
        $this->classification = '';
    }

    public function cancel()
    {
        // $this->updateMode = false;
        $this->resetInputFields();
    }

    public function render()
    {
        // $suppliers = Supplier::all();
        // $searchTerm = '%'.$this->searchTerm.'%';
        // return view('livewire.staff-stock-productin',[
        //     'products' => Product::where('product_name','like', $searchTerm)
        //                 ->orWhere('sku','like', $searchTerm)
        //                 ->latest()->paginate(5)
        // ]);
        $branch_id = Auth::user()->branch_id;

        $products = Product::where('branch_id','=', $branch_id)
                ->when($this->sortByBrand, function($query){
                    $query->where('brand_id', $this->sortByBrand);
                    })
                ->when($this->sortByCategory, function($query){
                    $query->where('category_id', $this->sortByCategory);
                    })
                ->when($this->sortByUnit, function($query){
                    $query->where('unit', $this->sortByUnit);
                    })
                ->search(trim($this->searchTerm))
                ->paginate($this->perPage);

        return view('livewire.staff-stock-productin',[
            'products' => $products,
        ]);
    }
}
