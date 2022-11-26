<?php

namespace App\Http\Livewire\Admin;

use App\Models\Team;
use Livewire\Component;

class AdminTeamComponent extends Component
{

    public function deleteTeamMember($member_id)
    {
        $member = Team::find($member_id);
        if($member->image){
            unlink('assets/images/team'.'/'.$member->image);
        }
        $member->delete();
        session()->flash('message','Team member has been deleted successflly!');
    }

    public function render()
    {
        $team = Team::all();
        return view('livewire.admin.admin-team-component', ['team'=>$team])->layout('layouts.base');
    }
}
