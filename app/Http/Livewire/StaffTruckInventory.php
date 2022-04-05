<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Employee;
use App\Models\TrackingDate;
use Livewire\WithPagination;
use App\Models\TruckInventory;
use App\Models\TruckItem;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StaffTruckInventory extends Component
{

    use WithPagination;

    public $deleteConfirmed;
    public $searchTerm;
    public $updateMode = false;

    protected $listeners = ['remove'];
    public $inputs = [0];
    public $i = 1;


    public $tracking_id;
    public $tracking_date_id;
    public $tracking_date;
    public $tracking_number;
    public $salesman;
    public $date_load;
    public $quantity;
    public $vehicle;
    public $product_id;

    public $salesmans = [];
    public $products = [];
    public $employees = [];
    public $truckItems = [];

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->salesmans = Employee::all();
        $this->products = Product::all();

    }

    public function add()
    {
        $this->dispatchBrowserEvent('show-add-tracking-modal');
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

    public function submit()
    {
        $generateID = [
            'table' => 'truck_inventories',
            'field' => 'tracking_number',
            'length' => 15,
            'prefix' => date('dmY')
        ];
        $this->tracking_number = IdGenerator::generate($generateID);


        $validateData = $this->validate([
            'salesman' => 'required',
            'vehicle' => 'required',
            'date_load' => 'required',
        ]);

        // dd($validateData);

        $create = TruckInventory::create([
            'employee_id' => $this->salesman,
            'vehicle' => $this->vehicle,
            'date_load' => $this->date_load,
            'tracking_number' => $this->tracking_number,
            'branch_id' => Auth::user()->branch_id,
            'created_by' => Auth::user()->name,
        ]);

        $tracking_date = TrackingDate::create([
            'tracking_id' => $create->id,
            'date_load' => $this->date_load,
            'is_active' => TRUE,
        ]);

        if($create){
            $validateData = $this->validate([
                'product_id.0' => 'required',
                'quantity.0' => 'required',
            ]);

            foreach ($this->product_id as $key => $value) {
                TruckItem::create([
                    'product_id' => $this->product_id[$key],
                    'load_quantity' => $this->quantity[$key],
                    'tracking_id' => $create->id,
                    'tracking_date_id' => $tracking_date->id,
                    'type' => 'ti',//truck inventory
                ]);
            }

            $this->inputs = [0];

            // $this->resetInputFields();
            $this->dispatchBrowserEvent('hide-add-tracking-modal');

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'New Tracking Data Successfully Added!',
                'text' => 'congrats!.'
            ]);
        }

    }

    public function render()
    {
        // return view('livewire.staff-truck-inventory');
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.staff-truck-inventory',[
            'truckinventories' => TruckInventory::with('tracking_dates')
            ->where('tracking_number','like', $searchTerm)->latest()->paginate(5)
        ]);
    }

    //show items

    public function showItems($id)
    {
        // dd('here');
        $this->tracking_date_id = $id;

        //get tracking id
        $trackingdate = TrackingDate::find($id);
        $this->tracking_id = $trackingdate->tracking_id;
        $this->tracking_date = $trackingdate->date_load;

        $tracking = TruckInventory::find($this->tracking_id);
        $this->tracking_number = $tracking->tracking_number;
        $this->salesman = $tracking->employee->firstname;

        $this->dispatchBrowserEvent('show-items-tracking-modal');

        $this->truckItems = TruckItem::where('tracking_date_id','=',$id)
                ->where('tracking_id','=',$this->tracking_id)
                ->get();
    }

    //add new loading

    public function addNewLoading($id)
    {
        $this->tracking_id = $id;

        $tracking = TruckInventory::find($this->tracking_id);
        $this->tracking_number = $tracking->tracking_number;
        $this->salesman = $tracking->employee->firstname;

        $this->dispatchBrowserEvent('show-add-loading-modal');
    }

    public function saveNewItemsToTracking()
    {

        $validateData = $this->validate([
            'date_load' => 'required',
        ]);

        $tracking_date = TrackingDate::create([
            'tracking_id' => $this->tracking_id,
            'date_load' => $this->date_load,
            'is_active' => TRUE,
        ]);

        if($tracking_date){
            $validateData = $this->validate([
                'product_id.0' => 'required',
                'quantity.0' => 'required',
            ]);

            foreach ($this->product_id as $key => $value) {
                TruckItem::create([
                    'product_id' => $this->product_id[$key],
                    'load_quantity' => $this->quantity[$key],
                    'tracking_id' => $this->tracking_id,
                    'tracking_date_id' => $tracking_date->id,
                    'type' => 'ti',//truck inventory
                ]);
            }

            $this->inputs = [0];

            // $this->resetInputFields();
            $this->dispatchBrowserEvent('hide-add-loading-modal');

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'New Tracking Data Successfully Added!',
                'text' => 'congrats!.'
            ]);
        }
    }
}
