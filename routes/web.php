<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProdController;
use App\Http\Controllers\MainControler;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainControler::class, "home"])->name("home");

Route::get("/esercizio", function () {
    return view("esercizio");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get("/contatti", [MainControler::class, "contacts"])->name("contatti");

Route::get("/chi-siamo", [MainControler::class, "chiSiamo"])->name("chiSiamo");

Route::get("/cerca", [MainControler::class, "cerca"])->name("cerca");


Route::middleware(Admin::class)
    ->name("admin.")
    ->prefix("admin")
    ->group(function () {
        Route::get("/orders", [AdminController::class, "adminOrders"])->name("orders");
        Route::get("/orders/{user}", [AdminController::class, "showOrders"])->name("showOrders");
        Route::put("/orders/update/{order}", [AdminController::class, "changeOrderStatus"])->name("changeOrderStatus");
    });

Route::name("products.")
    ->prefix("products")
    ->group(function () {
        Route::get("/", [ProductController::class, "index"])->name("index");
        Route::get("/filtered/{cat}", [ProductController::class, "filtered"])->name("filtered");
        Route::get("/discounted", [ProductController::class, "discounted"])->name("discounted");
        Route::get("/{prod}", [ProductController::class, "details"])->name("details");
        Route::post("/cerca/results", [ProductController::class, "filterBySearch"])
            ->name("filterBySearch");
        Route::get("/cerca/resetFilters", [ProductController::class, "resetFilters"])
            ->name("resetFilters");
    });

Route::middleware(["auth", "verified"])
    ->name("order.")
    ->prefix("order")
    ->group(function () {
        Route::get("/checkout", [OrderController::class, "checkout"])
            ->name("checkout");
        Route::post("/checkout/invoice", [OrderController::class, "storeInvoice"])
            ->name("storeInvoice");
        Route::post("/checkout/finalize/{invoice}", [OrderController::class, "finalize"])
            ->name("finalize");
        Route::delete("/checkout/cancel/{invoice}", [OrderController::class, "cancel"])->name("cancel");
    });

Route::middleware(["auth", "verified"])
    ->name("user.")
    ->prefix("user")
    ->group(function () {
        Route::get("/details", [UserController::class, "details"])
            ->name("details");
        Route::get("/orders", [UserController::class, "orders"])
            ->name("orders");
        Route::get("/orders/receive/{order}", [UserController::class, "orderReceived"])
            ->name("orderReceived");
        Route::get("/cart", [UserController::class, "cart"])
            ->name("cart");
        Route::post("/cart/add/{prod}", [UserController::class, "addToCart"])
            ->name("addToCart");
        Route::put("/cart/update/{prod}", [UserController::class, "updateCart"])
            ->name("updateCart");
        Route::delete("/cart/remove/{prod}/{taglia}", [UserController::class, "removeFromCart"])
            ->name("removeFromCart");
        Route::get("/review/{prod}", [UserController::class, "writeReview"])
            ->name("writeReview");
        Route::post("/review/{prod}/send", [UserController::class, "storeReview"])
            ->name("storeReview");
        Route::post("/cart/coupon", [UserController::class, "applyCoupon"])
            ->name("applyCoupon");
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource("address", AddressController::class);

Route::resource("prods-admin", AdminProdController::class);

Route::fallback(function () {
    return view('errors.404');
});

require __DIR__ . '/auth.php';
