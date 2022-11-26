<?php

namespace App\Http\Livewire\Admin;

use App\Models\Banner;
use Livewire\Component;

class AdminBannerComponent extends Component
{

    public function deleteBanner($banner_id)
    {
        $banner = Banner::find($banner_id);
        if($banner->image){
            unlink('assets/images/banners'.'/'.$banner->image);
        }
        $banner->delete();
        session()->flash('message','Banner has been deleted successflly!');
    }

    public function render()
    {
        $banners = Banner::all();
        return view('livewire.admin.admin-banner-component',['banners' => $banners])->layout('layouts.base');
    }
}
