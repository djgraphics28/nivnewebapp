<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StaffStocksProductoutModal extends Component
{
    public $product_list = [];

    public function render()
    {
        return view('livewire.staff-stocks-productout-modal');
    }
}
