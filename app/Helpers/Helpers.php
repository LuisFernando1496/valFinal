<?php


use Illuminate\Support\Facades\DB;

use App\Models\User;

function getDataModels($user, $models)
{
    $acceso = validateUser($user);

    switch ($models) {
        case 'App\Models\Expense':
            if ($acceso == 1) {
                $data = $models::where('status', true)->paginate(10);
            } else {
                $data = $models::where('status', true)->where('office_id', $user->office_id)
                    ->paginate(10);
            }
            return $data;

        case 'App\Models\Client':
            if ($acceso == 1) {
                $data = $models::select(DB::raw("CONCAT(name,' ',last_name,' ',second_last_name)As name"), 'id')->pluck('name', 'id');
            } else {
                $data = $models::where('office_id', $user->office_id)
                    ->select(DB::raw("CONCAT(name,' ',last_name,' ',second_last_name)As name"), 'id')->pluck('name', 'id');
            }
            return $data;

        case 'App\Models\Credit':
            if ($acceso == 1) {
                $data = $models::orderBy('id', 'DESC')->paginate(5);
            } else {
                $data = $models::join('clients', 'clients.id', 'credits.client_id')->where('clients.office_id', $user->office_id)
                    ->orderBy('credits.id', 'DESC')->paginate(5);
            }
            return $data;
        case 'App\Models\Office':
            if ($acceso == 1) {
                $data = $models::join('businesses', 'businesses.id', '=', 'offices.business_id')
                    ->select(DB::raw("CONCAT(offices.name, ' - ',businesses.name) AS name"), 'offices.id')->pluck('name', 'id');
            } else {
                $data = $models::join('businesses', 'businesses.id', '=', 'offices.business_id')
                    ->where('offices.id', $user->office_id)
                    ->select(DB::raw("CONCAT(offices.name, ' - ',businesses.name) AS name"), 'offices.id')->pluck('name', 'id');
            }
            return $data;

        case 'App\Models\User':
            if ($acceso == 1) {
                $data = $models::all();
            } else {
                $data = $models::where('office_id', $user->office_id)->get();
            }
            return $data;

        default:
            return 'No existe el modelo';
    }
}

