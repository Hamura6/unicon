<?php

namespace App\Livewire;

use App\Models\Area;
use App\Models\Customer;
use App\Models\Person;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class SaleComponent extends Component
{
    use AuthorizesRequests, WithPagination;

    public $create = true, $scope = false, $viewSelect = 'sale';
    public $product = [], $sale = [], $area = [['base' => '']];
    public $nombre, $apellido, $ci, $telefono, $id;
    public $trans = 0, $encargado, $dir, $espacio = 'Elegir', $tipo = 'Elegir', $obs = 'Elegir', $comision;
    public $productsA, $search, $dateFrom, $dateTo;

    public function mount()
    {
        $this->authorize('view', Sale::make());
    }
    protected function rules()
    {
        return [
            'trans' => 'nullable',
            'nombre' => 'required|string',
            'ci' => 'required|numeric|digits_between:7,12|unique:people,ci,' . $this->id,
            'telefono' => 'required|numeric|unique:people,telefono,' . $this->id,
            'encargado' => 'required|string',
            'dir' => 'required|string',
            'espacio' => 'required|not_in:Elegir',
            'tipo' => 'required|not_in:Elegir',
            'obs' => 'required|not_in:Elegir',
            'comision' => 'required|numeric|min:0',
            'area.*.base' => 'required|numeric|min:1',
            'area.*.height' => 'required|numeric|between:' . $this->getFirstHeight() . ',' . $this->getLastHeight(),
        ];
    }

    public function render()
    {
        $products = $this->getProductsByCategory('Plastaformo', 'space');
        $sales = $this->getFilteredSales();
        $this->productsA = $this->getAvailableProducts();

        return view('livewire.sales.sale-component', compact('products', 'sales'))
            ->layout('layouts.base');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getResultsProperty()
    {
        return Person::join('customers as c', 'c.person_id', 'people.id')
            ->where('ci', 'LIKE', '%' . $this->ci . '%')
            ->select('people.nombre', 'people.id')
            ->take(5)
            ->get();
    }

    public function scoger(Person $person)
    {
        $this->fill([
            'nombre' => $person->nombre,
            'apellido' => $person->apellido,
            'ci' => $person->ci,
            'id' => $person->id,
            'telefono' => $person->telefono,
            'scope' => true,
        ]);
    }

    public function store()
    {
        $this->validate();
        $person = $this->savePerson();

        if ($person->estado === 'Bloqueado') {
            return $this->notifyClientBlocked();
        }

        $this->saveSale($person);
        $this->dispatch('closeModal');
        $this->notify('La cotización fue realizada correctamente', 'success', 'Cotización realizada');
        $this->clear();
    }

    public function show($id)
    {
        $this->sale = Sale::findOrFail($id);
        $this->populateSaleData();
        $this->create = false;
    }
    private function populateSaleData()
    {
        $this->nombre = $this->sale->customer->person->nombre;
        $this->apellido = $this->sale->customer->person->apellido;
        $this->ci = $this->sale->customer->person->ci;
        $this->telefono = $this->sale->customer->person->telefono;
        $this->encargado = $this->sale->encargado;
        $this->obs = $this->sale->observaciones;
        $this->espacio = strval(intval($this->sale->espaciado));
        $this->tipo = $this->sale->tipo;
        $this->trans = $this->sale->transporte;
        $this->comision = $this->sale->comision;
        $this->dir = $this->sale->direccion;

        $this->area = $this->sale->areas->map(function ($area) {
            return [
                'base' => $area->base,
                'height' => $area->altura,
            ];
        })->toArray();
        $this->product['plastaformo'] = $this->sale->products->contains('categoria', 'Plastaformo') ? true : false;
        $this->product['vigueta'] = $this->sale->products->contains('categoria', 'Vigueta') ? true : false;
    }

    public function update()
    {
        $this->validate();
        $person = Person::find($this->id);

        if ($person->estado === 'Bloqueado') {
            return $this->notifyClientBlocked();
        }

        $this->updateSale($person);
        $this->dispatch('closeModal');
        $this->notify('La cotización fue actualizada correctamente', 'success', 'Cotización actualizada');
        $this->clear();
    }

    public function add()
    {
        $this->area[] = ['base' => ''];
    }

    public function reduce()
    {
        if (count($this->area) > 1) {
            array_pop($this->area);
        }
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
        $this->create = true;
        $this->scope = false;
    }

    private function savePerson()
    {
        if ($this->scope) {
            return Person::updateOrCreate(['ci' => $this->ci], [
                'nombre' => $this->nombre,
                'apellido' => $this->apellido,
                'ci' => $this->ci,
                'telefono' => $this->telefono,
            ]);
        }

        $person = Person::create([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'ci' => $this->ci,
            'telefono' => $this->telefono,
        ]);
        $person->customer()->create(['email' => null]);

        return $person;
    }

    private function saveSale($person)
    {
        $sale = Sale::create([
            'customer_id' => $person->customer->id,
            'encargado' => $this->encargado,
            'observaciones' => $this->obs,
            'espaciado' => $this->espacio,
            'tipo' => $this->tipo,
            'transporte' => $this->trans,
            'comision' => $this->comision,
            'direccion' => $this->dir,
            'user_id' => Auth::id(),
        ]);

        $this->saveAreasAndProducts($sale);
    }

    private function updateSale($person)
    {
        $this->sale->update([
            'customer_id' => $person->customer->id,
            'encargado' => $this->encargado,
            'observaciones' => $this->obs,
            'espaciado' => $this->espacio,
            'tipo' => $this->tipo,
            'transporte' => $this->trans,
            'comision' => $this->comision,
            'direccion' => $this->dir,
        ]);

        $this->sale->products()->detach();
        Area::where('sale_id', $this->sale->id)->delete();
        $this->saveAreasAndProducts($this->sale);
    }

    private function saveAreasAndProducts($sale)
    {
        $plast = Product::select('id', 'caracteristicas', 'precio')->where('caracteristicas', 'LIKE', $this->obs . 'X' . $this->espacio . 'X%')->first();

        $space = explode('X', $plast->caracteristicas);
        $pieces = 0;

        foreach ($this->area as $area) {
            $width = round($area['base'] / (($space[1] + 7) / 100), 0, PHP_ROUND_HALF_UP);
            $sale->areas()->create([
                'base' => $area['base'],
                'altura' => $area['height'],
                'perimetro' => 2 * ($area['base'] + $area['height']),
                'espacio' => $width,
            ]);
            $pieces += (($area['height'] - 0.4) * $width);
        }

        if (!empty($this->product['plastaformo'])) {
            $pieces = round($pieces / ($space[2] / 100), 0, PHP_ROUND_HALF_UP);
            $sale->products()->attach($plast->id, [
                'cantidad' => $pieces,
                'precio' => $pieces * $plast->precio,
            ]);
        }
        if (!empty($this->product['vigueta'])) {
            $productV = Product::select('id', 'caracteristicas', 'precio')->where('categoria', 'Vigueta')->get();
            foreach ($this->area as $b) {
                foreach ($productV as $p) {
                    $part = explode('-', $p->caracteristicas);
                    if ($part[0] <= $b['height'] && $part[1] >= $b['height']) {
                        $sale->products()->attach($p->id, [
                            'cantidad' => $b['base'] * $b['height'],
                            'precio' => ($b['base'] * $b['height'] * $p->precio),
                        ]);
                        break;
                    }
                }
            }
        }
    }

    private function getProductsByCategory($category, $column)
    {
        return Product::where('categoria', $category)
            ->select(DB::raw("SUBSTRING(caracteristicas, 4, 2) as $column"))
            ->groupBy($column)
            ->get();
    }

    private function getFilteredSales()
    {
        return Sale::join('customers as c', 'c.id', 'sales.customer_id')
            ->join('people as p', 'p.id', 'c.person_id')
            ->select('p.nombre', 'p.ci', 'c.email', 'p.apellido', 'p.telefono', 'sales.id', 'sales.estado', 'sales.comision')
            ->where('p.nombre', 'LIKE', "%$this->search%")
            ->orWhere('p.telefono', 'LIKE', "%$this->search%")
            ->orWhere('p.apellido', 'LIKE', "%$this->search%")
            ->orWhere('p.ci', 'LIKE', "%$this->search%")
            ->orderBy('estado')
            ->paginate(6);
    }

    private function getAvailableProducts()
    {
        return Product::where('caracteristicas', 'LIKE', "%X$this->espacio%")
            ->where('categoria', 'Plastaformo')
            ->get(['caracteristicas', 'id']);
    }

    private function getFirstHeight()
    {
        return explode('-', Product::where('categoria', 'Vigueta')->orderBy('caracteristicas')->first()->caracteristicas)[0];
    }

    private function getLastHeight()
    {
        return explode('-', Product::where('categoria', 'Vigueta')->orderByDesc('caracteristicas')->first()->caracteristicas)[1];
    }

    private function notify($text, $icon, $title)
    {
        $this->dispatch('notify', text: $text, icon: $icon, title: $title);
    }

    private function notifyClientBlocked()
    {
        return $this->dispatch('notify', title: 'Error', text: 'Cliente bloqueado', icon: 'error');
    }
    protected $listeners = ['delete' => 'delete', 'next' => 'executeSale'];
    public function delete($id)
    {
        $sale = Sale::find($id);
        $sale->delete();
    }
    public function executeSale($id)
    {
        $sale = Sale::find($id);
        $products = $sale->products->where('categoria', 'Plastaformo');
        foreach ($products as $product) {
            $product->decrement('stock', $product->pivot->cantidad);
        }
        $sale->estado = 'Ejecutado';
        $sale->save();
        $this->notify('La venta fue ejecutado correctamente', 'Venta ejecutada', 'info');
    }
}
