<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Productout;
use App\Models\ProductTracking;
use Illuminate\Support\Facades\Auth;

class StaffStockAddProductToTracking extends Component
{

    protected $listeners = ['tracking','remove'];
    public $deleteConfirmed;


    protected $paginationTheme = 'bootstrap';

    public $trackings =[];
    public $tracking_id;
    public $ptracking_id;
    public $product_id, $quantity, $price_per_case, $price_per_pcs, $date;
    public $updateMode = false;
    public $inputs = [0,1,2];
    public $i = 1;

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
        $this->price_per_case = '';
        $this->price_per_pcs = '';
        // $this->amount = '';
    }

    public function submit()
    {
        // dd('here');
        $validatedDate = $this->validate([
                'product_id.0' => 'required',
                'quantity.0' => 'required',
                'price_per_case.*' => 'required',
                'price_per_pcs.*' => 'required',
            ]
        );

        // dd($validatedDate);

        foreach ($this->product_id as $key => $value) {
            ProductTracking::create([
                'product_id' => $this->product_id[$key],
                'qty' => $this->quantity[$key],
                'price_per_case' => $this->price_per_case[$key],
                'price_per_pcs' => $this->price_per_pcs[$key],
                'tracking_id' => $this->tracking_id,
                'branch_id' => Auth::user()->branch_id,
                'created_by' => Auth::user()->name,
                'type' => 1,
                'status' => 0,
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

    public function edit($id)
    {
        // dd($id);
        $this->dispatchBrowserEvent('show-product_tracking-modal');
        $tracking = ProductTracking::findOrFail($id);
        $this->ptracking_id = $id;
        $this->product_id = $tracking->product_id;
        $this->quantity = $tracking->qty;
        $this->price_per_case = $tracking->price_per_case;
        $this->price_per_pcs = $tracking->price_per_pcs;
        // $this->amount_word = $receipt->amount_word;
        $this->date = $tracking->created_at;
        // $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'product_id' => 'required',
            'quantity' => 'required',
            'price_per_case' => 'required',
            'price_per_pcs' => 'required',
            'date' => 'required',
        ]);

        $tracking = ProductTracking::find($this->ptracking_id);
        $tracking->update([
            'product_id' => $this->product_id,
            'qty' => $this->quantity,
            // 'amount_word' => $this->amount_word,
            'price_per_case' => $this->price_per_case,
            'price_per_pcs' => $this->price_per_pcs,
            'created_at' => $this->date,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-product_tracking-modal');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Product Tracking Data Updated Successfully!',
            'text' => 'Congrats.'
        ]);
        // session()->flash('message', 'Receipt Data Updated Successfully.');

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
        $delete = ProductTracking::find($this->deleteConfirmed)->delete();
        if($delete){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Receipt has been removed!',
                'text' => 'It will not seen on list of receipts anymore.'
            ]);
        }
        $this->mount();

    }
    public function tracking($id)
    {
        $tracking = Productout::find($id);
        $this->tracking_number = $tracking->tracking_number;
        $this->tracking_id = $tracking->id;

        $trackings = ProductTracking::where('tracking_id','=',$id)->get();
        $this->trackings = $trackings;
    }

    public function mount()
    {
        $this->products = Product::all();
        $trackings = ProductTracking::where('tracking_id','=',$this->tracking_id)->get();
        $this->trackings = $trackings;
    }


    public function render()
    {

        return view('livewire.staff-stock-add-product-to-tracking',[
            // 'products' => $products,
            'trackings' => $this->trackings
        ]);
    }

}
