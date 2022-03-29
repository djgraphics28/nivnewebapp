<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Stock;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StaffDashboard extends Component
{
    public $total_products;
    public $total_categories;
    public $total_brands;
    public $total_stocks;

    public function mount()
    {
        $this->total_products = Product::where('branch_id','=',Auth::user()->branch_id)->count();
        $this->total_categories = Category::count();
        $this->total_brands = Brand::count();
        $this->total_stocks = Stock::where('branch_id','=',Auth::user()->branch_id)
                        ->where('classi',1)->sum('qty');
        // $this->total_stocks= DB::table('stocks')
        //     ->select(DB::raw('sum(qty) as total'))
        //     ->where('branch_id', '1')->get();
    }

    public function render()
    {
        return view('livewire.staff-dashboard');
    }
}
