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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StaffStock extends Component
{
    use WithPagination;

    public $searchTerm;
    public $sortBySupplier = NULL;
    // public $sortByCategory = NULL;
    public $perPage = 5;
    public $suppliers;
    public $categories;

    public $supplier_id;
    public $stock_id;
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
    public $stock;
    public $classification;


    public $updateMode = false;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->suppliers = Supplier::all();
        $this->categories = Category::all();
    }

    public function edit($id)
    {
        // dd($id);
        $this->dispatchBrowserEvent('show-staff-stock-modal');
        $stock = Stock::findOrFail($id);
        $this->stock_id = $id;
        $this->supplier_id = $stock->supplier_id;
        $this->product_id = $stock->product_id;
        $this->qty = $stock->qty;
        $this->price = $stock->price;
        $this->selling_price = $stock->selling_price;
        $this->price_per_pcs = $stock->price_per_pcs;
        $this->selling_per_pcs = $stock->selling_per_pcs;
        $this->date_delivered = $stock->date_delivered;
        $this->expr_date = $stock->expr_date;
        $this->classification = $stock->classification;
        // $this->selling_price = $stock->selling_price;
        // $this->selling_price = $stock->selling_price;
    }

    public function update()
    {
        $validateData = $this->validate([
            'supplier_id' => 'required',
            // 'product_id' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'selling_price' => 'required',
            'date_delivered' => 'required',
            // 'expr_date' => 'required',
            // 'stock_code' => 'required',
        ]);

        $stocks = Stock::find($this->stock_id);
        $stocks->update([
            'supplier_id' => $this->supplier_id,
            'product_id' => $this->product_id,
            'qty' => $this->qty,
            'price' => $this->price,
            'selling_price' => $this->selling_price,
            'price_per_pcs' => $this->price_per_pcs,
            'selling_per_pcs' => $this->selling_per_pcs,
            // 'stock_code' => $this->stock_code,
            'updated_by' => Auth::user()->name,
            // 'status' => 'pending',
            // 'branch_id' => Auth::user()->branch_id,
            // 'classi' => 1,
            'date_delivered' => $this->date_delivered,
            'expr_date' => $this->expr_date,
            'classification' => $this->classification,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-staff-stock-modal');

        session()->flash('message', 'Stock Data Data Updated Successfully.');

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
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deletestock_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Stock::destroy($this->deletestock_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Stock Data has been deleted.');

        $this->resetInputFields();
    }


    public function render()
    {

        $branch_id = Auth::user()->branch_id;

        $stocks = Stock::where('branch_id','=', $branch_id)
                ->when($this->sortBySupplier, function($query){
                    $query->where('supplier_id', $this->sortBySupplier);
                    })
                // ->when($this->sortByCategory, function($query){
                //     $query->where('category_id', $this->sortByCategory);
                //     })
                ->search(trim($this->searchTerm))
                ->paginate($this->perPage);

        return view('livewire.staff-stock',[
            'stocks' => $stocks,
        ]);
    }
}
