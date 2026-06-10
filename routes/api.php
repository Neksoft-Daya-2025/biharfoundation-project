<?php

use Illuminate\Support\Facades\Route;

// Public JSON API — stateless proxy to NestJS (no session/CSRF; see NESTJS_API_URL)
Route::any('/v1/{path?}', App\Http\Controllers\Api\V1\NestJsProxyController::class)
    ->where('path', '.*')
    ->name('api.v1.proxy');
