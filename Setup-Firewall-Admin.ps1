# ==============================================================================
# DEZZLY CREATIVE - Setup Firewall (Jalankan SEKALI sebagai Administrator)
# Klik kanan file ini > "Run with PowerShell" atau "Run as Administrator"
# ==============================================================================
$ruleName = "Dezzly Creative - Port 8000 (Website LAN)"

$existing = Get-NetFirewallRule -DisplayName $ruleName -ErrorAction SilentlyContinue
if ($existing) {
    Write-Host "[OK] Aturan firewall sudah ada dan aktif." -ForegroundColor Green
} else {
    New-NetFirewallRule `
        -DisplayName $ruleName `
        -Direction Inbound `
        -Protocol TCP `
        -LocalPort 8000 `
        -Action Allow `
        -Profile Any | Out-Null
    Write-Host "[SELESAI] Firewall berhasil dibuka untuk port 8000." -ForegroundColor Green
    Write-Host "Perangkat lain di jaringan Wi-Fi sekarang bisa mengakses: http://192.168.18.15:8000" -ForegroundColor Cyan
}

Write-Host ""
Write-Host "Tekan Enter untuk menutup..." -ForegroundColor Gray
Read-Host
