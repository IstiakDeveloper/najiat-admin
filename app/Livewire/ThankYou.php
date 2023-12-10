<?php

namespace App\Livewire;

use Livewire\Component;

class ThankYou extends Component
{
    public $invoice;

    public function mount($invoice)
    {
        $this->invoice = $invoice;
    }

    public function render()
    {
        return view('livewire.thank-you');
    }
}
