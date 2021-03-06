<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class StaffController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getDashboardPage()
    {
        return view('staff.dashboard');
    }

    // public function getBranchPage()
    // {
    //     return view('staff.branches.index');
    // }

    // public function getUserPage()
    // {
    //     return view('staff.users.index');
    // }

    public function getCategoryPage()
    {
        return view('staff.categories.index');
    }

    public function getBrandPage()
    {
        return view('staff.brands.index');
    }

    public function getSupplierPage()
    {
        return view('staff.suppliers.index');
    }

    public function getSupplierProductPage($id)
    {

        $data = Supplier::find($id);
        $data['supplier'] = $data->supplier_name;

        $data['supplier_id'] = $id;

        return view('staff.suppliers.product', $data);
    }

    public function getProductPage()
    {
        return view('staff.products.index');
    }

    public function getStockPage()
    {
        return view('staff.stocks.index');
    }

    public function getProductInPage()
    {
        return view('staff.stocks.productin');
    }

    public function getProductOutPage()
    {
        return view('staff.stocks.productout');
    }

    public function getCustomerPage()
    {
        return view('staff.customers.index');
    }

    public function getStockReturnPage()
    {
        return view('staff.stocks.stockreturn');
    }

    public function getEmployeePage()
    {
        return view('staff.employees.index');
    }

    public function getReceiptPage()
    {
        return view('staff.receipts.index');
    }

    public function getReceiptItemPage()
    {
        return view('staff.receipts.items');
    }

    public function getTruckInventoryPage()
    {
        return view('staff.truckinventories.index');
    }
}
