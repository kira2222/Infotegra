<?php

use App\Livewire\ApiComponent;
use App\Livewire\CharacterTable;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('api', ApiComponent::class)->name('api');

Route::get('/characters', CharacterTable::class)->name('characters');