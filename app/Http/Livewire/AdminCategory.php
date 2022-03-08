<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class AdminCategory extends Component
{
    use WithPagination;

    public $category_name;
    public $is_active;

    public $searchTerm;
    public $updateMode = false;
    public $category;
    public $category_id;
    public $checkedCategory = [];
    public $deletecategory_id = null;

    protected $rules = [
        'category_name' => 'required',
        'is_active' => 'required',
    ];
    protected $paginationTheme = 'bootstrap';
    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-category-modal');
    }

    public function submit()
    {
        $validateData = $this->validate();

        Category::create($validateData);

        $this->dispatchBrowserEvent('hide-category-modal');

        session()->flash('message', 'New Category Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->category_name = '';
        $this->is_active = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-category-modal');
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->category_name = $category->category_name;
        $this->is_active = $category->is_active;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'category_name' => 'required',
            'is_active' => 'required',
        ]);

        $category = Category::find($this->branch_id);
        $category->update([
            'category_name' => $this->category_name,
            'is_active' => $this->is_active,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-category-modal');

        session()->flash('message', 'Category Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deletecategory_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        Category::destroy($this->deletecategory_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'Category Data has been deleted.');

        $this->resetInputFields();
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.admin-category',[
            'categories' => Category::where('category_name','like', $searchTerm)->latest()->paginate(5)
        ]);
    }


}
