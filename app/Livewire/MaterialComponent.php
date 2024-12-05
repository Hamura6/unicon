<?php

namespace App\Livewire;

use App\Models\Buy;
use App\Models\Material;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Permission;

class MaterialComponent extends Component
{
    use AuthorizesRequests, WithPagination, WithFileUploads;
    public $create, $image, $search;
    public $material=[],$buy=[];
    protected $listeners = ['delete' => 'destroy'];
    public function mount()
    {
        $this->authorize('view',Material::make());
        $this->create = true;
        $this->material['id']=null;
        $this->buy['supplier_id']='Elegir';
        $this->material['nombre']=null;
    }
    protected function rules()
    {
        return [
            'material.nombre' => 'required|min:5|string',
            'material.marca' => 'required|string',
            'material.stock' => 'nullable',
            'buy.precio' => 'required|numeric|between:20,99999',
            'buy.cantidad' => 'required|numeric|between:25,99999',
            'buy.supplier_id' => 'not_in:Elegir'
        ];
    }
    public function render()
    {
        $materials = Material::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->orderBy('nombre', 'asc')->take(40)->paginate(12);
        $suppliers = Supplier::join('people as p','p.id','suppliers.person_id')
        ->select('suppliers.id as id','p.nombre','p.apellido')
        ->where('p.estado','Activo')
        ->orderBy('nombre', 'asc')->get();
        return view('livewire.materials.material-component', compact('materials', 'suppliers'))
        ->layout('layouts.base');
    }
    public function store()
    {
        $this->validate();
        $material = Material::updateOrInsert(['nombre' => $this->material['nombre'], 'marca' => $this->material['marca']])->first();
        $material->increment('stock', $this->buy['cantidad']);
        $this->buy['user_id'] = Auth::user()->id;
        $material->buys()->create($this->buy);
        if ($this->image) {
            $custom_file_name = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('materials', $custom_file_name,'public');
            $material->foto = $custom_file_name;
            $material->save();
        }
        $this->clear();
        $this->dispatch('closeModal');
        $this->notify('Material registrado','El material fue agregado al inventario correctamente','success');
    }
    public function edit(Material $material)
    {
        $this->material['nombre'] = $material->nombre;
        $this->material['marca'] = $material->marca;
        $this->material['stock'] = $material->stock;
        $this->material['foto'] = $material->imagen;
        $this->material['id'] = $material->id;
        $this->create = false;
    }
    public function update()
    {
        $this->validate([
            'material.nombre' => 'required|min:5|string',
            'material.marca' => 'required|string',
            'material.stock' => 'required',
        ]);
        $material=Material::find($this->material['id']);
        $material->update(collect($this->material)->except('id','foto')->toArray());
        if ($this->image) {
            $custom_file_name = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('materials', $custom_file_name,'public');
            $imageTem = $material->foto;
            $material->foto = $custom_file_name;
            $material->save();
            if ($imageTem!= null) {
                if (file_exists(public_path('storage/materials/' . $imageTem))) {
                    unlink(public_path('storage/materials/' . $imageTem));
                }
            }
        }
        $this->clear();
        $this->dispatch('closeModal');
        $this->notify('Registro Actualizado','Los datos del material fueron actualizados correctamente', 'info');

    }
    public function destroy($id)
    {
        $material=Material::find($id);

        if ($material->foto != null) {
            if (file_exists(public_path('storage/materials/' . $material->foto))) {
                unlink(public_path('storage/materials/' . $material->foto));
            }
        }
        $material->delete();
    }
    public function clear()
    {
        $this->resetValidation();
        $this->reset();
        $this->create = true;
        $this->material['id']=null;
        $this->buy['supplier_id']='Elegir';
    }
    public function getResultsProperty()
    {
        return Material::where('nombre', 'LIKE', '%' . $this->material['nombre'] . '%')->take(5)->get();
    }
    public function scoger(Material $material)
    {
        $this->material['nombre']= $material->nombre;
        $this->material['marca']= $material->marca;
        $this->material['id']= $material->id;
        $this->create = true;
    }
    public function notify($title,$text,$icon){
        $this->dispatch('notify',text:$text,title:$title,icon:$icon);
    }

}
