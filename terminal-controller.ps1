# ==============================================================================
# DEZZLY CREATIVE - INTERACTIVE TERMINAL CONTROLLER (POWERSHELL)
# ==============================================================================
$ErrorActionPreference = "Continue"
$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $projectRoot

[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

function Show-Header {
    Clear-Host
    Write-Host "=================================================================" -ForegroundColor DarkCyan
    Write-Host "       DEZZLY CREATIVE - POWERSHELL DOCKER & STUDIO CONTROLLER   " -ForegroundColor Cyan
    Write-Host "=================================================================" -ForegroundColor DarkCyan
    Write-Host " Direktori: $projectRoot" -ForegroundColor Gray

    # Check Docker
    $hasDocker = Get-Command "docker" -ErrorAction SilentlyContinue
    if ($hasDocker) {
        Write-Host " Docker   : [ TERPASANG & SIAP ]" -ForegroundColor Green
    } else {
        Write-Host " Docker   : [ BELUM TERPASANG DI PATH ] (Mode Local PHP Siap)" -ForegroundColor DarkYellow
    }

    # Check Port 8000
    $portActive = Test-NetConnection -ComputerName 127.0.0.1 -Port 8000 -InformationLevel Quiet -WarningAction SilentlyContinue
    if ($portActive) {
        Write-Host " Server   : [ ONLINE ] -> http://127.0.0.1:8000" -ForegroundColor Green
    } else {
        Write-Host " Server   : [ OFFLINE ] (Port 8000 Kosong)" -ForegroundColor Red
    }
    Write-Host "-----------------------------------------------------------------" -ForegroundColor DarkGray
}

while ($true) {
    Show-Header
    Write-Host " --- MANAJEMEN SERVER & DOCKER ---" -ForegroundColor DarkGray
    Write-Host " [1] Docker Compose Up       (Jalankan kontainer app & server)" -ForegroundColor Cyan
    Write-Host " [2] Docker Compose Down     (Hentikan kontainer Docker)" -ForegroundColor Yellow
    Write-Host " [3] Start Local Server      (Jalankan server lokal PHP 8.4 Port 8000)" -ForegroundColor Green
    Write-Host " [4] Stop All Server         (Hentikan semua proses server)" -ForegroundColor Red
    Write-Host " [5] Buka Website di Browser (http://localhost:8000)" -ForegroundColor Green
    Write-Host " [6] Buka Admin Dashboard    (http://localhost:8000/admin)" -ForegroundColor Magenta
    Write-Host ""
    Write-Host " --- DATABASE & PRODUKSI ---" -ForegroundColor DarkGray
    Write-Host " [7] Migrate & Seed Database (Isi ulang katalog Sony Alpha & Paket)" -ForegroundColor Cyan
    Write-Host " [8] Build Assets Produksi   (Vite compile & artisan optimize)" -ForegroundColor Blue
    Write-Host " [9] Clear Cache & Logs      (Bersihkan semua cache sistem)" -ForegroundColor Gray
    Write-Host " [T] Run Automated Tests     (Uji 6 suite testing PHPUnit)" -ForegroundColor Yellow
    Write-Host " [G] Buka Desktop GUI Window (Antarmuka Grafis Modern)" -ForegroundColor DarkCyan
    Write-Host " [0] Keluar" -ForegroundColor DarkGray
    Write-Host "-----------------------------------------------------------------" -ForegroundColor DarkGray
    
    $choice = Read-Host "Pilih menu [1-9, T, G, 0]"

    switch ($choice.ToUpper()) {
        "1" {
            if (-not (Get-Command "docker" -ErrorAction SilentlyContinue)) {
                Write-Host "`n[PERINGATAN] Perintah docker belum ditemukan di PATH sistem." -ForegroundColor Red
                Write-Host "Silakan gunakan opsi [3] untuk menjalankan server lokal PHP 8.4 yang sudah siap pakai.`n" -ForegroundColor Yellow
                Read-Host "Tekan Enter untuk kembali..."
            } else {
                Write-Host "`nMenjalankan docker compose up -d..." -ForegroundColor Cyan
                docker compose up -d
                Start-Sleep -Seconds 2
            }
        }
        "2" {
            if (Get-Command "docker" -ErrorAction SilentlyContinue) {
                Write-Host "`nMenghentikan kontainer Docker..." -ForegroundColor Yellow
                docker compose down
            }
            Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
            Write-Host "Server dihentikan." -ForegroundColor Red
            Start-Sleep -Seconds 1
        }
        "3" {
            Write-Host "`nMemulai server lokal Laravel di http://127.0.0.1:8000..." -ForegroundColor Cyan
            Start-Process php -ArgumentList "artisan serve --port=8000" -WorkingDirectory $projectRoot -WindowStyle Minimized
            Start-Sleep -Seconds 1
            Write-Host "Server lokal aktif di port 8000." -ForegroundColor Green
            Start-Sleep -Seconds 1
        }
        "4" {
            Write-Host "`nMenghentikan proses server..." -ForegroundColor Yellow
            if (Get-Command "docker" -ErrorAction SilentlyContinue) {
                docker compose down 2>$null
            }
            Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
            Write-Host "Seluruh proses web server dihentikan." -ForegroundColor Red
            Start-Sleep -Seconds 1
        }
        "5" {
            Start-Process "http://localhost:8000"
        }
        "6" {
            Start-Process "http://localhost:8000/admin"
        }
        "7" {
            Write-Host "`nMenjalankan migrasi database..." -ForegroundColor Cyan
            php artisan migrate:fresh --seed
            Write-Host "`nDatabase selesai diperbarui!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali..."
        }
        "8" {
            Write-Host "`nBuilding assets..." -ForegroundColor Cyan
            npm run build
            php artisan optimize
            Write-Host "`nBuild produksi selesai!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali..."
        }
        "9" {
            Write-Host "`nMembersihkan cache sistem..." -ForegroundColor Cyan
            php artisan optimize:clear
            Write-Host "`nCache bersih!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali..."
        }
        "T" {
            Write-Host "`nMenjalankan automated test PHPUnit..." -ForegroundColor Cyan
            php artisan test --compact
            Read-Host "Tekan Enter untuk kembali..."
        }
        "G" {
            Write-Host "`nMembuka Desktop GUI Controller..." -ForegroundColor Cyan
            Start-Process powershell -ArgumentList "-ExecutionPolicy Bypass -File `"$projectRoot\DezzlyStudioController.ps1`""
        }
        "0" {
            Write-Host "`nSampai jumpa di Dezzly Creative!" -ForegroundColor Cyan
            exit
        }
    }
}
