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

function Get-CurrentGitBranch {
    $b = git branch --show-current 2>$null
    if ([string]::IsNullOrWhiteSpace($b)) { return "" }
    return $b.Trim()
}

function Test-GitBranchExists([string]$Branch) {
    git rev-parse --verify "refs/heads/$Branch" 2>$null | Out-Null
    return ($LASTEXITCODE -eq 0)
}

function Switch-Branch([string]$Branch) {
    $current = Get-CurrentGitBranch
    if ($current -eq $Branch) {
        Write-Host "Sudah berada di branch '$Branch'." -ForegroundColor Gray
        return $true
    }

    Write-Host "`nBerpindah ke branch '$Branch'..." -ForegroundColor Cyan
    git checkout $Branch
    if ($LASTEXITCODE -ne 0) {
        Write-Host "GAGAL: tidak dapat berpindah ke branch '$Branch'." -ForegroundColor Red
        return $false
    }
    return $true
}

function Invoke-Step([string]$Label, [string]$Command, [string[]]$Arguments) {
    Write-Host "`n$Label" -ForegroundColor Cyan
    & $Command @Arguments
    if ($LASTEXITCODE -ne 0) {
        Write-Host "GAGAL: $Label (exit code $LASTEXITCODE)" -ForegroundColor Red
        return $false
    }
    return $true
}

