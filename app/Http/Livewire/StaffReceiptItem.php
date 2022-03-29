<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\Receipt;
use Livewire\Component;
use App\Models\ReceiptProduct;

class StaffReceiptItem extends Component
{

    protected $listeners = ['getItems'];

    public $receipt_id;
    public $receipt_product_id;
    public $or_number;
    public $salesman;
    public $customer;

    public $product_id, $quantity, $amount;

    public $products;
    public $receipt_products;

    public $deleteConfirmed;
    public $inputs = [0,1,2];
    public $i = 1;

    public function getItems($id)
    {
        $this->receipt_id = $id;
        $receipt = Receipt::find($id);

        $this->receipt_products = ReceiptProduct::where('receipt_id','=',$this->receipt_id)->get();
        // dd($receipt);
        $this->or_number = $receipt->or_number;
        $this->salesman = $receipt->employee->firstname;
        $this->customer = $receipt->customer->customer_name;

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

    private function resetInputFields(){
        $this->product_id = '';
        $this->quantity = '';
        $this->amount = '';
    }

    public function submit()
    {
        // dd('here');
        $validatedDate = $this->validate([
            'product_id.0' => 'required',
            'quantity.0' => 'required',
            'amount.*' => 'required',
        ]);

        // dd($validatedDate);

        foreach ($this->product_id as $key => $value) {
            ReceiptProduct::create([
                'product_id' => $this->product_id[$key],
                'qty' => $this->quantity[$key],
                'amount' => $this->amount[$key],
                'receipt_id' => $this->receipt_id,
            ]);
        }

        $this->inputs = [0];

        $this->resetInputFields();

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Products entered Successfully!',
            'text' => 'Congrats!.'
        ]);
        $this->mount();
        // session()->flash('message', 'Account Added Successfully.');
    }

    private function resetInputProductFields(){
        $this->product_id = '';
        $this->quantity = '';
        $this->amount = '';
    }

    public function edit($id)
    {
           // dd($id);
           $this->dispatchBrowserEvent('show-receipt_product-modal');
           $receipt = ReceiptProduct::findOrFail($id);
           $this->receipt_product_id = $id;
        //    $this->receipt_id = $receipt_id;
           $this->product_id = $receipt->product_id;
           $this->quantity = $receipt->qty;
           $this->amount = $receipt->amount;
    }

    public function update()
    {
        $validateData = $this->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
        ]);

        $tracking = ReceiptProduct::find($this->receipt_product_id);
        $tracking->update([
            'product_id' => $this->product_id,
            'qty' => $this->quantity,
            'amount' => $this->amount,
        ]);

        // $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-receipt_product-modal');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Product Receipt Data Updated Successfully!',
            'text' => 'Congrats.'
        ]);
        // session()->flash('message', 'Receipt Data Updated Successfully.');

        $this->resetInputProductFields();
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
        $delete = ReceiptProduct::find($this->deleteConfirmed)->delete();
        if($delete){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Product has been removed!',
                'text' => 'It will not seen on list of receipts anymore.'
            ]);
        }
        $this->mount();

    }

    public function mount()
    {
        $this->products = Product::all();
        $this->receipt_products = ReceiptProduct::where('receipt_id','=',$this->receipt_id)->get();
    }

    public function render()
    {
        // dd($this->or_number);
        return view('livewire.staff-receipt-item');
    }
}
