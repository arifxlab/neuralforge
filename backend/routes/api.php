<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;

Route::post('/projects', [ProjectController::class, 'store']);
