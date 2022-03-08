<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Branch;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class AdminProduct extends Component
{
    use WithPagination;

    public $product_name;
    public $sku;
    public $description;
    public $branch_id;
    public $category_id;
    public $brand_id;
    public $is_active;

    public $searchTerm;
    public $updateMode = false;
    public $product;
    public $product_id;
    public $deleteproduct_id = null;

    protected $rules = [
        'product_name' => 'required',
        'sku' => 'required|unique:products',
        'description' => 'min:10',
        'branch_id' => 'required',
        'category_id' => 'required',
        'brand_id' => 'required',
        'unit' => 'required',
    ];
    protected $paginationTheme = 'bootstrap';


    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-product-modal');
    }

    public function submit()
    {
        $validateData = $this->validate();

        $validateData['image_url'] = 'public/photo';

        Product::create($validateData);

        $this->dispatchBrowserEvent('hide-product-modal');

        session()->flash('message', 'New Product Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->product_name = '';
        $this->sku = '';
        $this->description = '';
        $this->branch_id = '';
        $this->unit = '';
        $this->category_id = '';
        $this->brand_id = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-product-modal');
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->product_name = $product->product_name;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->branch_id = $product->branch_id;
        $this->unit = $product->unit;
        $this->category_id = $product->category_id;
        $this->brand_id = $product->brand_id;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'product_name' => 'required',
            'sku' => 'required',
            'description' => 'min:10',
            'branch_id' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
        ]);

        $product = Product::find($this->product_id);
        $product->update([
            'product_name' => $this->product_name,
            'sku' => $this->sku,
            'description' => $this->description,
            'branch_id' => $this->branch_id,
            'unit' => $this->unit,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
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

    public function render()
    {

        $branches = Branch::all();
        $brands = Brand::all();
        $categories = Category::all();

        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.admin-product',[
            'products' => Product::where('product_name','like', $searchTerm)
                        ->orWhere('sku','like', $searchTerm)
                        ->latest()->paginate(5),
            'branches' => $branches,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }


}
