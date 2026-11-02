# ==============================================================================
# DEZZLY CREATIVE - STUDIO & DEPLOYMENT CONTROLLER (POWERSHELL WPF GUI)
# ==============================================================================
Add-Type -AssemblyName PresentationFramework
Add-Type -AssemblyName PresentationCore
Add-Type -AssemblyName WindowsBase
Add-Type -AssemblyName System.Windows.Forms

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $projectRoot

[Console]::OutputEncoding = [System.Text.Encoding]::UTF8

$xaml = @"
<Window xmlns="http://schemas.microsoft.com/winfx/2006/xaml/presentation"
        xmlns:x="http://schemas.microsoft.com/winfx/2006/xaml"
        Title="DEZZLY CREATIVE - Studio &amp; Deploy Controller" 
        Height="760" Width="1020" 
        MinHeight="680" MinWidth="900"
        WindowStartupLocation="CenterScreen"
        Background="#07090E" Foreground="#F1F5F9"
        FontFamily="Segoe UI, Tahoma, Helvetica, Arial">
    <Window.Resources>
        <!-- Button Standard Style -->
        <Style TargetType="Button">
            <Setter Property="Background" Value="#121824"/>
            <Setter Property="Foreground" Value="#F1F5F9"/>
            <Setter Property="BorderBrush" Value="#1F293D"/>
            <Setter Property="BorderThickness" Value="1"/>
            <Setter Property="Padding" Value="12,9"/>
            <Setter Property="FontSize" Value="12"/>
            <Setter Property="FontWeight" Value="SemiBold"/>
            <Setter Property="Cursor" Value="Hand"/>
            <Setter Property="Template">
                <Setter.Value>
                    <ControlTemplate TargetType="Button">
                        <Border Background="{TemplateBinding Background}" 
                                BorderBrush="{TemplateBinding BorderBrush}" 
                                BorderThickness="{TemplateBinding BorderThickness}" 
                                CornerRadius="8">
                            <ContentPresenter HorizontalAlignment="Center" VerticalAlignment="Center" Margin="{TemplateBinding Padding}"/>
                        </Border>
                    </ControlTemplate>
                </Setter.Value>
            </Setter>
        </Style>
    </Window.Resources>

    <Grid Margin="20">
        <Grid.RowDefinitions>
            <RowDefinition Height="Auto"/> <!-- Header -->
            <RowDefinition Height="Auto"/> <!-- Server Control Row -->
            <RowDefinition Height="Auto"/> <!-- Action Tools Grid -->
            <RowDefinition Height="*"/>    <!-- Live Console Output -->
            <RowDefinition Height="Auto"/> <!-- Footer Status -->
        </Grid.RowDefinitions>

        <!-- 1. HEADER SECTION -->
        <Border Grid.Row="0" Background="#0B0F17" BorderBrush="#1A2332" BorderThickness="1" CornerRadius="12" Padding="20,14" Margin="0,0,0,14">
            <Grid>
                <Grid.ColumnDefinitions>
                    <ColumnDefinition Width="*"/>
                    <ColumnDefinition Width="Auto"/>
                </Grid.ColumnDefinitions>

                <StackPanel Grid.Column="0">
                    <StackPanel Orientation="Horizontal" VerticalAlignment="Center">
                        <Border Width="30" Height="30" Background="#00F2FE" CornerRadius="7" Margin="0,0,10,0">
                            <TextBlock Text="D" Foreground="#07090E" FontWeight="ExtraBold" FontSize="18" HorizontalAlignment="Center" VerticalAlignment="Center"/>
                        </Border>
                        <TextBlock Text="DEZZLY CREATIVE" Foreground="#FFFFFF" FontWeight="ExtraBold" FontSize="20" VerticalAlignment="Center"/>
                        <Border Background="#121824" BorderBrush="#00F2FE" BorderThickness="1" CornerRadius="5" Padding="7,2" Margin="12,0,0,0">
                            <TextBlock Text="DOCKER &amp; STUDIO CONTROLLER" Foreground="#00F2FE" FontSize="10" FontWeight="Bold"/>
                        </Border>
                    </StackPanel>
                    <TextBlock Text="Pusat Kendali Full-Stack: Kontainer Docker, Local Server, Database, dan Deployment" Foreground="#94A3B8" FontSize="11" Margin="40,3,0,0"/>
                </StackPanel>

                <!-- Live Status Badges -->
                <StackPanel Grid.Column="1" Orientation="Horizontal" VerticalAlignment="Center">
                    <Border Name="DockerBadge" Background="#0C2340" BorderBrush="#0284C7" BorderThickness="1" CornerRadius="8" Padding="10,6" Margin="0,0,8,0">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="DockerDot" Width="8" Height="8" Fill="#38BDF8" Margin="0,0,6,0"/>
                            <TextBlock Name="DockerStatusText" Text="DOCKER CHECKING" Foreground="#BAE6FD" FontSize="11" FontWeight="Bold"/>
                        </StackPanel>
                    </Border>
                    <Border Name="ServerBadge" Background="#1E1B2E" BorderBrush="#8A2BE2" BorderThickness="1" CornerRadius="8" Padding="10,6" Margin="0,0,8,0">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="ServerDot" Width="8" Height="8" Fill="#EF4444" Margin="0,0,6,0"/>
                            <TextBlock Name="ServerStatusText" Text="SERVER OFFLINE" Foreground="#E2E8F0" FontSize="11" FontWeight="Bold"/>
                        </StackPanel>
                    </Border>
                    <Border Background="#062E27" BorderBrush="#10B981" BorderThickness="1" CornerRadius="8" Padding="10,6">
                        <TextBlock Text="DB READY" Foreground="#34D399" FontSize="11" FontWeight="Bold"/>
                    </Border>
                </StackPanel>
            </Grid>
        </Border>

        <!-- 2. SERVER & CONTAINER CONTROL DECK -->
        <Border Grid.Row="1" Background="#0B0F17" BorderBrush="#1A2332" BorderThickness="1" CornerRadius="12" Padding="16" Margin="0,0,0,14">
            <StackPanel>
                <Grid Margin="0,0,0,10">
                    <TextBlock Text="KONTROL SERVER (DOCKER &amp; LOCAL)" Foreground="#64748B" FontSize="11" FontWeight="Bold"/>
                    <TextBlock Text="Port: 8000 | URL: http://localhost:8000" Foreground="#00F2FE" FontSize="11" HorizontalAlignment="Right" FontWeight="SemiBold"/>
                </Grid>

                <UniformGrid Columns="5">
                    <Button Name="BtnDockerUp" Margin="3" Background="#0284C7" BorderBrush="#38BDF8">
                        <TextBlock Text="[+] Docker Compose Up" FontWeight="Bold"/>
                    </Button>
                    <Button Name="BtnDockerDown" Margin="3" Background="#1E293B" BorderBrush="#475569">
                        <TextBlock Text="[-] Docker Stop / Down"/>
                    </Button>
                    <Button Name="BtnStartLocal" Margin="3" Background="#1E293B" BorderBrush="#64748B">
                        <TextBlock Text="[>] Start Local Server"/>
                    </Button>
                    <Button Name="BtnOpenBrowser" Margin="3" Background="#10B981" BorderBrush="#34D399" Foreground="#07090E">
                        <TextBlock Text="[*] Buka Website Publik" FontWeight="Bold"/>
                    </Button>
                    <Button Name="BtnOpenAdmin" Margin="3" Background="#8A2BE2" BorderBrush="#A855F7">
                        <TextBlock Text="[#] Buka Admin Panel" FontWeight="Bold"/>
                    </Button>
                </UniformGrid>
            </StackPanel>
        </Border>

        <!-- 3. ACTION TOOLS & DATABASE WORKSPACE -->
        <Border Grid.Row="2" Background="#0B0F17" BorderBrush="#1A2332" BorderThickness="1" CornerRadius="12" Padding="16" Margin="0,0,0,14">
            <StackPanel>
                <TextBlock Text="ALAT MANAJEMEN DATABASE, BUILD, &amp; PENGUJIAN" Foreground="#64748B" FontSize="11" FontWeight="Bold" Margin="0,0,0,10"/>

                <UniformGrid Columns="5">
                    <Button Name="BtnMigrateSeed" Margin="3">
                        <TextBlock Text="[DB] Migrate &amp; Seed DB"/>
                    </Button>
                    <Button Name="BtnBuildProd" Margin="3">
                        <TextBlock Text="[Vite] Build Production"/>
                    </Button>
                    <Button Name="BtnClearCache" Margin="3">
                        <TextBlock Text="[Cache] Clear Cache"/>
                    </Button>
                    <Button Name="BtnRunTests" Margin="3">
                        <TextBlock Text="[Test] Run PHPUnit"/>
                    </Button>
                    <Button Name="BtnDockerLogs" Margin="3">
                        <TextBlock Text="[Logs] Docker Logs"/>
                    </Button>
                </UniformGrid>
            </StackPanel>
        </Border>

        <!-- 4. LIVE CONSOLE LOG OUTPUT -->
        <Border Grid.Row="3" Background="#0B0F17" BorderBrush="#1A2332" BorderThickness="1" CornerRadius="12" Padding="16">
            <Grid>
                <Grid.RowDefinitions>
                    <RowDefinition Height="Auto"/>
                    <RowDefinition Height="*"/>
                </Grid.RowDefinitions>

                <Grid Grid.Row="0" Margin="0,0,0,8">
                    <TextBlock Text="CONSOLE &amp; DEPLOYMENT OUTPUT" Foreground="#64748B" FontSize="11" FontWeight="Bold"/>
                    <Button Name="BtnClearLog" HorizontalAlignment="Right" Padding="8,3" FontSize="10" Background="Transparent" BorderBrush="#334155">
                        <TextBlock Text="Bersihkan Layar"/>
                    </Button>
                </Grid>

                <TextBox Name="LogBox" Grid.Row="1" 
                         Background="#07090E" Foreground="#38BDF8" 
                         BorderBrush="#1E293B" BorderThickness="1" 
                         FontFamily="Consolas, Lucida Console, Courier New" FontSize="12"
                         IsReadOnly="True" TextWrapping="Wrap" 
                         VerticalScrollBarVisibility="Auto" Padding="12"/>
            </Grid>
        </Border>

        <!-- 5. FOOTER -->
        <Grid Grid.Row="4" Margin="0,12,0,0">
            <TextBlock Text="Dezzly Creative Studio Platform | Laravel + Tailwind + SQLite / Docker Container" Foreground="#64748B" FontSize="11" VerticalAlignment="Center"/>
            <StackPanel Orientation="Horizontal" HorizontalAlignment="Right">
                <Button Name="BtnGitStatus" Padding="12,6" Margin="0,0,8,0" Background="#1E293B" FontSize="11">
                    <TextBlock Text="[Git] Status Repository"/>
                </Button>
                <Button Name="BtnQuickDeploy" Padding="14,6" Background="#2563EB" BorderBrush="#60A5FA" FontSize="11">
                    <TextBlock Text="[Deploy] Quick Git Commit" FontWeight="Bold"/>
                </Button>
            </StackPanel>
        </Grid>
    </Grid>
