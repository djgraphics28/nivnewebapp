<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Branch;
use Livewire\Component;
use App\Models\Supplier;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StaffSupplier extends Component
{
    use WithPagination;

    public $supplier_name;
    public $email;
    public $contact_number;
    public $address;
    public $is_active;

    public $searchTerm;
    public $updateMode = false;
    public $supplier;
    public $supplier_id;
    public $branch_id;
    public $deletesupplier_id = null;

    // protected $rules = [
    //     'supplier_name' => 'required',
    //     'email' => 'required|unique:suppliers',
    //     // 'contact_number' => 'min:10',
    //     // 'address' => 'min:10',
    //     // 'branch_id' => 'required',
    //     'is_active' => 'required',
    // ];
    protected $paginationTheme = 'bootstrap';


    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-supplier-modal');
    }

    public function submit()
    {

        $validateData = $this->validate([
            'supplier_name' => 'required',
            'email' => 'required|unique:suppliers',
            'email' => 'required',
        ]);

        // $validateData = $this->validate();
        // $validateData['branch_id'] = Auth::user()->branch_id;

        // Supplier::create($validateData);

        $supplier = Supplier::create([
            'supplier_name' => $this->supplier_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'branch_id' => Auth::user()->branch_id,
            'address' => $this->address,
            'is_active' => $this->is_active,
        ]);


        $this->dispatchBrowserEvent('hide-supplier-modal');

        session()->flash('message', 'New Supplier Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->supplier_name = '';
        $this->email = '';
        $this->contact_number = '';
        $this->address = '';
        $this->branch_id = '';
        $this->is_active = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-supplier-modal');
        $supplier = Supplier::findOrFail($id);
        $this->supplier_id = $id;
        // $this->branch_id = $supplier->branch_id;
        $this->supplier_name = $supplier->supplier_name;
        $this->email = $supplier->email;
        $this->contact_number = $supplier->contact_number;
        $this->address = $supplier->address;
        $this->is_active = $supplier->is_active;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'supplier_name' => 'required',
            'email' => 'email',
            // 'contact_number' => 'min:10',
            // 'address' => 'min:5',
            // 'branch_id' => 'required',
            'is_active' => 'required',
        ]);

        $supplier = Supplier::find($this->supplier_id);
        $supplier->update([
            'supplier_name' => $this->supplier_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'address' => $this->address,
            // 'branch_id' => $this->branch_id,
            'is_active' => $this->is_active,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-supplier-modal');

        session()->flash('message', 'Supplier Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deletesupplier_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Supplier::destroy($this->deletesupplier_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Supplier Data has been deleted.');

        $this->resetInputFields();
    }

    public function render()
    {

        $branches = Branch::all();

        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.staff-supplier',[
            'suppliers' => Supplier::where('supplier_name','like', $searchTerm)->paginate(5),
            'branches' => $branches
        ]);
    }

    //Supplier Products

    public function showProducts($id)
    {
        // dd($id);
        return redirect()->route('staff.suppliers.products',['supplier' => $id]);
    }


}
