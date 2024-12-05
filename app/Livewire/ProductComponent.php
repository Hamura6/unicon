<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ProductComponent extends Component
{
    use AuthorizesRequests,WithPagination,WithFileUploads;
    public $create=true,$search,$selector,$a,$b,$c,$foto;
    public $nombre,$precio,$stock,$descripcion,$image,$id,$categoria;
    protected function rules()
    {
        return [
            'nombre' => 'required|min:3|unique:products,nombre,' . $this->id,
            'precio' => 'required|numeric',
            'stock' => 'required|numeric',
            'descripcion' => 'required',
            'categoria' => 'nullable',
        ];
    }
    public function mount(){
        $this->authorize('view',Product::make());

    }
    public function render()
    {
        $products=Product::where('nombre','LIKE','%'.$this->search.'%')
        ->orWhere('categoria','LIKE','%'.$this->search.'%')
        ->take(50)->paginate(10);
        return view('livewire.products.product-component',compact('products'))
        ->layout('layouts.base');
    }
    public function store(){
        $this->validate();
        $this->validate([
            'a' => 'required|numeric|between:7,100',
            'b' => 'required|numeric|between:15,150',
            'c' => 'required|numeric|between:15,200',
        ]);
        $product=Product::create([
            'nombre'=>$this->nombre,
            'precio'=>$this->precio,
            'stock'=>$this->stock,
            'caracteristicas'=>$this->a . 'X' . $this->b . 'X' . $this->c,
            'categoria'=>'Plastaformo',
            'descripcion'=>$this->descripcion
        ]);
        if ($this->image) {
            $custom_file_name = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('products',$custom_file_name,'public');
            $this->product->foto = $custom_file_name;
            $product->save();
        }
        $this->clear();
        $this->dispatch('closeModal');
        $this->dispatch('notify', text: 'El producto fue agregado al inventario correctamente', title: 'Producto registrado', icon:'success');
    }
    public function update(){
        $product=Product::find($this->id);
        $this->validate();
        if ($product->categoria == 'Plastaformo') {
            $this->validate([
                'a' => 'required|numeric|between:7,100',
                'b' => 'required|numeric|between:15,150',
                'c' => 'required|numeric|between:15,200',
            ]);
            $product->caracteristicas = $this->a . 'X' . $this->b . 'X' . $this->c;
        }

        if ($this->image) {
            $custom_file_name = uniqid() . '.' . $this->image->extension();
            $this->image->storeAs('products',$custom_file_name,'public');
            $image = $product->foto;
            $product->foto = $custom_file_name;
            if ($image != null) {
                if (file_exists(public_path('storage/products/' . $image))) {
                    unlink(public_path('storage/products/' . $image));
                }
            }
        }
        $product->nombre = $this->nombre;
        $product->precio = $this->precio;
        $product->stock = $this->stock;
        $product->descripcion = $this->descripcion;
        $product->save();
        $this->clear();
        $this->dispatch('closeModal', text: 'El producto fue actualizado correctamente',title: 'Producto actualizado', icon: 'info');
    }
    public function edit(Product $product){
        $this->nombre = $product->nombre;
        $this->precio = $product->precio;
        $this->stock = $product->stock;
        $this->descripcion = $product->descripcion;
        $this->foto = $product->imagen;
        $this->id = $product->id;
        if ($product->categoria == 'Plastaformo') {
            $d = explode('X', $product->caracteristicas);
            $this->a = $d[0];
            $this->b = $d[1];
            $this->c = $d[2];
        }
        $this->create = false;
    }
    protected $listeners=['delete'=>'delete'];
    public function delete($id){
        $product=Product::find($id);
        if ($product->foto) {
            if (file_exists(public_path('storage/products/' . $product->foto))) {
                unlink(public_path('storage/products/' . $product->foto));
            }
        }
        $product->delete();
    }
    public function clear(){
        $this->reset();
        $this->resetValidation();
    }
}
