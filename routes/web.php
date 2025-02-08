<?php

use App\Http\Controllers\ManageAccountController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\WarungController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;



Route::get('/foodexplore', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Route warung
    Route::get('/warung', [WarungController::class, 'index'])->name('warung.index');
    Route::get('/warung/search', [WarungController::class, 'search'])->name('warung.search');
    Route::get('/warung/add', function () {
        return view('warung.addwarung');
    })->name('warung.add');
    Route::post('/warung', [WarungController::class, 'store'])->name('warung.store');
    Route::delete('/warung/{warung}', [WarungController::class, 'destroy'])->name('warung.destroy');
    Route::put('warung/{id}', [WarungController::class, 'update'])->name('warung.update');
    Route::get('warung/{id}/edit', [WarungController::class, 'edit'])->name('warung.edit');
    
    // Route menu warung
    Route::get('/warung/{id}/menu', [WarungController::class, 'showMenu'])->name('warung.menu');
    Route::get('/warung/{id}/menu/add', [WarungController::class, 'addMenu'])->name('warung.menu.add');
    Route::post('/warung/{id}/menu', [WarungController::class, 'storeMenu'])->name('warung.menu.store');
    Route::get('warung/{warung_id}/menu', [MenuController::class, 'index'])->name('warung.menu.index');
    Route::get('/warung/{warung}/menu/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/warung/{warung}/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/warung/{warung}/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
});

require __DIR__ . '/auth.php';


// routes/web.php
Route::get('/warung/{id}/menu', [WarungController::class, 'showMenu'])->name('warung.menu');
Route::get('/warung/{id}/menu/add', [WarungController::class, 'addMenu'])->name('warung.menu.add');
Route::post('/warung/{id}/menu', [WarungController::class, 'storeMenu'])->name('warung.menu.store');
Route::get('warung/{warung_id}/menu', [MenuController::class, 'index'])->name('warung.menu.index');

Route::get('/warung/{warung}/menu/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/warung/{warung}/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
Route::delete('/warung/{warung}/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');





Route::get('/menu/create/{warung_id}', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');

Route::get('/warung/{warung_id}/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');

Route::post('/whatsapp/send', [WhatsAppController::class, 'send'])->name('whatsapp.send');

Route::get('/warung/{warung_id}/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');


Route::post('/warung/{warung_id}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

Route::post('/warung/{warung_id}/ulasan', [UlasanController::class, 'store'])
    ->middleware('auth')
    ->name('ulasan.store');

Route::get('/ulasan/{warung_id}', [UlasanController::class, 'lihatUlasan'])->name('ulasan.lihatUlasan');
Route::middleware(['auth', 'role:Admin|User|Warung'])->group(function () {
    Route::delete('/warung/{warung}/ulasan/{ulasan}', [UlasanController::class, 'hapus'])->name('warung.ulasan.hapus');
});


Route::put('/profile/photo', [ProfileController::class, 'updateFoto'])->name('profile.photo');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/manage-role', [RoleController::class, 'index'])->name('manageRole.list');
});


Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Menampilkan daftar akun
    Route::get('/manage-account', [ManageAccountController::class, 'index'])->name('manageAccount.index');

    // Mengedit akun (optional)
    Route::get('/manage-account/edit/{id}', [ManageAccountController::class, 'edit'])->name('manageAccount.edit');

    // Menghapus akun
    Route::delete('/manage-account/delete/{id}', [ManageAccountController::class, 'destroy'])->name('manageAccount.delete');
    Route::get('/manageAccount/createAccount', [App\Http\Controllers\ManageAccountController::class, 'create'])->name('manageAccount.createAccount');
    Route::post('/manageAccount/store', [App\Http\Controllers\ManageAccountController::class, 'store'])->name('manageAccount.store');
    Route::get('/manageAccount', [App\Http\Controllers\ManageAccountController::class, 'index'])->name('manageAccount.index');
    Route::delete('/manageAccount/{id}', [App\Http\Controllers\ManageAccountController::class, 'delete'])->name('manageAccount.delete');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
});
