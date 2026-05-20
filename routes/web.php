<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ScanRFID;
use App\Livewire\CreatePost;

Route::get('/', function () {
    return view('welcome');
});
