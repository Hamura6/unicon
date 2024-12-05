<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Customer;
use App\Models\Person;
use App\Models\Production;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }
    public function storePerson(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|min:4',
            'apellido' => 'required|string|min:4',
            'telefono' => 'required|numeric|digits:8|unique:people,telefono,' . Auth::user()->id,
            'ci' => 'required|numeric|digits_between:8,12|unique:people,ci,' . Auth::user()->id,
            'fecha_n' => 'required|date|before:' . Carbon::now()->subYear(18),
            'direccion' => 'required|string'

        ]);
        $user = Auth::user();
        $user->direccion = $request->direccion;
        $user->fecha_n = $request->fecha_n;
        $user->save();
        $person = Person::find($user->id);
        $person->nombre = $request->nombre;
        $person->apellido = $request->apellido;
        $person->telefono = $request->telefono;
        $person->ci = $request->ci;
        $person->save();
        return redirect()->route('profile.edit', compact('user'))->with('Actuzalizado', 'OK');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        ]);
        $user = Auth::user();
        $user->email = $request->email;
        if ($request->foto) {
            $name_custom = uniqid() . '.' . $request->foto->extension();
            $request->foto->storeAs('users', $name_custom, 'public');
            if (Auth::user()->foto) {
                if (file_exists(public_path('storage/users/' . Auth::user()->foto)))
                    unlink(public_path('storage/users/' . Auth::user()->foto));
            }
            $user->foto = $name_custom;
        }
        $user->save();
        return redirect()->route('profile.edit', compact('user'))->with('Actuzalizado', 'OK');
    }

    public function storeKey(Request $request)
    {
        $request->validate([
            'last_password' => 'required|current_password',
            'password' => 'required|min:5|confirmed'
        ]);
        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('profile.edit', compact('user'))->with('Actuzalizado', 'OK');
    }
    public function controlPanel()
    {
        $date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $dates = Carbon::now()->endOfMonth()->format('Y-m-d');
        $sales = Sale::whereDate('updated_at', '>=', $date)->whereDate('updated_at', '<=', $dates)->get();
        $buys = Buy::whereDate('updated_at', '>=', $date)->whereDate('updated_at', '<=', $dates)->get();
        $productions = Production::where('estado', 'Concluido')->whereDate('updated_at', '>=', $date)->whereDate('updated_at', '<=', $dates)->get();
        $products1 = DB::table('sales')->join('product_sale as pr', 'pr.sale_id', 'sales.id')
            ->where('sales.estado', 'Ejecutado')
            ->select(DB::raw('SUM(cantidad) as total'), 'nombre')
            ->join('products as p', 'p.id', 'pr.product_id')
            ->groupBy('nombre')->where('p.categoria', 'Plastaformo')
            ->orderBy('total', 'desc')
            ->take(3)
            ->whereDate('sales.updated_at', '>=', $date)
            ->whereDate('sales.updated_at', '<=', $dates)->get();
            $salesUsers = User::join('sales as s', 's.user_id', '=', 'users.id')
            ->join('product_sale as p', 'p.sale_id', '=', 's.id')
            ->join('people as pe', 'pe.id', '=', 'users.person_id')
            ->select(
                DB::raw('(SUM(p.precio) * 0.76) as price_full'),
                DB::raw('CONCAT_WS(" ", pe.nombre, pe.apellido) as CNombre')
            )
            ->where('s.estado', 'Ejecutado')
            ->groupBy('pe.nombre', 'pe.apellido')
            ->get();
        $productionsC = Production::where('estado', 'Concluido')
            ->join('production_product as p', 'p.production_id', 'productions.id')
            ->join('products as np', 'np.id', 'p.product_id')
            ->select(DB::raw('SUM(p.cantidad) as total'), 'nombre')
            ->groupBy('nombre') 
            ->get();
        $users = User::join('people as p','p.id','users.person_id')
        ->get();
        $suppliers = Supplier::join('people as p','p.id','suppliers.person_id')
        ->get();
        $customers = Customer::join('people as p','p.id','customers.person_id')
        ->get();
        return view('panelControl', compact('customers','suppliers','users','salesUsers', 'productionsC', 'sales', 'buys', 'products1', 'productions'));
    }
}
