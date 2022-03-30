<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Stock;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\PriceTbl;
use App\Models\Supplier;
use App\Models\ProductIn;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StaffProduct extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $deleteConfirmed;

    protected $listeners = ['remove'];

    public $stocks;
    public $product_name;
    public $sku;
    public $description;
    public $image_url;
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
    public $brands;
    public $categories;
    public $branches;
    public $classification;
    public $date_in;
    public $supplier_id;
    public $quantity;

    public $price_per_case;
    public $price_per_pcs;
    public $price_active;
    public $date_priced;
    public $price_histories = [];
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

    public function updatedPhoto()
    {
        $this->validate([
            'image_url' => 'image|max:2048',
        ]);
    }

    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->branches = Branch::all();
        $this->brands = Brand::all();
        $this->categories = Category::all();
    }
    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-product-modal');
    }

    public function submit()
    {
        $validateData = $this->validate([
            'product_name' => 'required',
            'sku' => 'required|unique:products',
            'description' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'image_url' => 'image|max:2048',
        ]);

        $image_url = $this->image_url->store('/', 'public');
        // dd($image_url);
        $product = Product::create([
            'product_name' => $this->product_name,
            'sku' => $this->sku,
            'description' => $this->description,
            'branch_id' => Auth::user()->branch_id,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'unit' => $this->unit,
            // 'stocks' => $this->stocks,
            'stockalert' => $this->stockalert,
            'image_url' => $image_url,
        ]);



        if($product){
            if($this->price_per_case <> "" || $this->price_per_pcs <> ""){
                PriceTbl::create([
                    'product_id' => $product->id,
                    'price_per_case' => $this->price_per_case,
                    'price_per_pcs' => $this->price_per_pcs,
                    'date_priced' => now(),
                    'is_active' => 1,
                ]);
            }

            // if($this->stocks <> ""){
            //     ProductIn::create([
            //         'product_id' => $product->id,
            //         'qty' => $this->stocks,
            //         'price_per_pcs' => $this->price_per_pcs,
            //         'date_priced' => now(),
            //         'is_active' => 1,
            //     ]);
            // }
            // dd($price);
            // }
            $this->dispatchBrowserEvent('hide-product-modal');

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'New Product Data Successfully Added!',
                'text' => 'You can add stocks to this product data.'
            ]);
        }

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
        $this->stocks = $product->stocks;

        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->stockalert = $product->stockalert;
        $this->updateMode = true;

        $price = PriceTbl::where('product_id',$id)->latest()->first();
        // dd($price->price_per_case);
        $this->price_per_case = $price->price_per_case;
        $this->price_per_pcs = $price->price_per_pcs;
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

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Product Data Updated Successfully!',
            'text' => 'You can add stocks to this product data.'
        ]);

        $this->resetInputFields();
    }

    public function alertConfirm($id)
    {
        $this->deleteConfirmed = $id;
        $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'warning',
                'message' => 'Are you sure?',
                'text' => 'If deleted, you will not be able to recover this imaginary file!'
            ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove()
    {
        /* Write Delete Logic */
        $delete = Product::find($this->deleteConfirmed)->delete();
        if($delete){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Product has been removed!',
                'text' => 'It will not seen on list of products anymore.'
            ]);
        }
        // $this->mount();

    }

    // public function confirmation($deleteid)
    // {
    //     $this->deleteproduct_id = $deleteid;
    //     $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    // }

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



        // $products = Product::query()->with('stocks','qty')->get();
        // dd($products)

        $products = Product::with('activePrice'
                // ['activePrice' => function($query) {
                //     $query->where('is_active', TRUE);
                // }]
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
            // 'branches' => $branches,
            // 'categories' => $categories,
            // 'brands' => $brands,
        ]);
    }

    //ADD STOCKS

    public function addNewStock($id)
    {
        $this->dispatchBrowserEvent('show-add-new_stock-modal');
        //set product_id
        $this->product_id = $id;
        //fill product name to modal
        $data = Product::findOrFail($id);
        $this->product_name = $data->product_name;

    }

    public function saveNewStock()
    {
        $validateData = $this->validate([
            'quantity' => 'required',
            'date_in' => 'required',
            'supplier_id' => 'required',
        ]);

        $stock = ProductIn::create([
            'product_id' => $this->product_id,
            'date_in' => $this->date_in,
            'branch_id' => Auth::user()->branch_id,
            'supplier_id' => $this->supplier_id,
            'qty' => $this->quantity,
        ]);

        if($stock){
            $product = Product::findOrFail($this->product_id);
            $product->stocks += $this->quantity;
            $product->save();

            $this->dispatchBrowserEvent('hide-add-new_stock-modal');

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'New Stock Data Successfully Added!',
                'text' => 'You can add more stocks to this product data.'
            ]);


        }
    }
    //Set Pricing
    public function setPrice($id)
    {
        $this->dispatchBrowserEvent('show-set-price-modal');

        //set product_id
        $this->product_id = $id;
        //fill product name to modal
        $data = Product::findOrFail($id);
        $this->product_name = $data->product_name;

        $this->clearPrice();

        $this->price_histories = PriceTbl::where('product_id',$id)->latest()->get();
    }

    public function clearPrice()
    {
        $this->price_per_case = '';
        $this->price_per_pcs = '';
        $this->date_priced = '';
    }

    public function setPriceSubmit()
    {
        $validateData = $this->validate([
            'price_per_case' => 'required',
            'price_per_pcs' => 'required',
            'date_priced' => 'required',
        ]);

        $price = PriceTbl::create([
            'product_id' => $this->product_id,
            'price_per_case' => $this->price_per_case,
            'price_per_pcs' => $this->price_per_pcs,
            'date_priced' => $this->date_priced,
            'is_active' => TRUE,
        ]);

        if($price){
            $this->dispatchBrowserEvent('hide-set-price-modal');

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'New Price Data is set Successfully!',
                'text' => 'congrats!.'
            ]);

            $this->clearPrice();
        }
    }
}