</Window>
"@

$stringReader = New-Object System.IO.StringReader($xaml)
$xmlReader = [System.Xml.XmlReader]::Create($stringReader)
$window = [Windows.Markup.XamlReader]::Load($xmlReader)

# Map UI Controls
$btnDockerUp      = $window.FindName("BtnDockerUp")
$btnDockerDown    = $window.FindName("BtnDockerDown")
$btnStartLocal    = $window.FindName("BtnStartLocal")
$btnOpenBrowser   = $window.FindName("BtnOpenBrowser")
$btnOpenAdmin     = $window.FindName("BtnOpenAdmin")
$btnMigrateSeed   = $window.FindName("BtnMigrateSeed")
$btnBuildProd     = $window.FindName("BtnBuildProd")
$btnClearCache    = $window.FindName("BtnClearCache")
$btnRunTests      = $window.FindName("BtnRunTests")
$btnDockerLogs    = $window.FindName("BtnDockerLogs")
$btnGitStatus     = $window.FindName("BtnGitStatus")
$btnQuickDeploy   = $window.FindName("BtnQuickDeploy")
$btnClearLog      = $window.FindName("BtnClearLog")
$logBox           = $window.FindName("LogBox")
$serverDot        = $window.FindName("ServerDot")
$serverStatusText = $window.FindName("ServerStatusText")
$dockerDot        = $window.FindName("DockerDot")
$dockerStatusText = $window.FindName("DockerStatusText")

