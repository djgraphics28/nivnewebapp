<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Customer;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StaffCustomer extends Component
{
    use WithPagination;

    public $customer_name;
    public $channel;
    // public $salesman;
    // public $date_entered;
    public $contact_number;
    public $address;
    public $email;
    public $is_active;

    public $searchTerm;
    public $updateMode = false;
    public $customer_id;
    public $deletecustomer_id = null;

    protected $paginationTheme = 'bootstrap';

    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-customer-modal');
    }

    public function submit()
    {
        $validateData = $this->validate([
            'customer_name' => 'required',
            'address' => 'required',
            // 'contact_number' => 'required',
            // 'salesman' => 'required',
            'channel' => 'required',
            // 'date_entered' => 'required',
        ]);

        Customer::create([
            'customer_name' => $this->customer_name,
            'address' => $this->address,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            // 'salesman' => $this->salesman,
            'channel' => $this->channel,
            // 'date_entered' => $this->date_entered,
            'branch_id' => Auth::user()->branch_id,
            'is_active' => $this->is_active,
        ]);

        $this->dispatchBrowserEvent('hide-customer-modal');

        session()->flash('message', 'New Customer Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->customer_name = '';
        $this->contact_number = '';
        $this->channel = '';
        // $this->salesman = '';
        // $this->date_entered = '';
        $this->email = '';
        $this->address = '';
        $this->is_active = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-customer-modal');
        $customer = Customer::findOrFail($id);
        $this->customer_id = $id;
        $this->customer_name = $customer->customer_name;
        $this->contact_number = $customer->contact_number;
        $this->address = $customer->address;
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
            'address' => 'required',
            // 'contact_number' => 'required',
            // 'salesman' => 'required',
            'channel' => 'required',
            // 'date_entered' => 'required'
        ]);

        $customer = Customer::find($this->customer_id);
        $customer->update([
            'customer_name' => $this->customer_name,
            'address' => $this->address,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
            // 'salesman' => $this->salesman,
            'channel' => $this->channel,
            // 'date_entered' => $this->date_entered,
            'is_active' => $this->is_active,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-customer-modal');

        session()->flash('message', 'Costumer Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deletecustomer_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Customer::destroy($this->deletecustomer_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Customer Data has been deleted.');

        $this->resetInputFields();
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.staff-customer',[
            'customers' => Customer::where('customer_name','like', $searchTerm)->latest()->paginate(5)
        ]);
    }


}