function Invoke-QualityGate {
    Write-Host "`n=== QUALITY GATE ===" -ForegroundColor Magenta
    $failed = @()

    if (-not (Invoke-Step "Pint style check..." "php" @("vendor/bin/pint", "--test", "--format", "agent"))) { $failed += "Pint" }
    if (-not (Invoke-Step "Larastan static analysis..." "php" @("vendor/bin/phpstan", "analyse", "--no-progress", "--memory-limit=1G"))) { $failed += "Larastan" }
    if (-not (Invoke-Step "PHPUnit test suite..." "php" @("artisan", "test", "--compact"))) { $failed += "PHPUnit" }
    if (-not (Invoke-Step "Composer security audit..." "composer" @("audit", "--no-interaction"))) { $failed += "Composer Audit" }
    if (-not (Invoke-Step "NPM security audit..." "npm" @("audit", "--omit=dev", "--audit-level=high"))) { $failed += "NPM Audit" }

    if ($failed.Count -gt 0) {
        Write-Host "`nQUALITY GATE GAGAL: $($failed -join ', ')" -ForegroundColor Red
        return $false
    }

    Write-Host "`nQUALITY GATE LOLOS." -ForegroundColor Green
    return $true
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
    Write-Host " [T] Run Automated Tests     (Uji seluruh suite testing PHPUnit)" -ForegroundColor Yellow
    Write-Host " [G] Buka Desktop GUI Window (Antarmuka Grafis Modern)" -ForegroundColor DarkCyan
    Write-Host ""
    Write-Host " --- PIPELINE FASE PENGEMBANGAN (DEV -> STAGING -> PROD) ---" -ForegroundColor DarkGray
    Write-Host " [E] Fase Setup Environment  (Install, migrate, build)" -ForegroundColor Blue
    Write-Host " [D] Fase Development        (Commit & push branch development)" -ForegroundColor Green
    Write-Host " [Q] Fase Quality Gate       (Pint, Larastan, test, audit)" -ForegroundColor Magenta
    Write-Host " [S] Fase Staging            (Merge dev -> staging & push)" -ForegroundColor Yellow
    Write-Host " [P] Fase Production         (Quality gate + merge & push production)" -ForegroundColor Red
    Write-Host " [F] Fase Hotfix             (Buat branch hotfix dari production)" -ForegroundColor DarkCyan
    Write-Host " [0] Keluar" -ForegroundColor DarkGray
    Write-Host "-----------------------------------------------------------------" -ForegroundColor DarkGray
    
    $choice = Read-Host "Pilih menu [1-9, T, G, E, D, Q, S, P, F, 0]"

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
            Write-Host "`nPERINGATAN: Refersh database akan MENGHAPUS seluruh data. Tindakan ini tidak dapat dibatalkan." -ForegroundColor Red
            $confirm = Read-Host "Ketik YA untuk melanjutkan"
            if ($confirm -notin @("YA", "ya", "Y", "y")) {
                Write-Host "Refresh database dibatalkan." -ForegroundColor Yellow
                Start-Sleep -Seconds 1
                continue
            }

            if (Get-Command "docker" -ErrorAction SilentlyContinue -and (docker compose ps -q app 2>$null)) {
                Invoke-Step "Menjalankan migrate:fresh --seed di Docker..." "docker" @("compose", "exec", "-T", "app", "php", "artisan", "migrate:fresh", "--seed") | Out-Null
            } else {
                Invoke-Step "Menjalankan migrate:fresh --seed..." "php" @("artisan", "migrate:fresh", "--seed") | Out-Null
            }
            Write-Host "`nDatabase selesai diperbarui!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali..."
        }
        "8" {
            $ok = Invoke-Step "Building assets..." "npm" @("run", "build")
            if ($ok) { $ok = Invoke-Step "Optimizing Laravel..." "php" @("artisan", "optimize") }
            if ($ok) {
                Write-Host "`nBuild produksi selesai!" -ForegroundColor Green
            } else {
                Write-Host "`nBuild produksi gagal." -ForegroundColor Red
            }
            Read-Host "Tekan Enter untuk kembali..."
        }
        "9" {
            Invoke-Step "Membersihkan cache sistem..." "php" @("artisan", "optimize:clear") | Out-Null
            Write-Host "`nCache bersih!" -ForegroundColor Green
            Read-Host "Tekan Enter untuk kembali..."
        }
        "T" {
            Invoke-Step "Menjalankan automated test PHPUnit..." "php" @("artisan", "test", "--compact") | Out-Null
            Read-Host "Tekan Enter untuk kembali..."
        }
        "E" {
            Write-Host "`n=== FASE SETUP ENVIRONMENT ===" -ForegroundColor Magenta
            $ok = Invoke-Step "Composer install..." "composer" @("install", "--no-interaction")
            if ($ok) {
                if (-not (Test-Path ".env")) {
                    if (Test-Path ".env.example") {
                        Copy-Item ".env.example" ".env"
                        Write-Host "File .env dibuat dari .env.example." -ForegroundColor Green
                    } else {
                        Write-Host "GAGAL: .env.example tidak ditemukan." -ForegroundColor Red
                        $ok = $false
                    }
                }
            }
            if ($ok -and -not (Select-String -Path ".env" -Pattern '^APP_KEY=.+$' -ErrorAction SilentlyContinue)) {
                $ok = Invoke-Step "Generate application key..." "php" @("artisan", "key:generate", "--force")
            }
            if ($ok) { $ok = Invoke-Step "Migrasi database..." "php" @("artisan", "migrate", "--force") }
            if ($ok) { $ok = Invoke-Step "NPM install..." "npm" @("install") }
            if ($ok) { $ok = Invoke-Step "Build aset produksi..." "npm" @("run", "build") }

            if ($ok) {
                Write-Host "`nFase Setup selesai. Environment siap." -ForegroundColor Green
            } else {
                Write-Host "`nFase Setup gagal. Periksa pesan di atas." -ForegroundColor Red
            }
            Read-Host "Tekan Enter untuk kembali..."
        }
        "D" {
            Write-Host "`n=== FASE DEVELOPMENT ===" -ForegroundColor Magenta
            if (-not (Switch-Branch "development")) {
                Read-Host "Tekan Enter untuk kembali..."
                continue
            }

            git add -A
            $status = git status --porcelain 2>$null
            if ([string]::IsNullOrWhiteSpace(($status | Out-String))) {
                Write-Host "Tidak ada perubahan file baru untuk di-commit." -ForegroundColor Gray
            } else {
                $msg = "dev update: " + (Get-Date -Format "dd-MM-yyyy HH:mm")
                $ok = Invoke-Step "Commit perubahan development..." "git" @("commit", "-m", $msg)
                if (-not $ok) {
                    Read-Host "Tekan Enter untuk kembali..."
                    continue
                }
            }

            $ok = Invoke-Step "Push ke origin/development..." "git" @("push", "origin", "development")
            if ($ok) {
                Write-Host "`nBERHASIL: branch development sudah di-push." -ForegroundColor Green
            }
            Read-Host "Tekan Enter untuk kembali..."
        }
        "Q" {
            Invoke-QualityGate | Out-Null
            Read-Host "Tekan Enter untuk kembali..."
        }
        "S" {
            Write-Host "`n=== FASE STAGING ===" -ForegroundColor Magenta
            $ok = $true

            if (-not (Test-GitBranchExists "staging")) {
                Write-Host "Branch 'staging' belum ada. Membuat dari development..." -ForegroundColor Yellow
                $ok = Invoke-Step "Membuat branch staging..." "git" @("branch", "staging", "development")
            }

            if ($ok) { $ok = Switch-Branch "staging" }
            if ($ok) { $ok = Invoke-Step "Merge development ke staging..." "git" @("merge", "development") }

            if ($ok) {
                $ok = Invoke-Step "Push ke origin/staging..." "git" @("push", "origin", "staging")
            } else {
                Write-Host "Membatalkan merge karena ada konflik/gagal..." -ForegroundColor Yellow
                git merge --abort 2>$null
            }

            Switch-Branch "development" | Out-Null
            if ($ok) {
                Write-Host "`nFase Staging selesai. Lakukan uji coba sebelum production." -ForegroundColor Green
            }
            Read-Host "Tekan Enter untuk kembali..."
        }
        "P" {
            Write-Host "`n=== FASE PRODUCTION (HOSTING LIVE) ===" -ForegroundColor Red
            $confirm = Read-Host "Rilis ke production? Ketik YA untuk melanjutkan"
            if ($confirm -notin @("YA", "ya", "Y", "y")) {
                Write-Host "Rilis production dibatalkan." -ForegroundColor Yellow
                Start-Sleep -Seconds 1
                continue
            }

            $ok = $true
            if (-not (Test-GitBranchExists "production")) {
                Write-Host "GAGAL: branch 'production' belum ada." -ForegroundColor Red
                $ok = $false
            }

            if ($ok) { $ok = Invoke-QualityGate }
            if ($ok) { $ok = Invoke-Step "Build aset produksi..." "npm" @("run", "build") }
            if ($ok) { $ok = Switch-Branch "production" }
            if ($ok) { $ok = Invoke-Step "Merge development ke production..." "git" @("merge", "development") }

            if ($ok) {
                $ok = Invoke-Step "Push ke origin/production..." "git" @("push", "origin", "production")
            } else {
                git merge --abort 2>$null
            }

            Switch-Branch "development" | Out-Null
            if ($ok) {
                Write-Host "`nSELESAI: production berhasil dirilis." -ForegroundColor Green
            } else {
                Write-Host "`nRilis production dibatalkan/gagal. Periksa pesan di atas." -ForegroundColor Red
            }
            Read-Host "Tekan Enter untuk kembali..."
        }
        "F" {
            Write-Host "`n=== FASE HOTFIX ===" -ForegroundColor Magenta
            $base = if (Test-GitBranchExists "production") { "production" } else { "development" }
            $name = "hotfix/" + (Get-Date -Format "yyyyMMdd-HHmm")

            $ok = Invoke-Step "Membuat branch $name dari $base..." "git" @("checkout", "-b", $name, $base)
            if ($ok) {
                Write-Host "`nBranch hotfix '$name' siap. Lakukan perbaikan, commit, lalu merge ke production." -ForegroundColor Green
            }
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
