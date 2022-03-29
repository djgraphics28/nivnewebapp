<?php

namespace App\Http\Livewire;

use PDF;
use App\Models\Product;
use Livewire\Component;
use App\Models\Employee;
use App\Models\Productout;
use App\Models\ProductTracking;
use App\Models\ReceiptProduct;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StaffStockProductout extends Component
{
    // protected $listeners = ['items'];
    public $product_list = [];
    public $items = [];
    public $tracking_number;
    public $product_tracking;
    public $salesman;
    public $vehicle;
    public $date;
    public $date_return;

    public $is_active;
    public $return_qty;
    public $return_unit;
    public $pieces_qty;

    public $searchTerm;
    public $updateMode = false;
    public $branch_id;
    public $tracking_id;
    public $ptracking_id;
    public $deletetracking_id = null;

    public $allReceiptItems = [];

    // public function items($id)
    // {
    //      $this->items = ProductTracking::where('tracking_id',$id)->get();
    // }

    public function add()
    {
        $this->dispatchBrowserEvent('show-productout-modal');
    }

    public function stockReturn($id)
    {
        $this->items = ProductTracking::where('tracking_id','=',$id)->get();
        $this->dispatchBrowserEvent('show-return-modal');
    }

    public function mount()
    {
        $this->items = ProductTracking::where('tracking_id','=',$this->tracking_id)->get();
        $this->employees = Employee::all();
    }

    public function enterReturnQty($id)
    {
        // $this->emit('items',  $id);
        $this->dispatchBrowserEvent('show-return-qty-modal');
        $return = ProductTracking::findOrFail($id);

        // dd($return);
        $this->ptracking_id = $return->id;
        $this->return_qty = $return->return_qty;
        $this->return_unit = $return->return_unit;
        $this->pieces_qty = $return->pieces_qty;
        $this->date_return = $return->date_return;
    }

    public function submitReturnQty()
    {
        $validateData = $this->validate([
            // 'return_qty' => 'required',
            'date_return' => 'required',
        ]);

        $return = ProductTracking::find($this->ptracking_id);

        if($return->qty < $this->return_qty){
            session()->flash('message', 'Return Quantity must be lower to Quantity Load .');
        }else{
            $return->update([
                'return_qty' => $this->return_qty,
                'date_return' => $this->date_return,
                'return_unit' => $this->return_unit,
                'pieces_qty' => $this->pieces_qty
            ]);

            if($return){
                $this->dispatchBrowserEvent('hide-return-qty-modal');
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'success',
                    'message' => 'Return Quantity entered Successfully!',
                    'text' => 'Congrats!.'
                ]);


            }else{
                $this->dispatchBrowserEvent('hide-return-qty-modal');

                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'message' => 'Failed!',
                    'text' => 'Please try again!.'
                ]);
            }


        }


    }

    public function submit()
    {
        $generateID = [
            'table' => 'productouts',
            'field' => 'tracking_number',
            'length' => 15,
            'prefix' => date('dmY')
        ];
        $this->tracking_number = IdGenerator::generate($generateID);

        // dd($this->tracking_number);

        $validateData = $this->validate([
            'salesman' => 'required',
            'vehicle' => 'required',
            'date' => 'required',
        ]);

        // dd($validateData);

        $create = Productout::create([
            'employee_id' => $this->salesman,
            'vehicle' => $this->vehicle,
            'date_product_out' => $this->date,
            'tracking_number' => $this->tracking_number,
            'status' => 'pending',
            'branch_id' => Auth::user()->branch_id,
            'is_active' => 'active',
        ]);

        if($create){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Tracking Data Created Successfully!',
                'text' => 'You can now enter products.'
            ]);
            $this->dispatchBrowserEvent('hide-productout-modal');

        }else{

        }
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-category-modal');
        $tracking = Productout::findOrFail($id);
        $this->tracking_id = $id;
        $this->salesman = $tracking->employee_id;
        $this->vehicle = $tracking->vehicle;
        $this->date = $tracking->date_product_out;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'salesman' => 'required',
            'vehicle' => 'required',
            'date' => 'required',
        ]);

        $tracking = Productout::find($this->tracking_id);
        $tracking->update([
            'employee_id' => $this->salesman,
            'vehicle' => $this->vehicle,
            'date_product_out' => $this->date,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-category-modal');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Tracking Data Updated Successfully!',
            'text' => 'You can now enter products.'
        ]);

        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->date = '';
        $this->vehicle = '';
        $this->salesman = '';
    }

    public function addProduct($id)
    {

        // dd($this->tracking_number);
        $this->emit('tracking',  $id);

        $this->dispatchBrowserEvent('show-add-product-tracking-modal');
        // dd('here');
    }


    // public function mount()
    // {
    //     $this->products = Productout::all();
    // }

    public function confirmation($deleteid)
    {
        $this->deletetracking_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal-tracking');

    }

    public function delete()
    {
        // dd($this->deletetracking_id);
        Productout::destroy($this->deletetracking_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal-tracking');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Tracking Data has been deleted!',
            'text' => 'Success!.'
        ]);
        // session()->flash('message', 'Tracking Data has been deleted.');

        // $this->resetInputFields();
    }

    public function render()
    {
        $productouts = Productout::withCount(
            ['product_tracking' => function($query) {
                $query->where('product_trackings.status', 0);
            }],

            )
            ->withSum(
                ['product_tracking' => function($query) {
                    $query->where('product_trackings.status', 0);
                }],
                'qty'
            )->withSum(
                ['product_tracking' => function($query) {
                    $query->where('product_trackings.status', 0);
                }],
                'return_qty'
            )->get();
        return view('livewire.staff-stock-productout',[
            'productouts' => $productouts
        ]);
    }
}