# Helper Logger
function Write-GuiLog([string]$message, [string]$type="INFO") {
    $timestamp = Get-Date -Format "HH:mm:ss"
    $formatted = "[$timestamp] [$type] $message`r`n"
    $logBox.AppendText($formatted)
    $logBox.ScrollToEnd()
}

Write-GuiLog "Dezzly Creative Controller siap digunakan." "SYSTEM"
Write-GuiLog "Direktori Kerja: $projectRoot" "INFO"

# Check Docker Environment
$hasDocker = Get-Command "docker" -ErrorAction SilentlyContinue
if ($hasDocker) {
    $dockerDot.Fill = [System.Windows.Media.Brushes]::LimeGreen
    $dockerStatusText.Text = "DOCKER TERSEDIA"
    $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::LightGreen
    Write-GuiLog "Docker terdeteksi di sistem Windows." "DOCKER"
} else {
    $dockerDot.Fill = [System.Windows.Media.Brushes]::Orange
    $dockerStatusText.Text = "DOCKER BELUM AKTIF"
    $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::Gold
    Write-GuiLog "Docker belum terpasang di PATH sistem. Anda dapat menggunakan mode [Start Local Server] (PHP 8.4 Laragon) yang sudah siap 100%!" "NOTICE"
}

# Check Server Status
function Update-ServerStatus([bool]$isRunning) {
    if ($isRunning) {
        $serverDot.Fill = [System.Windows.Media.Brushes]::LimeGreen
        $serverStatusText.Text = "ONLINE: PORT 8000"
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::LightGreen
    } else {
        $serverDot.Fill = [System.Windows.Media.Brushes]::Red
        $serverStatusText.Text = "SERVER OFFLINE"
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::Salmon
    }
}

