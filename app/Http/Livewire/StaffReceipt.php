<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Receipt;
use Livewire\Component;
use App\Models\Customer;
use App\Models\Employee;
use Livewire\WithPagination;
use App\Models\PhilippineCity;
use App\Models\ReceiptProduct;
use App\Models\PhilippineProvince;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StaffReceipt extends Component
{
    use WithPagination;

    public $customersData = '';

    public $deleteConfirmed;

    protected $listeners = ['remove'];

    public $or_id;
    public $or_number;
    public $or_date;
    public $description;
    public $amount_word;
    public $amount;
    public $unitprice;
    public $salesman;
    public $salesmans;
    public $customer;
    public $customers = [];
    public $updateMode = false;

    public $products;
    public $receipts;
    public $receipt_id;
    public $receipt_product_id;
    public $product_id, $quantity, $product_amount;
    // public $allReceiptItems = [];

    public $inputs = [0];
    public $i = 1;


    public $address;
    // public $location = [];
    public $searchTerm;
    public $receiptItems = [];


    public $provinces;
    public $sortByProvince = NULL;
    public $province;
    public $cities;
    public $city;
    // public $qty;

    protected $paginationTheme = 'bootstrap';

    public $selectedLocation = NULL;

    public function updatedSortByProvince($province_code)
    {

        $this->province = $province_code;
        if (!is_null($province_code)) {
            $this->cities = PhilippineCity::where('province_code','=', $province_code)->get();
            // dd($this->customers);
        }
    }

    // public function updatedSelectedProvince($province_code)
    // {

    //     $this->province = $province_code;
    //     if (!is_null($province_code)) {
    //         $this->cities = PhilippineCity::where('province_code','=', $province_code)->get();
    //         // dd($this->customers);
    //     }
    // }


    public function add()
    {
        // dd('here');
        $this->dispatchBrowserEvent('show-add-receipt-modal');
    }

    public function addItem($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs ,$i);
    }

    public function removeItem($i)
    {
        unset($this->inputs[$i]);
    }

    // private function resetInputFields(){
    //     $this->product_id = '';
    //     $this->quantity = '';
    //     $this->amount = '';
    // }

    public function mount()
    {
        $this->salesmans = Employee::where('branch_id','=',Auth::user()->branch_id)->get();

        $this->products = Product::where('branch_id','=',Auth::user()->branch_id)->get();

        $this->location = Customer::where('branch_id','=',Auth::user()->branch_id)->groupBy('address')->get();
        // var_dump($this->location);
        // $this->allReceiptItems[] = [ 'product_id' => '', 'quantity' => 1, 'amount' => 0 ];
        $this->customers = collect();

        $this->provinces = PhilippineProvince::whereIn('id',['3','4'])->get();


    }

    public function updatedSelectedLocation($location)
    {

        // dd($location);
        if (!is_null($location)) {
            $this->customers = Customer::where('address','=', $location)->get();
            // dd($this->customers);
        }
    }

    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-category-modal');
    }

    public function submit()
    {
        // $generateID = [
        //     'table' => 'receipts',
        //     'field' => 'or_number',
        //     'length' => 15,
        //     'prefix' => date('dmY')
        // ];
        // $this->or_number = IdGenerator::generate($generateID);

        $validateData = $this->validate([
            'or_number' => 'required|unique:receipts',
            // 'amount' => 'required',
            'or_date' => 'required',
            'customer' => 'required',
            'salesman' => 'required',
        ]);

        $create = Receipt::create([
            'or_number' => $this->or_number,
            'amount' => 0,
            'amount_word' => $this->amount_word,
            'description' => $this->description,
            'or_date' => $this->or_date,
            'customer_id' => $this->customer,
            'salesman' => $this->salesman,
            'created_by' => Auth::user()->name,
            'branch_id' => Auth::user()->branch_id,
            'is_active' => 1,
        ]);

        // dd($create->id);

        if($create){

            $validateData = $this->validate([
                'product_id.0' => 'required',
                'quantity.0' => 'required',
                'product_amount.*' => 'required',
            ]);
            $amount = 0;
            foreach ($this->product_id as $key => $value) {
                $amount = $amount + ($this->product_amount[$key] * $this->quantity[$key]);
                ReceiptProduct::create([
                    'product_id' => $this->product_id[$key],
                    'qty' => $this->quantity[$key],
                    'amount' => $this->product_amount[$key],
                    'receipt_id' => $create->id
                ]);
            }

            $update_amount = Receipt::find($create->id);
            $update_amount->update([
                'amount' => $amount,
            ]);

            $this->inputs = [0];

            $this->resetInputFields();
            $this->dispatchBrowserEvent('hide-receipt-modal');

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'New Receipt Data Successfully Added!',
                'text' => 'You can add products to this receipt data.'
            ]);

            // session()->flash('message', 'New Receipt Data Successfully Added!');

            return redirect()->back();
        }

    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-edit-receipt-modal');
        $receipt = Receipt::findOrFail($id);
        $this->receipt_id = $id;
        $this->or_number = $receipt->or_number;
        $this->or_date = $receipt->or_date;
        $this->description = $receipt->description;
        $this->amount = $receipt->amount;
        // $this->amount_word = $receipt->amount_word;
        $this->customer = $receipt->customer_id;
        $this->salesman = $receipt->salesman;
        $this->updateMode = true;

        $this->receiptItems = ReceiptProduct::where('receipt_id','=',$id)->get();
    }

    public function update()
    {
        $validateData = $this->validate([
            'or_number' => 'required',
            'amount' => 'required',
            'or_date' => 'required',
            'customer' => 'required',
            'salesman' => 'required',
        ]);

        $receipt = Receipt::find($this->receipt_id);
        $receipt->update([
            'or_number' => $this->or_number,
            'amount' => $this->amount,
            // 'amount_word' => $this->amount_word,
            'description' => $this->description,
            'or_date' => $this->or_date,
            'customer_id' => $this->customer,
            'salesman' => $this->salesman,
            'updated_by' => Auth::user()->name,
            // 'branch_id' => Auth::user()->branch_id,
            // 'is_active' => 1,
        ]);
        if($this->product_id <> NULL){
            foreach ($this->product_id as $key => $value) {
                ReceiptProduct::create([
                    'product_id' => $this->product_id[$key],
                    'qty' => $this->quantity[$key],
                    'amount' => $this->product_amount[$key],
                    'receipt_id' => $this->receipt_id
                ]);
            }
        }

        $this->updateAmountReceipt();

        $this->resetInputFieldsProducts();

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-edit-receipt-modal');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Receipt Data Updated Successfully!',
            'text' => 'You can add products to this receipt data.'
        ]);
        // session()->flash('message', 'Receipt Data Updated Successfully.');

        $this->resetInputFields();
    }

    private function resetInputFields(){
        $this->or_number = '';
        $this->or_date = '';
        // $this->amount = '';
        $this->amount_word = '';
        $this->description = '';
        $this->customer = '';
        $this->salesman = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    // public function addItems($id)
    // {
    //     $this->receipt_id = $id;
    //     $receipt = Receipt::find($id);
    //     $this->or_number = $receipt->or_number;

    //     $this->dispatchBrowserEvent('show-product-add-modal');
    // }

    // public function removeItem($index)
    // {
    //     unset($this->allReceiptItems[$index]);
    //     $this->allReceiptItems = array_values($this->allReceiptItems);
    // }

    // public function addProduct($id)
    // {
    //     // $this->allReceiptItems[] = [ 'product_id' => '', 'quantity' => 1, 'amount' => 0 ];
    //      // dd($this->tracking_number);
    //      $this->emit('getItems',  $id);

    //      $this->dispatchBrowserEvent('show-add-product-receipt-modal');

    // }

    // public function submitProduct(Request $request)
    // {
    //     $validatedDate = $this->validate([
    //             'product_id.0' => 'required',
    //             'qty.0' => 'required',
    //             'amount.*' => 'required',
    //         ],
    //         [
    //             'product_id.0.required' => 'Product name field is required',
    //             'qty.0.required' => 'Quantity field is required',
    //             'amount.*.required' => 'Amount field is required',
    //         ]
    //     );

    //     foreach ($this->product_id as $key => $value) {
    //         ReceiptProduct::create([
    //             'receipt_id' => $this->receipt_id,
    //             'product_id' => $this->product_id[$key],
    //             'qty' => $this->qty[$key],
    //             'amount' => $this->amount[$key],
    //         ]);
    //     }

    //     $this->allReceiptItems = [];

    //     // $this->resetInputFields();

    //     session()->flash('message', 'Products Has Been Entered Successfully.');
    // }


    public function alertConfirm($id)
    {
        $this->deleteConfirmed = $id;
        $this->dispatchBrowserEvent('swal:confirm', [
                'type' => 'warning',
                'message' => 'Are you sure?',
                'text' => 'If deleted, you will not be able to recover this imaginary file!'
            ]);
    }

    public function alertConfirm2($id)
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
        $delete = Receipt::find($this->deleteConfirmed)->delete();
        if($delete){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Items has been removed!',
                'text' => 'It will not seen on list of receipts anymore.'
            ]);
        }
        // $this->mount();

    }

    public function remove2()
    {
        /* Write Delete Logic */
        $delete = Receipt::find($this->deleteConfirmed)->delete();
        if($delete){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Receipt has been removed!',
                'text' => 'It will not seen on list of receipts anymore.'
            ]);
        }
        // $this->mount();

    }

    public function render()
    {


        // $samples = Receipt::where('branch_id','=',Auth::user()->branch_id)->latest()->paginate(5);
        // // dd($receipts);
        // return view('livewire.staff-receipt',compact('samples'));
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.staff-receipt',[
            'samples' => Receipt::where('or_number','like', $searchTerm)->latest()->paginate(5)
        ]);
    }

    public function editReceiptProduct($id)
    {
        // $this->inputs = null;
        $this->receipt_product_id = $id;
        $this->dispatchBrowserEvent('show-edit-items-receipt-modal');

        $receipt = ReceiptProduct::findOrFail($id);
        $this->product_id = $receipt->product_id;
        $this->unitprice = $receipt->amount;
        $this->quantity = $receipt->qty;
    }

    public function updateItems()
    {
        $validateData = $this->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'unitprice' => 'required',
        ]);
        $amount_changes = $this->unitprice * $this->quantity;
        $receipt = ReceiptProduct::find($this->receipt_product_id);

        // dd($receipt);
        $old_amount = $receipt->amount;

        $receipt->update([
            'product_id' => $this->product_id,
            'amount' => $this->unitprice,
            'qty' => $this->quantity,
        ]);

        // foreach ($this->product_id as $key => $value) {
        //     ReceiptProduct::create([
        //         'product_id' => $this->product_id[$key],
        //         'qty' => $this->quantity[$key],
        //         'amount' => $this->product_amount[$key],
        //         'receipt_id' => $this->receipt_id
        //     ]);
        // }

        $this->updateAmountReceipt();


        // $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-edit-items-receipt-modal');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Items Data Updated Successfully!',
            'text' => 'You can add products to this receipt data.'
        ]);
        // session()->flash('message', 'Receipt Data Updated Successfully.');

        $this->resetInputFieldsProducts();

        $this->loadItems($this->receipt_id);
    }

    public function loadItems($id)
    {
        $this->receiptItems = ReceiptProduct::where('receipt_id','=',$id)->get();
    }

    public function resetInputFieldsProducts()
    {
        $this->product_id = '';
        $this->quantity = '';
        $this->product_amount = '';
    }

    public function updateAmountReceipt()
    {

        $amount = ReceiptProduct::where('receipt_id',$this->receipt_id )->sum(DB::raw('amount * qty'));


        // dd($amount*$quantity);
        $find = Receipt::find($this->receipt_id);

        $find->update([
            'amount' => $amount,
        ]);
    }
}
