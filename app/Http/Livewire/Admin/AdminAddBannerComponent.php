<?php

namespace App\Http\Livewire\Admin;

use App\Models\Banner;
use Livewire\Component;
use Carbon\Carbon;
use Livewire\WithFileUploads;

class AdminAddBannerComponent extends Component
{

    use WithFileUploads;

    public $name;
    public $label;
    public $description;
    public $btntxt;
    public $link;
    public $image;
    public $NamesOfBanners = ['Home Banner Left: 580 x 190 px', 
                                'Home Banner Right: 580 x 190 px', 
                                'Last Product Banner: 1170 x 240 px', 
                                'Categories Banner: 1170 x 240 px', 
                                'Shop Banner: 870 x 272 px'];

    public function mount()
    {
        $allBanners = Banner::all();
        foreach($allBanners as $banner){
            if(in_array($banner->name, $this->NamesOfBanners))
            {
                $key = array_search($banner->name, $this->NamesOfBanners);
                unset($this->NamesOfBanners[$key]);
            }
        }
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => 'required',
            'label' => 'required',
            'btntxt' => 'required',
            'link' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);
    }

    public function addNewBanner(){

        $this->validate([
            'name' => 'required',
            'label' => 'required',
            'btntxt' => 'required',
            'link' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png'
        ]); 

        $banner = new Banner();
        $banner->name = $this->name;
        $banner->label = $this->label;
        $banner->btntxt = $this->btntxt;
        $banner->link = $this->link;
        $banner->description = $this->description;

        $imageName = Carbon::now()->timestamp. '.' . $this->image->extension();
        $this->image->storeAs('banners',$imageName);
        $banner->image = $imageName;

        
        $banner->save();
        session()->flash('message','New Banner has been created successfully!');
        return redirect()->route('admin.banner');

    }

    public function render()
    {
        return view('livewire.admin.admin-add-banner-component',['NamesOfBanners' => $this->NamesOfBanners])->layout('layouts.base');
    }
}