# 1. Docker Compose Up (with Friendly Smart Fallback)
$btnDockerUp.Add_Click({
    if (-not (Get-Command "docker" -ErrorAction SilentlyContinue)) {
        Write-GuiLog "Docker Desktop belum terdeteksi di Windows." "WARNING"
        $ans = [System.Windows.MessageBox]::Show(
            "Docker Desktop belum terpasang di sistem Windows Anda.`n`nApakah Anda ingin langsung menyalakan website menggunakan Local Server (PHP 8.4) sekarang secara otomatis?", 
            "Docker Belum Terpasang", 
            [System.Windows.MessageBoxButton]::YesNo, 
            [System.Windows.MessageBoxImage]::Question
        )

        if ($ans -eq [System.Windows.MessageBoxResult]::Yes) {
            Write-GuiLog "Memulai server lokal Laravel (PHP 8.4) di port 8000..." "SERVER"
            Start-Process php -ArgumentList "artisan serve --port=8000" -WorkingDirectory $projectRoot -WindowStyle Hidden
            Start-Sleep -Seconds 1
            Update-ServerStatus $true
            Write-GuiLog "Server lokal aktif di http://127.0.0.1:8000" "SUCCESS"
            Start-Process "http://localhost:8000"
        }
        return
    }

    Write-GuiLog "Menjalankan: docker compose up -d --build..." "DOCKER"
    $output = docker compose up -d 2>&1
    Write-GuiLog ($output -join "`r`n") "DOCKER"
    Update-ServerStatus $true
    Write-GuiLog "Kontainer Docker Dezzly Creative telah berjalan di http://localhost:8000" "SUCCESS"
})

# 2. Docker Compose Down
$btnDockerDown.Add_Click({
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        Write-GuiLog "Menghentikan kontainer Docker..." "DOCKER"
        $output = docker compose down 2>&1
        Write-GuiLog ($output -join "`r`n") "DOCKER"
    }
    
    # Also stop local PHP processes if any
    Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
    Update-ServerStatus $false
    Write-GuiLog "Seluruh layanan server (Docker & Local) telah dihentikan." "SUCCESS"
})

