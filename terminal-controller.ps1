# DEZZLY CREATIVE - Interactive Terminal Controller
$ErrorActionPreference = "Continue"
$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $projectRoot

function Show-Header {
    Clear-Host
    Write-Host "=================================================================" -ForegroundColor DarkCyan
    Write-Host "       DEZZLY CREATIVE - TERMINAL STUDIO & DEPLOY CONTROLLER     " -ForegroundColor Cyan
    Write-Host "=================================================================" -ForegroundColor DarkCyan
    Write-Host " Lokasi Proyek: $projectRoot" -ForegroundColor Gray
    
    $portActive = Test-NetConnection -ComputerName 127.0.0.1 -Port 8000 -InformationLevel Quiet -WarningAction SilentlyContinue
    if ($portActive) {
        Write-Host " Server Status: [ ONLINE ] -> http://127.0.0.1:8000" -ForegroundColor Green
    } else {
        Write-Host " Server Status: [ OFFLINE ] (Port 8000)" -ForegroundColor Red
    }
    Write-Host "-----------------------------------------------------------------" -ForegroundColor DarkGray
}

while ($true) {
    Show-Header
    Write-Host " [1] 🚀  Start Local Dev Server (php artisan serve)" -ForegroundColor Yellow
    Write-Host " [2] 🛑  Stop All Running PHP Servers" -ForegroundColor Red
    Write-Host " [3] 🌐  Buka Website di Browser (http://localhost:8000)" -ForegroundColor Green
    Write-Host " [4] 🛡️  Buka Admin Dashboard (http://localhost:8000/admin)" -ForegroundColor Magenta
    Write-Host " [5] 🗄️  Migrate & Seed Database (Katalog Sony Alpha & Paket)" -ForegroundColor Cyan
    Write-Host " [6] 📦  Build Assets untuk Production (Vite compile & optimize)" -ForegroundColor Blue
    Write-Host " [7] 🧹  Clear All Caches (Artisan optimize:clear)" -ForegroundColor Gray
    Write-Host " [8] 🧪  Run PHPUnit Automated Tests" -ForegroundColor Green
    Write-Host " [9] 🖥️   Buka Desktop WPF GUI Controller" -ForegroundColor DarkCyan
    Write-Host " [0] 🚪  Keluar" -ForegroundColor DarkGray
    Write-Host "-----------------------------------------------------------------" -ForegroundColor DarkGray
    
    $choice = Read-Host "Pilih menu [0-9]"

    switch ($choice) {
        "1" {
            Write-Host "`nMemulai server di http://127.0.0.1:8000..." -ForegroundColor Cyan
            Start-Process php -ArgumentList "artisan serve --port=8000" -WorkingDirectory $projectRoot -WindowStyle Minimized
            Start-Sleep -Seconds 1
            Write-Host "Server sedang berjalan di background (port 8000)." -ForegroundColor Green
            Start-Sleep -Seconds 2
        }
        "2" {
            Write-Host "`nMenghentikan proses PHP..." -ForegroundColor Yellow
            Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
            Write-Host "Server PHP dihentikan." -ForegroundColor Red
            Start-Sleep -Seconds 2
        }
        "3" {
            Start-Process "http://localhost:8000"
        }
        "4" {
            Start-Process "http://localhost:8000/admin"
        }
        "5" {
            Write-Host "`nMenjalankan migrasi dan seeder..." -ForegroundColor Cyan
            php artisan migrate:fresh --seed
            Write-Host "`nDatabase selesai diperbarui!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali ke menu..."
        }
        "6" {
            Write-Host "`nBuilding assets..." -ForegroundColor Cyan
            npm run build
            php artisan optimize
            Write-Host "`nBuild produksi selesai!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali ke menu..."
        }
        "7" {
            Write-Host "`nMembersihkan cache..." -ForegroundColor Cyan
            php artisan optimize:clear
            Write-Host "`nCache bersih!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali ke menu..."
        }
        "8" {
            Write-Host "`nMenjalankan automated test..." -ForegroundColor Cyan
            php artisan test --compact
            Read-Host "Tekan Enter untuk kembali ke menu..."
        }
        "9" {
            Write-Host "`nMembuka Desktop GUI Controller..." -ForegroundColor Cyan
            Start-Process powershell -ArgumentList "-ExecutionPolicy Bypass -File `"$projectRoot\DezzlyStudioController.ps1`""
        }
        "0" {
            Write-Host "`nSampai jumpa di Dezzly Creative!" -ForegroundColor Cyan
            exit
        }
    }
}
