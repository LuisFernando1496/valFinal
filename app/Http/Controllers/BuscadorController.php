<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Category;
use App\Models\Client;
use App\Models\Credit;
use App\Models\Expense;
use App\Models\Office;
use App\Models\Product;
use App\Models\Quote;
use App\Models\Sale;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuscadorController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;
        $option = $request->option;
        $user = Auth::user();

        switch ($request->option) {
            case 'Negocios':
                $negocios = Business::where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('rfc', 'like', '%' . $request->search . '%')
                    ->orWhere('legal_representative', 'like', '%' . $request->search . '%')
                    ->orWhere('number', 'like', '%' . $request->search . '%')
                    ->paginate(5);
                return view('searchResult.searchNegocios', compact('negocios', 'search', 'option'));
                break;

            case 'Sucursales':
                $oficinas = Office::join("businesses", "businesses.id", "offices.business_id")
                    ->join("addresses", "addresses.id", "offices.address_id")
                    ->where("offices.name", "like", "%" . $request->search . "%")
                    ->orWhere("offices.phone", "like", "%" . $request->search . "%")
                    ->orWhere("offices.responsable", "like", "%" . $request->search . "%")
                    ->orWhere("businesses.name", "like", "%" . $request->search . "%")
                    ->select(
                        'offices.id',
                        'offices.name',
                        'offices.phone',
                        'offices.responsable',
                        DB::raw("CONCAT(addresses.street, '  ',addresses.number, ' ',addresses.suburb,
                                                        ' ', addresses.postal_code, ' ', addresses.city, ', ',addresses.state,', ',addresses.country ) AS address"),
                        DB::raw("CONCAT(businesses.name) AS negocio"),
                    )
                    ->paginate(5);
                //  return $oficinas;
                return view('searchResult.searchSucursales', compact('oficinas', 'search', 'option'));
                break;

            case 'Usuarios':
                //getDataModelsSearch es una funcion que esta en el archivo helpers.php que retorna una consulta con los datos de la busqueda validados por sucursal
                $users = getDataModelsSearch($user, User::class, $request->search);
                return view('searchResult.searchUsuarios', compact('users', 'search', 'option'));
                break;

            case 'Almacenes':
                $almacenes = getDataModelsSearch($user, Warehouse::class, $request->search);
                return view('searchResult.searchAlmacenes', compact('almacenes', 'search', 'option'));
                break;

            case 'Categorias':
                $categorias = getDataModelsSearch($user, Category::class, $request->search);
                return view('searchResult.searchCategorias', compact('categorias', 'search', 'option'));
                break;

            case 'Proveedores':
                $vendors = getDataModelsSearch($user, Vendor::class, $request->search);
                return view('searchResult.searchProveedores', compact('vendors', 'search', 'option'));
                break;

            case 'Productos':
                $productos = getDataModelsSearch($user, Product::class, $request->search);
                return view('searchResult.searchProductos', compact('productos', 'search', 'option'));
                break;

            case 'Servicios':
                $servicios = getDataModelsSearch($user, Service::class, $request->search);
                return view('searchResult.searchServicios', compact('servicios', 'search', 'option'));
                break;

            case 'Clientes':
                $clientes = getDataModelsSearch($user, Client::class, $request->search);
                return view('searchResult.searchClientes', compact('clientes', 'search', 'option'));
                break;

            case 'Creditos':
                $creditos = getDataModelsSearch($user, Credit::class, $request->search);
                return view('searchResult.searchCreditos', compact('creditos', 'search', 'option'));
                break;

            case 'Ventas':
                $ventas = getDataModelsSearch($user, Sale::class, $request->search);
                //  return $ventas; mejorar la consulta
                return view('searchResult.searchVentas', compact('ventas', 'search', 'option'));
                break;

            case 'Cotizaciones':
                $cotizaciones = getDataModelsSearch($user, Quote::class, $request->search);
                return view('searchResult.searchCotizaciones', compact('cotizaciones', 'search', 'option'));
                break;

            case 'Gastos':
                $expenses = getDataModelsSearch($user, Expense::class, $request->search);
                return view('searchResult.searchGastos', compact('expenses', 'search', 'option'));
                break;
            default:
                return response()->json(['data' => $request->all()]);
                break;
        }
    }
}
