<?php

namespace App\Http\Livewire\Admin;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class AdminEditBannerComponent extends Component
{


    use WithFileUploads;

    public $b_id;
    public $name;
    public $label;
    public $btntxt;
    public $link;
    public $description;
    public $image;

    public $newimage;

    public function mount($banner_id)
    {
        $banner = Banner::where('id',$banner_id)->first();
        $this->name = $banner->name;
        $this->label = $banner->label;
        $this->btntxt = $banner->btntxt;
        $this->link = $banner->link;
        $this->description = $banner->description;
        $this->image = $banner->image;
        $this->b_id = $banner_id;
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => 'required',
            'label' => 'required',
            'btntxt' => 'required',
            'link' => 'required',
            'description' => 'required'
        ]);
        if($this->newimage){
            $this->validateOnly($fields,[
                'newimage' => 'required|mimes:jpg,jpeg,png'
            ]);
        }
    }

    public function updateBanner()
    {
        $this->validate([
            'name' => 'required',
            'label' => 'required',
            'btntxt' => 'required',
            'link' => 'required',
            'description' => 'required'
        ]); 

        if($this->newimage){
            $this->validate([
                'newimage' => 'required|mimes:jpg,jpeg,png'
            ]);
        }

        $banner = Banner::find($this->b_id);
        $banner->name = $this->name;
        $banner->label = $this->label;
        $banner->btntxt = $this->btntxt;
        $banner->link = $this->link;
        $banner->description = $this->description;

        if($this->newimage){
            unlink('assets/images/banners'.'/'.$banner->image);
            $imageName = Carbon::now()->timestamp. '.' . $this->newimage->extension();
            $this->newimage->storeAs('banners',$imageName);
            $banner->image = $imageName;
        }

        $banner->save();

        session()->flash('message','Banner has been updated successfully!');
    }

    public function render()
    {
        return view('livewire.admin.admin-edit-banner-component')->layout('layouts.base');
    }
}
