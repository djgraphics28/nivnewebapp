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
use Illuminate\Support\Facades\Validator;

class AdminStock extends Component
{
    use WithPagination;

    public $searchTerm;
    public $sortBySupplier;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $suppliers = Supplier::all();

        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.admin-stock',[
            'stocks' => Stock::where('product_id','like', $searchTerm)
                        ->orWhere('stock_code','like', $searchTerm)
                        ->latest()->paginate(3),
            'suppliers' => $suppliers
        ]);
    }


}
