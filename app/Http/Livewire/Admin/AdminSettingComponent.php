<?php

namespace App\Http\Livewire\Admin;

use App\Models\setting;
use Livewire\Component;

class AdminSettingComponent extends Component
{

    public $email;
    public $phone;
    public $hotline;
    public $address;
    public $map;
    public $twiter;
    public $facebook;
    public $whatsapp;
    public $instagram;
    public $youtube;

    public function mount(){
        $setting = setting::find(1);
        if($setting){
           $this->email = $setting->email;
           $this->phone = $setting->phone;
           $this->hotline = $setting->hotline;
           $this->address = $setting->address;
           $this->map = $setting->map;
           $this->twiter = $setting->twiter;
           $this->facebook = $setting->facebook;
           $this->whatsapp = $setting->whatsapp;
           $this->instagram = $setting->instagram;
           $this->youtube = $setting->youtube;
        }
    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'email' => 'required|email',
            'phone' => 'required',
            'hotline' => 'required',
            'address' => 'required',
            'map' => 'required',
            'twiter' => 'required',
            'facebook' => 'required',
            'whatsapp' => 'required',
            'instagram' => 'required',
            'youtube' => 'required'
        ]);
    }

    public function saveSettings(){
        $this->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'hotline' => 'required',
            'address' => 'required',
            'map' => 'required',
            'twiter' => 'required',
            'facebook' => 'required',
            'whatsapp' => 'required',
            'instagram' => 'required',
            'youtube' => 'required'
        ]);

        $setting = setting::find(1);
        if(!$setting){
            $setting = new setting();
        }

        $setting->email = $this->email;
        $setting->phone = $this->phone;
        $setting->hotline = $this->hotline;
        $setting->address = $this->address;
        $setting->map = $this->map;
        $setting->twiter = $this->twiter;
        $setting->facebook = $this->facebook;
        $setting->whatsapp = $this->whatsapp;
        $setting->instagram = $this->instagram;
        $setting->youtube = $this->youtube;
        $setting->save();
        session()->flash('message','Settings has been saved successfully');
    }

    public function render()
    {
        return view('livewire.admin.admin-setting-component')->layout('layouts.base');
    }
}
