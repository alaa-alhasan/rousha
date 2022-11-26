<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\setting;

class FooterComponent extends Component
{
    public function render()
    {
        $setting = setting::find(1);
        return view('livewire.footer-component',['setting'=>$setting]);
    }
}
