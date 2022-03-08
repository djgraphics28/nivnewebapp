<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Stock;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Supplier;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StaffProduct extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $product_name;
    public $sku;
    public $description;
    // public $branch_id;
    public $category_id;
    public $brand_id;
    public $is_active;
    public $stockalert;

    public $searchTerm;
    public $updateMode = false;
    public $product;
    public $product_id;
    public $deleteproduct_id = null;

    public $sortByCategory = NULL;
    public $sortByBrand = NULL;
    public $sortByUnit = NULL;
    public $perPage = 5;

    public $hisProd = [];

    // public $brands;
    public $suppliers;
    public $classification;
    // public $unit;


    // protected $rules = [
    //     'product_name' => 'required',
    //     'sku' => 'required|unique:products',
    //     'description' => 'required',
    //     'category_id' => 'required',
    //     'brand_id' => 'required',
    //     'unit' => 'required',
    // ];
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        // $this->suppliers = Supplier::all();
    }
    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-product-modal');
    }

    public function submit()
    {
        // $validateData = $this->validate();

        // // $validateData['image_url'] = 'public/photo';

        // $validateData['branch_id'] = Auth::user()->branch_id;

        // Product::create($validateData);

        $validateData = $this->validate([
            'product_name' => 'required',
            'sku' => 'required|unique:products',
            'description' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
        ]);

        $product = Product::create([
            'product_name' => $this->product_name,
            'sku' => $this->sku,
            'description' => $this->description,
            'branch_id' => Auth::user()->branch_id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'unit' => $this->unit,
            'stockalert' => $this->stockalert,
            'image_url' => 'public/photo',
        ]);

        // if($product){
            $this->dispatchBrowserEvent('hide-product-modal');

            session()->flash('message', 'New Product Data Successfully Added!');

            return redirect()->back();
        // }

    }

    private function resetInputFields(){
        $this->product_name = '';
        $this->sku = '';
        $this->description = '';
        // $this->branch_id = '';
        $this->unit = '';
        $this->category_id = '';
        $this->brand_id = '';
        $this->stockalert = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function productStocks()
    {
        $stocks = Product::withSum('stock','qty')->get();

        dd($stocks);
    }

    public function edit($id)
    {
        // dd($id);
        $this->dispatchBrowserEvent('show-product-modal');
        $product = Product::findOrFail($id);

        // dd($product);
        $this->product_id = $id;
        $this->product_name = $product->product_name;
        $this->sku = $product->sku;
        $this->description = $product->description;
        // $this->branch_id = $product->branch_id;
        $this->unit = $product->unit;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->stockalert = $product->stockalert;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'product_name' => 'required',
            'sku' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = Product::find($this->product_id);
        $product->update([
            'product_name' => $this->product_name,
            'sku' => $this->sku,
            'description' => $this->description,
            'unit' => $this->unit,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'stockalert' => $this->stockalert,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-product-modal');

        session()->flash('message', 'Product Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deleteproduct_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Product::destroy($this->deleteproduct_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Product Data has been deleted.');

        $this->resetInputFields();
    }

    public function showStocksHistory($id)
    {
        // dd('here');
        $this->dispatchBrowserEvent('show-staff-stock-history-modal');

        $hisProd = Stock::where('product_id','=', $id)->get();

        $this->hisProd = $hisProd;

        // dd($hisProd);
    }



    public function render()
    {
        $branch_id = Auth::user()->branch_id;

        $branches = Branch::all();
        $brands = Brand::all();
        $categories = Category::all();

        // $products = Product::query()->with('stocks','qty')->get();
        // dd($products)

        $products = Product::with('stock'
                // ['stock' => function($query) {
                //     // $query->where('classi', 1);
                // }],
                // ['price' => function($query) {
                //     // $query->where('classi', 1);
                // }],
                // 'qty',
                // 'price_per_case',
                // 'price_per_pcs'
            )
        ->where('branch_id','=', $branch_id)
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

        return view('livewire.staff-product',[
            'products' => $products,
            'branches' => $branches,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }


}
