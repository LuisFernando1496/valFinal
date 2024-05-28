<?php

use Illuminate\Support\Facades\Route;
//agregar controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseSaleController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TrolleyController;
use App\Http\Controllers\UserCashController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\VisitsController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/home/store', [App\Http\Controllers\HomeController::class, 'store'])->name('history.store');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('address', AddressController::class);
    Route::resource('almacenes', WarehouseController::class);
    Route::resource('ventaalmacen', TrolleyController::class);
    Route::resource('boxes', CashRegisterController::class);
    Route::resource('categorias', CategoryController::class);
    Route::resource('clientes', ClientController::class);
    Route::resource('compras', BuyController::class);
    Route::resource('cotizaciones', QuoteController::class);
    Route::get('cotizaciones/{id}/imprimir', [QuoteController::class, 'imprimir'])->name('cotizaciones.imprimir');
    Route::resource('creditos', CreditController::class);
    Route::get('creditos/detalles/abonos/{id}', [CreditController::class, 'details'])->name('detalles-abonos');
    Route::get('creditos/historial-compras/{client}', [CreditController::class, 'historialCompras'])->name('historyShop');
    Route::post('creditos/abono/{id}', [CreditController::class, 'abonoCredit'])->name('abonoCredit');
    Route::get('/creditos/historial-compras/creditos/comprobante/{id}', [CreditController::class, 'comprobante'])->name('comprobante');
    Route::controller(InventoryController::class)->group(function () {
        Route::get('inventario', 'index')->name('inventario.index');
        Route::get('inventario/{id}', 'show')->name('inventario.show');
        Route::get('inventario/{id}/create', 'create')->name('inventario.create');
        Route::post('inventario', 'store')->name('inventario.store');
        Route::get('inventario/{id}/edit', 'edit')->name('inventario.edit');
        Route::put('inventario/{id}/update', 'update')->name('inventario.update');
        Route::delete('inventario/{id}', 'destroy')->name('inventario.destroy');
    });
    Route::resource('negocios', BusinessController::class);
    Route::resource('productos', ProductController::class);
    Route::resource('proveedores', VendorController::class);
    Route::resource('reportes', ReportController::class);
    Route::resource('roles', RolController::class);
    Route::resource('servicios', ServiceController::class);
    Route::resource('sucursales', OfficeController::class);
    Route::resource('transferencias', TransferController::class);
    Route::resource('usuarios', UserController::class);
    Route::resource('ventas', SaleController::class);
    Route::resource('visitas', VisitsController::class);
    Route::get('ventas/{id}/ticket', [SaleController::class, 'ticket'])->name('ventas.ticket');
    Route::resource('vender', SellController::class);
    Route::resource('usercash', UserCashController::class);
    Route::get('/costos-ver/{id}', [ProductController::class, 'costosver'])->name('costos.ver');
    Route::get('/costos-crear/{id}', [ProductController::class, 'costoscrear'])->name('costos.crear');
    Route::post('/costos', [ProductController::class, 'costospost'])->name('costos.store');
    Route::delete('/costos/{id}', [ProductController::class, 'costosdelete'])->name('costos.destroy');
    Route::get('/costos/{id}/edit', [ProductController::class, 'costosedit'])->name('costos.edit');
    Route::put('/costos/{id}', [ProductController::class, 'costosupdate'])->name('costos.update');
    Route::get('/searchp/{busqueda}', [ProductController::class, 'search']);
    Route::get('/searchs/{busqueda}', [ServiceController::class, 'search']);
    /////////////////////////*****Gastos**///////////////////////////////////////////////////
    Route::get('/gastos', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/gastos/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/gastos', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/gastos/{expense}', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/gastos/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/gastos/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::get('/vaucher_gastos/{expense}', [ExpenseController::class, 'vaucher'])->name('expenses.vaucher');
    ///////////////////////////////////////****Socios*****//////////////////////////////////////////////////////////////
    Route::get('/socios', [PartnersController::class, 'index'])->name('socios.index');
    Route::get('/socios/crear', [PartnersController::class, 'create'])->name('socios.create');
    Route::post('/socios', [PartnersController::class, 'store'])->name('socios.store');
    Route::get('/socios/{id}/edit', [PartnersController::class, 'edit'])->name('socios.edit');
    Route::put('/socios/{id}', [PartnersController::class, 'update'])->name('socios.update');
    Route::post('/socios/{id}', [PartnersController::class, 'destroy'])->name('socios.destroy');
    Route::get('/socios/modal/{data}', [PartnersController::class, 'modals'])->name('socios.modals');
    Route::get('/socios/fichaPago/{data}', [PartnersController::class, 'modalPago'])->name('socios.modals');
    Route::get('/socios/download-terms', [PartnersController::class, 'downloadTerms'])->name('socios.terms');
    ////////////////////////////////////////////////////////////////////////////////////////
    Route::get('/visitas/socios/{data}', [VisitsController::class, 'getSocioInfo'])->name('visits.socios');
    /* Route::get('/visitas/qrsocio', [VisitsController::class, 'qrSocio'])->name('visitas.qrSocio'); */
    Route::get('/visitas/listado', [VisitsController::class, 'show'])->name('visitas.listado');
    Route::post('/visitas/data', [VisitsController::class, 'filter'])->name('visitas.filter');
    Route::get('/socios/imprimir/{data}', [PartnersController::class, 'imprimir'])->name('socios.imprimir');
    ////////////////////////////////////////////////////////////////////////////////////////
    Route::get('owners', [OwnerController::class, 'index'])->name('owner.index');
    ///////////////////////////**Buscador **////////////////////////////////////////////////
    Route::get('/search', [BuscadorController::class, 'search']);
    ////////////////////////////////////////////////////////////////////////////////////////
    Route::post('/mail/{id}', [PartnersController::class, 'senEmail'])->name('senEmail');
});

Route::get('/getCategorias/{id}', [CategoryController::class, 'getCategorias']);
Route::get('/getUser/{id}', [WarehouseController::class, 'getUser']);
