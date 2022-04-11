<?php

namespace App\Http\Livewire;

use Livewire\Component;
// use
use App\Models\Customer;
use App\Models\PhilippineCity;
use App\Models\PhilippineProvince;
use Illuminate\Support\Facades\Auth;

class StaffCustomer extends Component
{

    public $provinces;
    public $selectedProvince = NULL;
    public $sortByProvince = NULL;
    public $sortByCity = NULL;
    public $province;
    public $cities;
    public $city;
    public $email;
    public $contact_number;
    public $is_active;

    public $perPage = 5;
    public $searchTerm;
    public $updateMode = false;

    public function mount()
    {
        $this->provinces = PhilippineProvince::whereIn('id',['3','4',''])->get();
    }

    public function updatedSortByProvince($province_code)
    {

        $this->province = $province_code;
        if (!is_null($province_code)) {
            $this->cities = PhilippineCity::where('province_code','=', $province_code)->get();
            // dd($this->customers);
        }
    }

    public function updatedSelectedProvince($province_code)
    {

        $this->province = $province_code;
        if (!is_null($province_code)) {
            $this->cities = PhilippineCity::where('province_code','=', $province_code)->get();
            // dd($this->customers);
        }
    }

    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-customer-modal');
        $this->selectedProvince = $this->sortByProvince;
    }

    public function submit()
    {
        $validateData = $this->validate([
            'customer_name' => 'required',
            'selectedProvince' => 'required',
            'city' => 'required',
            // 'contact_number' => 'required',
            // 'salesman' => 'required',
            'channel' => 'required',
            // 'date_entered' => 'required',
        ]);

        Customer::create([
            'customer_name' => $this->customer_name,
            'province_code' => $this->province,
            'city_municipality_code' => $this->city,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            // 'salesman' => $this->salesman,
            'channel' => $this->channel,
            // 'date_entered' => $this->date_entered,
            'branch_id' => Auth::user()->branch_id,
            'is_active' => $this->is_active,
        ]);

        $this->dispatchBrowserEvent('hide-customer-modal');


        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'New Customer Data Successfully Added!',
            'text' => 'Congrats.'
        ]);
        // session()->flash('message', 'New Customer Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->customer_name = '';
        $this->contact_number = '';
        $this->channel = '';
        // $this->salesman = '';
        // $this->date_entered = '';
        $this->email = '';
        $this->selectedProvince = '';
        $this->city = '';
        $this->is_active = '';
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-customer-modal');
        $customer = Customer::findOrFail($id);
        $this->customer_id = $id;
        $this->customer_name = $customer->customer_name;
        $this->contact_number = $customer->contact_number;
        $this->selectedProvince = $customer->province_code;
        $this->city = $customer->city_municipality_code;
        $this->email = $customer->email;
        // $this->salesman = $customer->salesman;
        // $this->date_entered = $customer->date_entered;
        $this->channel = $customer->channel;
        $this->is_active = $customer->is_active;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'customer_name' => 'required',
            'city' => 'required',
            'selectedProvince' => 'required',
            // 'contact_number' => 'required',
            // 'salesman' => 'required',
            'channel' => 'required',
            // 'date_entered' => 'required'
        ]);

        $customer = Customer::find($this->customer_id);
        $customer->update([
            'customer_name' => $this->customer_name,
            'province_code' => $this->province,
            'city_municipality_code' => $this->city,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            // 'salesman' => $this->salesman,
            'channel' => $this->channel,
            // 'date_entered' => $this->date_entered,
            'is_active' => $this->is_active,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-customer-modal');

        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Customer Data Successfully Updated!',
            'text' => 'Congrats.'
        ]);

        // session()->flash('message', 'Costumer Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function render()
    {
        $branch_id = Auth::user()->branch_id;


        $customers = Customer::where('branch_id','=', $branch_id)
                ->when($this->sortByProvince, function($query){
                    $query->where('province_code', $this->sortByProvince);
                    })
                ->when($this->sortByCity, function($query){
                    $query->where('city_municipality_code', $this->sortByCity);
                    })
                ->search(trim($this->searchTerm))
                ->paginate($this->perPage);

        return view('livewire.staff-customer',[
            'customers' =>  $customers
        ]);
    }
}
