# PowerShell Script to Restructure Laravel for Hostinger Shared Hosting
# This script moves Laravel core files into public/laravel/ subdirectory

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Restructuring Laravel for Hostinger" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$projectRoot = $PSScriptRoot
$publicDir = Join-Path $projectRoot "public"
$laravelDir = Join-Path $publicDir "laravel"

# Check if we're in the right directory
if (-not (Test-Path (Join-Path $projectRoot "artisan"))) {
    Write-Host "Error: artisan file not found. Please run this script from laravel-backend directory." -ForegroundColor Red
    exit 1
}

Write-Host "Step 1: Creating laravel subdirectory in public/..." -ForegroundColor Yellow
if (-not (Test-Path $laravelDir)) {
    New-Item -ItemType Directory -Path $laravelDir -Force | Out-Null
    Write-Host "✓ Created public/laravel/ directory" -ForegroundColor Green
} else {
    Write-Host "✓ public/laravel/ directory already exists" -ForegroundColor Green
}

Write-Host ""
Write-Host "Step 2: Moving Laravel core files..." -ForegroundColor Yellow

# Folders to move
$foldersToMove = @("app", "bootstrap", "config", "database", "resources", "routes", "storage", "vendor")

foreach ($folder in $foldersToMove) {
    $source = Join-Path $projectRoot $folder
    $destination = Join-Path $laravelDir $folder
    
    if (Test-Path $source) {
        if (Test-Path $destination) {
            Write-Host "  ⚠ $folder already exists in laravel/, skipping..." -ForegroundColor Yellow
        } else {
            Move-Item -Path $source -Destination $destination -Force
            Write-Host "  ✓ Moved $folder/" -ForegroundColor Green
        }
    } else {
        Write-Host "  ⚠ $folder not found, skipping..." -ForegroundColor Yellow
    }
}

# Files to move
$filesToMove = @("artisan", "composer.json", "composer.lock", ".env.example")

foreach ($file in $filesToMove) {
    $source = Join-Path $projectRoot $file
    $destination = Join-Path $laravelDir $file
    
    if (Test-Path $source) {
        if (Test-Path $destination) {
            Write-Host "  ⚠ $file already exists in laravel/, skipping..." -ForegroundColor Yellow
        } else {
            Copy-Item -Path $source -Destination $destination -Force
            Write-Host "  ✓ Copied $file" -ForegroundColor Green
        }
    } else {
        Write-Host "  ⚠ $file not found, skipping..." -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "Step 3: Creating protection .htaccess file..." -ForegroundColor Yellow
$laravelHtaccess = Join-Path $laravelDir ".htaccess"
$htaccessContent = @"
# Protect Laravel core directory
# Deny all access to Laravel core files
Order deny,allow
Deny from all
"@

Set-Content -Path $laravelHtaccess -Value $htaccessContent -Force
Write-Host "✓ Created laravel/.htaccess protection file" -ForegroundColor Green

Write-Host ""
Write-Host "Step 4: Verifying index.php paths..." -ForegroundColor Yellow
$indexFile = Join-Path $publicDir "index.php"
if (Test-Path $indexFile) {
    $indexContent = Get-Content $indexFile -Raw
    if ($indexContent -match "__DIR__\.'/laravel/") {
        Write-Host "✓ index.php already updated for Hostinger structure" -ForegroundColor Green
    } else {
        Write-Host "⚠ index.php may need manual update - check paths point to laravel/" -ForegroundColor Yellow
    }
} else {
    Write-Host "⚠ index.php not found!" -ForegroundColor Red
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Restructuring Complete!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Yellow
Write-Host "1. Upload entire public folder contents to public_html/" -ForegroundColor White
Write-Host "2. Set permissions: laravel/storage/ and laravel/bootstrap/cache/ to 755" -ForegroundColor White
Write-Host "3. Create .env file in public_html/laravel/" -ForegroundColor White
Write-Host "4. Generate APP_KEY: cd public_html/laravel && php artisan key:generate" -ForegroundColor White
Write-Host "5. Run migrations: php artisan migrate --force" -ForegroundColor White
Write-Host ""
Write-Host "See RESTRUCTURE_FOR_HOSTINGER.md for detailed instructions." -ForegroundColor Cyan
