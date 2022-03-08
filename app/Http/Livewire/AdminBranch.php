<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class AdminBranch extends Component
{
    use WithPagination;

    public $branch_name;
    public $address;
    public $is_active;

    public $searchTerm;
    public $updateMode = false;
    public $branch;
    public $branch_id;
    public $deletebranch_id = null;

    protected $rules = [
        'branch_name' => 'required',
        'address' => 'min:7',
        'is_active' => 'required',
    ];
    protected $paginationTheme = 'bootstrap';
    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-branch-modal');
    }

    public function submit()
    {
        $validateData = $this->validate();

        Branch::create($validateData);

        $this->dispatchBrowserEvent('hide-branch-modal');

        session()->flash('message', 'New Branch Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->branch_name = '';
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
        $this->dispatchBrowserEvent('show-branch-modal');
        $branch = Branch::findOrFail($id);
        $this->branch_id = $id;
        $this->branch_name = $branch->branch_name;
        $this->address = $branch->address;
        $this->is_active = $branch->is_active;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'branch_name' => 'required',
            'address' => 'min:7',
        ]);

        $branch = Branch::find($this->branch_id);
        $branch->update([
            'branch_name' => $this->branch_name,
            'address' => $this->address,
            'is_active' => $this->is_active,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-branch-modal');

        session()->flash('message', 'Branch Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deletebranch_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Branch::destroy($this->deletebranch_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Branch Data has been deleted.');

        $this->resetInputFields();
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.admin-branch',[
            'branches' => Branch::where('branch_name','like', $searchTerm)
                        ->orWhere('address','like', $searchTerm)->latest()->paginate(5)
        ]);
    }


}
