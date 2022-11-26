<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;

class Aboutus extends Component
{
    public function render()
    {
        $team = Team::all();
        return view('livewire.aboutus', ['team'=>$team])->layout('layouts.base');
    }
}
