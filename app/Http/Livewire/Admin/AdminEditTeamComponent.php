<?php

namespace App\Http\Livewire\Admin;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class AdminEditTeamComponent extends Component
{

    use WithFileUploads;

    public $m_id;
    public $name;
    public $role;
    public $description;
    public $image;
    public $newimage;

    public function mount($member_id)
    {
        $member = Team::where('id',$member_id)->first();
        $this->name = $member->name;
        $this->role = $member->role;
        $this->description = $member->description;
        $this->image = $member->image;
        $this->m_id = $member_id;
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => 'required',
            'role' => 'required',
            'description' => 'required'
        ]);
        if($this->newimage){
            $this->validateOnly($fields,[
                'newimage' => 'required|mimes:jpg,jpeg,png'
            ]);
        }
    }

    public function updateMember()
    {
        $this->validate([
            'name' => 'required',
            'role' => 'required',
            'description' => 'required'
        ]); 

        if($this->newimage){
            $this->validate([
                'newimage' => 'required|mimes:jpg,jpeg,png'
            ]);
        }

        $member = Team::find($this->m_id);
        $member->name = $this->name;
        $member->role = $this->role;
        $member->description = $this->description;

        if($this->newimage){
            unlink('assets/images/team'.'/'.$member->image);
            $imageName = Carbon::now()->timestamp. '.' . $this->newimage->extension();
            $this->newimage->storeAs('team',$imageName);
            $member->image = $imageName;
        }

        $member->save();

        session()->flash('message','Member has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.admin-edit-team-component')->layout('layouts.base');
    }
}
