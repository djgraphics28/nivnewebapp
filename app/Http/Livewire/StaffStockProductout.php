<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StaffStockProductout extends Component
{

    public function add()
    {
        $this->dispatchBrowserEvent('show-productout-modal');
    }
    public function render()
    {
        return view('livewire.staff-stock-productout');
    }
}
