<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Employee;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class StaffEmployee extends Component
{
    use WithPagination;

    public $firstname;
    public $middlename;
    public $lastname;
    public $ename;
    public $contact_number;
    public $address;
    public $position;
    public $is_active;
    public $employees;

    public $searchTerm;
    public $updateMode = false;
    public $employee_id;
    public $deleteemployee_id = null;

    protected $paginationTheme = 'bootstrap';

    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-employee-modal');
    }

    public function submit()
    {
        $validateData = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'position' => 'required',
            'contact_number' => 'required'
        ]);

        Employee::create([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'ename' => $this->ename,
            'position' => $this->position,
            'address' => $this->address,
            'contact_number' => $this->contact_number,
            'branch_id' => Auth::user()->branch_id,
            'is_active' => $this->is_active,
        ]);

        $this->dispatchBrowserEvent('hide-employee-modal');

        session()->flash('message', 'New Employee Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->firstname = '';
        $this->middlename = '';
        $this->lastname = '';
        $this->ename = '';
        $this->position = '';
        $this->address = '';
        $this->contact_number = '';
        $this->is_active = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-employee-modal');
        $employee = Employee::findOrFail($id);
        $this->employee_id = $id;
        $this->firstname = $employee->firstname;
        $this->middlename = $employee->middlename;
        $this->lastname = $employee->lastname;
        $this->ename = $employee->ename;
        $this->contact_number = $employee->contact_number;
        $this->address = $employee->address;
        $this->position = $employee->position;
        $this->is_active = $employee->is_active;
        $this->updateMode = true;
    }


    public function update()
    {
        $validateData = $this->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'position' => 'required',
            'contact_number' => 'required'
        ]);

        $employee = Employee::find($this->employee_id);
        $employee->update([
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'ename' => $this->ename,
            'position' => $this->position,
            'address' => $this->address,
            'contact_number' => $this->contact_number,
            // 'branch_id' => Auth::user()->branch_id,
            'is_active' => $this->is_active,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-customer-modal');

        session()->flash('message', 'Employee Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deleteemployee_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Employee::destroy($this->deleteemployee_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Employee Data has been deleted.');

        $this->resetInputFields();
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.staff-employee',[
            'datas' => Employee::where('firstname','like', $searchTerm)->paginate(5)
        ]);
    }
}
