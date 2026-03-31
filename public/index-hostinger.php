<?php

/**
 * Hostinger Shared Hosting Configuration
 * 
 * If your Laravel project is located outside public_html,
 * update the paths below accordingly.
 * 
 * Example: If Laravel is at /home/username/laravel-backend/
 * and public_html is at /home/username/public_html/
 * 
 * Then update:
 * require __DIR__.'/../laravel-backend/vendor/autoload.php';
 * $app = require_once __DIR__.'/../laravel-backend/bootstrap/app.php';
 */

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
// If Laravel is in parent directory:
require __DIR__.'/../vendor/autoload.php';

// If Laravel is in a sibling directory (e.g., public_html and laravel-backend are siblings):
// require __DIR__.'/../../laravel-backend/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
// If Laravel is in parent directory:
$app = require_once __DIR__.'/../bootstrap/app.php';

// If Laravel is in a sibling directory:
// $app = require_once __DIR__.'/../../laravel-backend/bootstrap/app.php';

$app->handleRequest(Request::capture());
