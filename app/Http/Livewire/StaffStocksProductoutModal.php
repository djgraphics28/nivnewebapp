<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use App\Models\Productout;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StaffStocksProductoutModal extends Component
{
    public $product_list = [];
    public $tracking_number;
    public $salesman;
    public $vehicle;
    public $date;

    public $is_active;

    public $searchTerm;
    public $updateMode = false;
    public $branch_id;
    public $tracking_id;
    public $deletetracking_id = null;

    public function mount()
    {
        $this->employees = Employee::all();
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
            session()->flash('message-success', 'Successfully Added!');
            $this->dispatchBrowserEvent('hide-productout-modal');

        }else{

        }
    }

    public function render()
    {
        return view('livewire.staff-stocks-productout-modal');
    }
}
