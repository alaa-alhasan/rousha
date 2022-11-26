<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProductAttribute;
use Livewire\Component;

class AdminAddAttributeComponent extends Component
{
    public $name;

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => 'required'
        ]);
    }

    public function storeAttribute(){
        $this->validate([
            'name' => 'required'
        ]);

        $pattribute = new ProductAttribute();
        $pattribute->name = $this->name;
        $pattribute->save();
        session()->flash('message','Attribute has been added successfully');
    }
    public function render()
    {
        $colorAttr = ProductAttribute::where('name','Color')->first();
        $sizeAttr = ProductAttribute::where('name','Size')->first();

        return view('livewire.admin.admin-add-attribute-component',['colorAttr' => $colorAttr, 'sizeAttr' => $sizeAttr])->layout('layouts.base');
    }
}
