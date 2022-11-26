<?php

namespace App\Http\Livewire\Admin;

use App\Models\Team;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminAddTeamComponent extends Component
{
    use WithFileUploads;

    public $name;
    public $role;
    public $description;
    public $image;

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => 'required',
            'role' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);
    }

    public function addNewMember(){

        $this->validate([
            'name' => 'required',
            'role' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png'
        ]); 

        $member = new Team();
        $member->name = $this->name;
        $member->role = $this->role;
        $member->description = $this->description;

        $imageName = Carbon::now()->timestamp. '.' . $this->image->extension();
        $this->image->storeAs('team',$imageName);
        $member->image = $imageName;

        $member->save();

        session()->flash('message','New member has been created successfully!');

    }

    public function render()
    {
        return view('livewire.admin.admin-add-team-component')->layout('layouts.base');
    }
}
