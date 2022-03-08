<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUser extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name;
    public $email;
    public $role;
    public $password;
    public $branch_id;
    public $photo;
    public $contact_number;

    public $searchTerm;
    public $updateMode = false;
    public $user;
    public $user_id;
    public $deleteuser_id = null;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'role' => 'required',
        'password' => 'required|min:7',
        'branch_id' => 'required',
        // 'photo' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
    ];
    protected $paginationTheme = 'bootstrap';
    public function addNew()
    {
        $this->resetInputFields();
        $this->updateMode = false;
        $this->dispatchBrowserEvent('show-user-modal');
    }

    public function submit()
    {
        $validateData = $this->validate();

        $validateData['password'] = Hash::make($this->password);

        $validateData['contact_number'] = $this->contact_number;

        // $validateData = $this->photo->store('photo', 'public');

        User::create($validateData);

        $this->dispatchBrowserEvent('hide-user-modal');

        session()->flash('message', 'New User Data Successfully Added!');

        return redirect()->back();
    }

    private function resetInputFields(){
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->password = '';
        $this->branch_id = '';
        $this->photo = '';
        $this->contact_number = '';
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $this->dispatchBrowserEvent('show-user-modal');
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->contact_number = $user->contact_number;
        $this->role = $user->role;
        $this->password = $user->password;
        $this->branch_id = $user->branch_id;
        $this->photo = $user->photo;
        $this->updateMode = true;
    }

    public function update()
    {
        $validateData = $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'required|min:7',
            'branch_id' => 'required',
        ]);

        $user = User::find($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => Hash::make($this->password),
            'branch_id' => $this->branch_id,
            'contact_number' => $this->contact_number,
            'photo' => $this->photo,
        ]);

        $this->updateMode = false;

        $this->dispatchBrowserEvent('hide-user-modal');

        session()->flash('message', 'User Data Updated Successfully.');

        $this->resetInputFields();
    }

    public function confirmation($deleteid)
    {
        $this->deleteuser_id = $deleteid;
        $this->dispatchBrowserEvent('show-confirmation-delete-modal');

    }

    public function delete()
    {
        // dd('here');
        User::destroy($this->deleteuser_id);

        $this->dispatchBrowserEvent('hide-confirmation-delete-modal');

        session()->flash('message', 'User Data has been deleted.');

        $this->resetInputFields();
    }

    public function render()
    {
        $branches = Branch::all();

        $searchTerm = '%'.$this->searchTerm.'%';
        return view('livewire.admin-user',[
            'users' => User::where('name','like', $searchTerm)
                        ->orWhere('email','like', $searchTerm)->latest()->paginate(5),
            'branches' => $branches
        ]);
    }


}