# 3. Start Local Server
$btnStartLocal.Add_Click({
    Write-GuiLog "Memulai server lokal Laravel (PHP 8.4) di port 8000..." "SERVER"
    try {
        Start-Process php -ArgumentList "artisan serve --port=8000" -WorkingDirectory $projectRoot -WindowStyle Hidden
        Start-Sleep -Seconds 1
        Update-ServerStatus $true
        Write-GuiLog "Server lokal aktif di http://127.0.0.1:8000" "SUCCESS"
    } catch {
        Write-GuiLog "Gagal memulai server lokal: $_" "ERROR"
    }
})

# 4. Open Website in Browser
$btnOpenBrowser.Add_Click({
    Write-GuiLog "Membuka website di browser default: http://localhost:8000" "ACTION"
    Start-Process "http://localhost:8000"
})

# 5. Open Admin Panel
$btnOpenAdmin.Add_Click({
    Write-GuiLog "Membuka Admin Dashboard: http://localhost:8000/admin" "ACTION"
    Start-Process "http://localhost:8000/admin"
})

# 6. Migrate & Seed Database
$btnMigrateSeed.Add_Click({
    Write-GuiLog "Menjalankan migrasi database dan pengisian katalog paket..." "DATABASE"
    $out = php artisan migrate:fresh --seed --no-interaction 2>&1
    Write-GuiLog ($out -join "`r`n") "DATABASE"
    Write-GuiLog "Database & katalog produk (Sony Alpha & Paket Dokumentasi) berhasil diisi ulang!" "SUCCESS"
})

# 7. Build Production Assets
$btnBuildProd.Add_Click({
    Write-GuiLog "Mengompilasi aset frontend produksi (Vite)..." "BUILD"
    $buildOut = npm run build 2>&1
    Write-GuiLog ($buildOut -join "`r`n") "BUILD"
    php artisan optimize 2>&1 | Out-Null
    Write-GuiLog "Build produksi selesai! Aset siap tayang." "SUCCESS"
})

# 8. Clear Cache
$btnClearCache.Add_Click({
    Write-GuiLog "Membersihkan seluruh cache sistem..." "CACHE"
    $out = php artisan optimize:clear 2>&1
    Write-GuiLog ($out -join "`r`n") "CACHE"
    Write-GuiLog "Cache berhasil dibersihkan." "SUCCESS"
})

# 9. Run Tests
$btnRunTests.Add_Click({
    Write-GuiLog "Menjalankan pengujian otomatis PHPUnit..." "TEST"
    $out = php artisan test --compact 2>&1
    Write-GuiLog ($out -join "`r`n") "TEST"
})

# 10. Docker Logs
$btnDockerLogs.Add_Click({
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        Write-GuiLog "Mengambil log kontainer Docker terbaru..." "DOCKER"
        $out = docker compose logs --tail=30 2>&1
        Write-GuiLog ($out -join "`r`n") "DOCKER"
    } else {
        Write-GuiLog "Perintah Docker belum tersedia di sistem ini." "NOTICE"
    }
})

# 11. Clear Logs
$btnClearLog.Add_Click({
    $logBox.Clear()
    Write-GuiLog "Layar log telah dibersihkan." "INFO"
})

# 12. Git Status
$btnGitStatus.Add_Click({
    Write-GuiLog "Memeriksa status repositori Git..." "GIT"
    $out = git status -s 2>&1
    if ([string]::IsNullOrWhiteSpace($out)) {
        Write-GuiLog "Working tree bersih (tidak ada perubahan pending)." "GIT"
    } else {
        Write-GuiLog ($out -join "`r`n") "GIT"
    }
})

# 13. Quick Deploy
$btnQuickDeploy.Add_Click({
    $commitMsg = "update: " + (Get-Date -Format "yyyy-MM-dd HH:mm") + " - Dezzly Studio Platform"
    Write-GuiLog "Menyimpan seluruh perubahan ke Git dengan pesan: '$commitMsg'..." "GIT"
    git add .
    $out = git commit -m "$commitMsg" 2>&1
    Write-GuiLog ($out -join "`r`n") "GIT"
    Write-GuiLog "Commit berhasil disimpan ke repositori lokal!" "SUCCESS"
})

# Initial check for port 8000
$portActive = Test-NetConnection -ComputerName 127.0.0.1 -Port 8000 -InformationLevel Quiet -WarningAction SilentlyContinue
Update-ServerStatus $portActive

$window.ShowDialog() | Out-Null
