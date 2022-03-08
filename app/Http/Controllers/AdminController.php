<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
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
        return view('admin.dashboard');
    }

    public function getBranchPage()
    {
        return view('admin.branches.index');
    }

    public function getUserPage()
    {
        return view('admin.users.index');
    }

    public function getCategoryPage()
    {
        return view('admin.categories.index');
    }

    public function getBrandPage()
    {
        return view('admin.brands.index');
    }

    public function getSupplierPage()
    {
        return view('admin.suppliers.index');
    }

    public function getProductPage()
    {
        return view('admin.products.index');
    }

    public function getStockPage()
    {
        return view('admin.stocks.index');
    }

    public function getProductInPage()
    {
        return view('admin.stocks.productin');
    }
}