function getDataModelsSearch($user, $models, $search)
{

    $acceso = validateUser($user);
    switch ($models) {
        case 'App\Models\User':
                                if ($acceso == 1) {
                                    $data = $models::join("offices", "offices.id", "users.office_id")
                                                    ->where("users.id", "!=", $user->id)
                                                    ->where("users.name", "like","%{$search}%")
                                                    ->orWhere("users.last_name", "like","%{$search}%")
                                                    ->orWhere("users.second_last_name", "like","%{$search}%")
                                                    ->orWhere("users.email", "like","%{$search}%")
                                                    ->orWhere("offices.name", "like","%{$search}%")
                                                    ->select('users.id', 
                                                                'users.name', 
                                                                'users.last_name', 
                                                                'users.second_last_name', 
                                                                'users.email', 
                                                                'offices.name as office')
                                                     ->paginate(5);


                                } else {
                                    $data = $models::join("offices", "offices.id", "users.office_id")
                                                    ->where("users.id", "!=", $user->id)
                                                    ->where("users.name", "like","%{$search}%")
                                                    ->orWhere("users.last_name", "like","%{$search}%")
                                                    ->orWhere("users.second_last_name", "like","%{$search}%")
                                                    ->orWhere("users.email", "like","%{$search}%")
                                                    ->orWhere("offices.name", "like","%{$search}%")
                                                    ->select('users.id', 
                                                                'users.name', 
                                                                'users.last_name', 
                                                                'users.second_last_name', 
                                                                'users.email', 
                                                                'offices.name as office')
                                                    ->where('office_id', $user->office_id)
                                                   ->paginate(5);
                                }
                                 return $data;

        case 'App\Models\Warehouse':
                                    if ($acceso == 1) {
                                        $data = $models:: join("businesses","businesses.id","warehouses.business_id")
                                                        ->join("users","users.id","warehouses.user_id")
                                                         ->where("warehouses.title", "like", "%{$search}%")
                                                         ->orWhere("businesses.name", "like","%{$search}%")
                                                         ->orWhere("users.name", "like","%{$search}%")
                                                         ->paginate(5);
                                    } else {
                                        $data = $models::join("businesses","businesses.id","warehouses.business_id")
                                                        ->join("users","users.id","warehouses.user_id")
                                                        ->where("warehouses.title", "like", "%{$search}%")
                                                        ->orWhere("businesses.name", "like","%{$search}%")
                                                        ->orWhere("users.name", "like","%{$search}%")
                                                        ->paginate(5);
                                    }
                                   return $data;

        case 'App\Models\Category':
                                if ($acceso == 1) {
                                    $data = $models::join('offices', 'offices.id', 'categories.office_id')
                                                    ->where('categories.name', 'like',"%{$search}%")
                                                    ->orWhere('categories.description', 'like',"%{$search}%")
                                                    ->orWhere('offices.name', 'like',"%{$search}%")
                                                    ->select(    'categories.id', 
                                                                'categories.name', 
                                                                'categories.description', 
                                                                'offices.name as office')
                                                     
                                                    ->paginate(5);
                                } else {
                                    $data = $models::join('offices', 'offices.id', 'categories.office_id')
                                                    ->where('categories.name', 'like',"%{$search}%")
                                                    ->orWhere('categories.description', 'like',"%{$search}%")
                                                    ->orWhere('offices.name', 'like',"%{$search}%")
                                                    ->where('offices.id', $user->office_id)
                                                    ->select(    'categories.id', 
                                                                'categories.name', 
                                                                'categories.description', 
                                                                'offices.name as office')
                                                    ->paginate(5);
                                }
                                return $data;

        case 'App\Models\Vendor':
                                if ($acceso == 1) {
                                    $data = $models::join('offices','offices.id','vendors.office_id')
                                                    ->join('addresses','addresses.id','vendors.address_id')
                                                    ->where('vendors.name', 'like',"{$search}%")
                                                    ->orWhere('vendors.phone', 'like',"%{$search}%")
                                                    ->orWhere('vendors.email', 'like',"%{$search}%")
                                                    ->orWhere('offices.name','like',"%{$search}%")
                                                    ->select(    'vendors.id', 
                                                    'vendors.name', 
                                                    'vendors.phone', 
                                                    'vendors.email', 
                                                    'offices.name as office',
                                                    DB::raw("CONCAT(addresses.street, '  ',addresses.number, ' ',addresses.suburb,
                                                    ' ', addresses.postal_code, ' ', addresses.city, ', ',addresses.state,', ',addresses.country ) AS address"),
                                                    DB::raw("CONCAT(offices.name) AS offices"),)
                                                    ->paginate(5);
                                } else {
                                    $data = $models::join('offices','offices.id','vendors.office_id')
                                                   ->join('addresses','addresses.id','vendors.address_id')
                                                   ->where('vendors.name', 'like',"%{$search}%")
                                                   ->orWhere('vendors.phone', 'like',"%{$search}%")
                                                   ->orWhere('vendors.email', 'like',"%{$search}%")
                                                   ->where('office_id', $user->office_id)
                                                   ->select(    'vendors.id', 
                                                                'vendors.name', 
                                                                'vendors.phone', 
                                                                'vendors.email', 
                                                                'offices.name as office',
                                                                DB::raw("CONCAT(addresses.street, '  ',addresses.number, ' ',addresses.suburb,
                                                                ' ', addresses.postal_code, ' ', addresses.city, ', ',addresses.state,', ',addresses.country ) AS address"),
                                                                DB::raw("CONCAT(offices.name) AS offices"),)
                                                   ->paginate(5);
                                }
                                return $data;

        case 'App\Models\Product':
                                if ($acceso == 1) {
                                    $data = $models::join('categories','categories.id','products.category_id')
                                                    ->join('vendor_has_products','vendor_has_products.product_id','products.id')
                                                    ->join('vendors','vendors.id','vendor_has_products.vendor_id')
                                                    ->join('offices','offices.id','vendors.office_id')
                                                    ->join('cost_prices','cost_prices.vendor_product_id','vendor_has_products.id')
                                                    ->where('products.bar_code', 'like',"%{$search}%")
                                                    ->orWhere('products.name', 'like',"%{$search}%")
                                                    ->orWhere('products.mark','like',"%{$search}%")
                                                    ->orWhere('categories.name','like',"%{$search}%")
                                                    ->orWhere('products.description','like',"%{$search}%")
                                                    ->orWhere('vendor_has_products.stock','like',"%{$search}%")
                                                    ->orWhere('vendors.name','like',"%{$search}%")
                                                    ->orWhere('offices.name','like',"%{$search}%")
                                                    ->select(    'products.id', 
                                                                'products.bar_code', 
                                                                'products.name', 
                                                                'products.mark', 
                                                                'products.description', 
                                                                'vendor_has_products.stock', 
                                                                'categories.name as category',
                                                                DB::raw("CONCAT(cost_prices.cost) AS costos"),
                                                                DB::raw("CONCAT(vendors.name) AS vendor"),
                                                                DB::raw("CONCAT(vendor_has_products.id) AS vendor_id"),
                                                                DB::raw("CONCAT(offices.name) AS office"),)
                                                    ->paginate(10);
                                } else {
                                   $data = $models::join('categories','categories.id','products.category_id')
                                                    ->join('vendor_has_products','vendor_has_products.product_id','products.id')
                                                    ->join('vendors','vendors.id','vendor_has_products.vendor_id')
                                                    ->join('offices','offices.id','vendors.office_id')
                                                    ->join('cost_prices','cost_prices.vendor_product_id','vendor_has_products.id')
                                                    ->where('products.bar_code', 'like',"%{$search}%")
                                                    ->orWhere('products.name', 'like',"%{$search}%")
                                                    ->orWhere('products.mark','like',"%{$search}%")
                                                    ->orWhere('categories.name','like',"%{$search}%")
                                                    ->orWhere('products.description','like',"%{$search}%")
                                                    ->orWhere('vendor_has_products.stock','like',"%{$search}%")
                                                    ->orWhere('vendors.name','like',"%{$search}%")
                                                    ->where('offices.id', $user->office_id)
                                                    ->select(    'products.id', 
                                                                'products.bar_code', 
                                                                'products.name', 
                                                                'products.mark', 
                                                                'products.description', 
                                                                'vendor_has_products.stock', 
                                                                'categories.name as category',
                                                                DB::raw("CONCAT(cost_prices.cost) AS costos"),
                                                                DB::raw("CONCAT(vendors.name) AS vendor"),
                                                                DB::raw("CONCAT(vendor_has_products.id) AS vendor_id"),
                                                                DB::raw("CONCAT(offices.name) AS office"),)
                                                    ->paginate(10);
                                }
                                    return $data;

        case 'App\Models\Service':
                                if ($acceso == 1) {
                                    $data = $models::join('offices','offices.id','services.office_id')
                                                    ->where('services.bar_code', 'like',"%{$search}%")
                                                    ->orWhere('services.name', 'like', "%{$search}%")
                                                    ->orWhere('services.cost', 'like', "%{$search}%")
                                                    ->orWhere('services.price', 'like', "%{$search}%")
                                                    ->orWhere('services.description', 'like', "%{$search}%")
                                                    ->orWhere('offices.name', 'like', "%{$search}%")
                                                    ->select(    'services.id', 
                                                                'services.bar_code', 
                                                                'services.name', 
                                                                'services.cost', 
                                                                'services.price', 
                                                                'services.description', 
                                                                DB::raw("CONCAT(offices.name) AS office"),)
                                                    ->paginate(10);
                                } else {
                                    $data = $models::join('offices','offices.id','services.office_id')
                                                    ->where('services.bar_code', 'like',"%{$search}%")
                                                    ->orWhere('services.name', 'like', "%{$search}%")
                                                    ->orWhere('services.cost', 'like', "%{$search}%")
                                                    ->orWhere('services.price', 'like', "%{$search}%")
                                                    ->orWhere('services.description', 'like', "%{$search}%")
                                                    ->orWhere('offices.id', $user->office_id)
                                                    ->select(    'services.id', 
                                                                'services.bar_code', 
                                                                'services.name', 
                                                                'services.cost', 
                                                                'services.price', 
                                                                'services.description', 
                                                                DB::raw("CONCAT(offices.name) AS office"),)
                                                    ->paginate(10);
                                }
                                  return $data;

        case 'App\Models\Client':
                                if ($acceso == 1) {
                                    $data = $models::join('offices','offices.id','clients.office_id')
                                                    ->where('clients.name', 'like',"%{$search}%")
                                                    ->orWhere('clients.last_name', 'like',"%{$search}%")
                                                    ->orWhere('clients.second_last_name', 'like',"%{$search}%")
                                                    ->orWhere('clients.phone', 'like',"%{$search}%")
                                                    ->orWhere('clients.email', 'like',"%{$search}%")
                                                    ->orWhere('offices.name', 'like',"%{$search}%")
                                                    ->select(    'clients.id', 
                                                                'clients.name', 
                                                                'clients.last_name', 
                                                                'clients.second_last_name',
                                                                'clients.phone', 
                                                                'clients.email', 
                                                                DB::raw("CONCAT(offices.name) AS office"),)
                                                    ->paginate(10);
                                } else {
                                    $data = $models::join('offices','offices.id','clients.office_id')
                                                    ->where('clients.name', 'like',"%{$search}%")
                                                    ->orWhere('clients.last_name', 'like',"%{$search}%")
                                                    ->orWhere('clients.second_last_name', 'like',"%{$search}%")
                                                    ->orWhere('clients.phone', 'like',"%{$search}%")
                                                    ->orWhere('clients.email', 'like',"%{$search}%")
                                                    ->orWhere('offices.id', $user->office_id)
                                                    ->select(    'clients.id', 
                                                                'clients.name', 
                                                                'clients.last_name', 
                                                                'clients.second_last_name',
                                                                'clients.phone', 
                                                                'clients.email', 
                                                                DB::raw("CONCAT(offices.name) AS office"),)
                                                    ->paginate(10);
                                                }
                               return $data;

        case 'App\Models\Credit':
                                if ($acceso == 1) {
                                    $data = $models::join('clients', 'clients.id', 'credits.client_id')
                                                    ->where('clients.name', 'like', "%{$search}%")
                                                    ->orWhere('clients.last_name', 'like', "%{$search}%")
                                                    ->orWhere('clients.second_last_name', 'like', "%{$search}%")
                                                    ->orWhere('clients.phone', 'like', "%{$search}%")
                                                    ->orWhere('clients.email', 'like', "%{$search}%")
                                                    ->orWhere('credits.created_at', 'like', "%{$search}%")
                                                    ->select(
                                                        DB::raw("CONCAT(clients.name, '  ',clients.last_name, ' ',clients.second_last_name) AS client"),
                                                        'credits.id',
                                                        'credits.amount',
                                                        'credits.created_at',
                                                        'credits.available'
                                                    )
                                                    ->paginate(5);
                                } else {
                                    $data = $models::join('clients', 'clients.id', 'credits.client_id')
                                                    ->where('clients.name', 'like', "%{$search}%")
                                                    ->orWhere('clients.last_name', 'like', "%{$search}%")
                                                    ->orWhere('clients.second_last_name', 'like', "%{$search}%")
                                                    ->orWhere('clients.phone', 'like', "%{$search}%")
                                                    ->orWhere('clients.email', 'like', "%{$search}%")
                                                    ->orWhere('credits.created_at', 'like', "%{$search}%")
                                                    ->where('office_id', $user->office_id)
                                                        ->select(
                                                            DB::raw("CONCAT(clients.name, '  ',clients.last_name, ' ',clients.second_last_name) AS client"),
                                                            'credits.id',
                                                            'credits.amount',
                                                            'credits.created_at',
                                                            'credits.available'
                                                        )
                                                        ->paginate(5);
                                }
                                return $data;

        case 'App\Models\Sale':
                                    if($acceso == 1){
                                        $data = $models::join('user_has_cash_registers','user_has_cash_registers.id','sales.user_cash_id')
                                        ->join('users','users.id','user_has_cash_registers.user_id')
                                        ->where('sales.folio','like',"%{$search}%")
                                        ->orWhere('users.name','like',"%{$search}%")
                                        ->orWhere('users.last_name','like',"%{$search}%")
                                        ->orWhere('users.second_last_name','like',"%{$search}%")
                                        ->orWhere('users.email','like',"%{$search}%")
                                        ->orWhere('sales.method','like',"%{$search}%")
                                        ->orWhere('sales.created_at','like',"%{$search}%")
                                        ->paginate(5);
                                    }
                                    else{
                                        $data = $models::join('user_has_cash_registers','user_has_cash_registers.id','sales.user_cash_id')
                                        ->join('users','users.id','user_has_cash_registers.user_id')
                                        ->where('sales.folio','like',"%{$search}%")
                                        ->orWhere('users.name','like',"%{$search}%")
                                        ->orWhere('users.last_name','like',"%{$search}%")
                                        ->orWhere('users.second_last_name','like',"%{$search}%")
                                        ->orWhere('users.email','like',"%{$search}%")
                                        ->orWhere('sales.method','like',"%{$search}%")
                                        ->orWhere('sales.created_at','like',"%{$search}%")
                                        ->where('users.office_id', $user->office_id)
                                        ->paginate(5);
                                    }
                                    return $data;
        case 'App\Models\Quote':
                            if($acceso == 1){
                                $data = $models::join('clients','clients.id','quotes.client_id')
                                               ->join('user_has_cash_registers','user_has_cash_registers.id','quotes.user_cash_id')
                                               ->join('users','users.id','user_has_cash_registers.user_id')
                                               ->where('folio','like',"%{$search}%")
                                               ->orWhere('clients.name','like',"%{$search}%")
                                               ->orWhere('clients.last_name','like',"%{$search}%")
                                               ->orWhere('clients.second_last_name','like',"%{$search}%")
                                               ->orWhere('clients.phone','like',"%{$search}%")
                                               ->orWhere('users.name','like',"%{$search}%")
                                               ->orWhere('users.last_name','like',"%{$search}%")
                                               ->orWhere('users.second_last_name','like',"%{$search}%")
                                               ->orWhere('users.email','like',"%{$search}%")
                                               ->paginate(10);
                            }   
                            else{
                                $data = $models::join('clients','clients.id','quotes.client_id')
                                                ->join('user_has_cash_registers','user_has_cash_registers.id','quotes.user_cash_id')
                                                ->join('users','users.id','user_has_cash_registers.user_id')
                                                ->where('folio','like',"%{$search}%")
                                                ->orWhere('clients.name','like',"%{$search}%")
                                                ->orWhere('clients.last_name','like',"%{$search}%")
                                                ->orWhere('clients.second_last_name','like',"%{$search}%")
                                                ->orWhere('clients.phone','like',"%{$search}%")
                                                ->orWhere('users.name','like',"%{$search}%")
                                                ->orWhere('users.last_name','like',"%{$search}%")
                                                ->orWhere('users.second_last_name','like',"%{$search}%")
                                                ->orWhere('users.email','like',"%{$search}%")
                                                ->where('clients.office_id', $user->office_id)
                                                ->paginate(10);
                            }
                            return $data;
        case 'App\Models\Expense':
                            if($acceso == 1)
                            {
                                $data = $models::join('users','users.id','expenses.user_id')
                                               ->join('offices','offices.id','expenses.office_id')
                                               ->join('category_of_expenses','category_of_expenses.id','expenses.category_of_expense_id')
                                               ->orWhere('expenses.title','like',"%{$search}%")
                                               ->orWhere('expenses.created_at','like',"%{$search}%")
                                               ->orWhere('expenses.description','like',"%{$search}%")
                                               ->orWhere('category_of_expenses.name','like',"%{$search}%")
                                               ->orWhere('users.name','like',"%{$search}%")
                                               ->orWhere('users.last_name','like',"%{$search}%")
                                               ->orWhere('users.second_last_name','like',"%{$search}%")
                                               ->orWhere('users.email','like',"%{$search}%")
                                               ->orWhere('offices.name','like',"%{$search}%")
                                               ->select(
                                                     'expenses.id',
                                                     'expenses.title',
                                                     'expenses.date',
                                                     'expenses.description',
                                                     'expenses.total',
                                                     'expenses.created_at',
                                                     DB::raw("CONCAT(category_of_expenses.id) AS tipo_id"),
                                                     DB::raw("CONCAT(category_of_expenses.name) AS tipo"),
                                                     DB::raw("CONCAT(offices.name) AS office"),
                                                     DB::raw("CONCAT(users.name,' ',users.last_name,' ',users.second_last_name) AS user")
                                                     )
                                               ->paginate(10);

                            }
                            else{
                                $data = $models::join('users','users.id','expenses.user_id')
                                               ->join('offices','offices.id','expenses.office_id')
                                               ->join('category_of_expenses','category_of_expenses.id','expenses.category_of_expense_id')
                                               ->orWhere('expenses.title','like',"%{$search}%")
                                               ->orWhere('expenses.created_at','like',"%{$search}%")
                                               ->orWhere('expenses.description','like',"%{$search}%")
                                               ->orWhere('category_of_expenses.name','like',"%{$search}%")
                                               ->orWhere('users.name','like',"%{$search}%")
                                               ->orWhere('users.last_name','like',"%{$search}%")
                                               ->orWhere('users.second_last_name','like',"%{$search}%")
                                               ->orWhere('users.email','like',"%{$search}%")
                                               ->orWhere('offices.id',$user->office_id)
                                               ->select(
                                                     'expenses.id',
                                                     'expenses.title',
                                                     'expenses.date',
                                                     'expenses.description',
                                                     'expenses.total',
                                                     'expenses.created_at',
                                                     DB::raw("CONCAT(category_of_expenses.id) AS tipo_id"),
                                                     DB::raw("CONCAT(category_of_expenses.name) AS tipo"),
                                                     DB::raw("CONCAT(offices.name) AS office"),
                                                     DB::raw("CONCAT(users.name,' ',users.last_name,' ',users.second_last_name) AS user")
                                                     )
                                               ->paginate(10);
                            }
                            return $data;
        default:
            return 'No existe el modelo';
            break;
    }
}
function validateUser($user)
{
    if ($user->id == 1) {
        return true;
    } else {
        return false;
    }
}



// Address
// Business
// Buy
// BuyInventory
// CashRegister
// Category
// Client
// ClientHasFile
// CostPrice
// Credit
// Expense
// ExpenseHasSale
// ExpenseHasSaleHasCostPrice
// File
// Inventory
// Office
// Payment
// Product
// Quote
// QuoteCostService
// Sale
// SaleHasCostPrice
// SaleHasCredit
// SaleHasService
// Service
// Shipment
// ShipmentHasInventory
// Transfer
// TransferInventory
// Trolley
// User
// UserHasCashRegister
// UserHasCashRegisterHasCostPrice
// Vendor
// VendorHasProduct
// VendorHasProductHasFile
// Warehouse