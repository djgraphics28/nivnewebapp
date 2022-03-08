<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class StaffBrand extends Component
{
    use WithPagination;

    public $brand_name;
    public $is_active;

    public $searchTerm;
    public $updateMode = false;
    public $brand;
    public $brand_id;
    public $deletebrand_id = null;

    protected $rules = [
        'brand_name' => 'required',
        'is_active' => 'required',
    ];
    protected $paginationTheme = 'bootstrap';
    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-brand-modal');
    }

    public function submit()
    {
        $validateData = $this->validate();

        Brand::create($validateData);

        $this->dispatchBrowserEvent('hide-brand-modal');

        session()->flash('message', 'New Brand Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->brand_name = '';
        $this->is_active = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-brand-modal');
        $brand = Brand::findOrFail($id);
        $this->brand_id = $id;
        $this->brand_name = $brand->brand_name;
        $this->is_active = $brand->is_active;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'brand_name' => 'required',
            'is_active' => 'required',
        ]);

        $brand = Brand::find($this->brand_id);
        $brand->update([
            'brand_name' => $this->brand_name,
            'is_active' => $this->is_active,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-brand-modal');

        session()->flash('message', 'Brand Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deletebrand_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Brand::destroy($this->deletebrand_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Brand Data has been deleted.');

        $this->resetInputFields();
    }

    public function switchStatus()
    {
        dd('here');
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.staff-brand',[
            'brands' => Brand::where('brand_name','like', $searchTerm)->latest()->paginate(5)
        ]);
    }


}
