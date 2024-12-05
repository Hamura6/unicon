<?php

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Livewire\CustomerComponent;
use App\Livewire\MaterialComponent;
use App\Livewire\PermissionComponent;
use App\Livewire\ProductComponent;
use App\Livewire\ProductionComponent;
use App\Livewire\ReportMaterialComponent;
use App\Livewire\ReportProductionComponent;
use App\Livewire\ReportSaleComponent;
use App\Livewire\RolComponent;
use App\Livewire\SaleComponent;
use App\Livewire\SupplierComponent;
use App\Livewire\UserComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('web.home');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('usuarios',UserComponent::class)->name('users');
    Route::get('roles',RolComponent::class)->name('roles');
    Route::get('permisos',PermissionComponent::class)->name('permissions');
    Route::get('ventas',SaleComponent::class)->name('sales');
    Route::get('produccion',ProductionComponent::class)->name('productions');
    Route::get('materiales',MaterialComponent::class)->name('materials');
    Route::get('productos',ProductComponent::class)->name('products');
    Route::get('reporte-ventas',ReportSaleComponent::class)->name('report-sales');
    Route::get('reporte-produccion',ReportProductionComponent::class)->name('report-productions');
    Route::get('reporte-compras',ReportMaterialComponent::class)->name('report-buys');
    Route::get('proveedores',SupplierComponent::class)->name('suppliers');
    Route::get('clientes',CustomerComponent::class)->name('customers');
    route::get('perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    route::put('perfil/person', [ProfileController::class, 'storePerson'])->name('profile.update.person');
    route::put('perfil/user', [ProfileController::class, 'storeUser'])->name('profile.update.user');
    route::put('perfil/key', [ProfileController::class, 'storeKey'])->name('profile.update.key');
    route::get('panel', [ProfileController::class, 'controlPanel'])->name('panel.control');
    route::get('venta/show/{id}', [SaleController::class, 'show'])->name('sale.show');
    route::get('venta/show/{id}/{from?}/{to?}', [SaleController::class, 'reportUser'])->name('sale.report.user');


    route::get('salesBudget/{id}',[PdfController::class, 'budget'])->name('sale.budget');
    route::get('report/sales/{from?}/{to?}',[PdfController::class, 'reportSales'])->name('report.sales');
    route::get('report/productions/{from?}/{to?}',[PdfController::class, 'reportProduction'])->name('report.productions');
    route::get('report/productions/user/{from?}/{to?}',[PdfController::class, 'reportProductionUser'])->name('report.productions.user');
    route::get('report/buys/{from?}/{to?}',[PdfController::class, 'reportBuys'])->name('report.buys');



    route::get('report/Sale/Excel/{from?}/{to?}',[ExcelController::class,'saleExcel'])->name('report.excel.sale');
    route::get('report/productions/Excel/{from?}/{to?}',[ExcelController::class,'productionExcel'])->name('report.excel.productions');

});

