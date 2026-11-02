# ==============================================================================
# DEZZLY CREATIVE - PANEL KENDALI SERVER & DEPLOYMENT
# Versi bersih tanpa emoji - kompatibel dengan semua versi Windows
# ==============================================================================
Add-Type -AssemblyName PresentationFramework
Add-Type -AssemblyName PresentationCore
Add-Type -AssemblyName WindowsBase
Add-Type -AssemblyName System.Windows.Forms

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $projectRoot

# Detect real LAN IP (Wi-Fi or Ethernet, not WSL/loopback)
$lanIp = (Get-NetIPAddress -AddressFamily IPv4 |
    Where-Object { $_.InterfaceAlias -match 'Wi-Fi|Ethernet|wlan' -and
                   $_.IPAddress -notmatch '^169' -and
                   $_.IPAddress -notmatch '^127' } |
    Select-Object -First 1).IPAddress

if (-not $lanIp) { $lanIp = "localhost" }

$baseUrl  = "http://${lanIp}:8000"
$adminUrl = "http://${lanIp}:8000/admin"

$xaml = @"
<Window xmlns="http://schemas.microsoft.com/winfx/2006/xaml/presentation"
        xmlns:x="http://schemas.microsoft.com/winfx/2006/xaml"
        Title="DEZZLY CREATIVE - Panel Kendali Server &amp; Website"
        Height="860" Width="1080"
        MinHeight="740" MinWidth="960"
        WindowStartupLocation="CenterScreen"
        Background="#F1F5F9" Foreground="#0F172A"
        FontFamily="Segoe UI">
    <Window.Resources>

        <!-- Base button style - no emoji, plain bold text -->
        <Style TargetType="Button">
            <Setter Property="Background" Value="#FFFFFF"/>
            <Setter Property="Foreground" Value="#0F172A"/>
            <Setter Property="BorderBrush" Value="#CBD5E1"/>
            <Setter Property="BorderThickness" Value="2"/>
            <Setter Property="Height" Value="50"/>
            <Setter Property="Padding" Value="12,8"/>
            <Setter Property="FontSize" Value="13"/>
            <Setter Property="FontWeight" Value="Bold"/>
            <Setter Property="Cursor" Value="Hand"/>
            <Setter Property="Template">
                <Setter.Value>
                    <ControlTemplate TargetType="Button">
                        <Border Background="{TemplateBinding Background}"
                                BorderBrush="{TemplateBinding BorderBrush}"
                                BorderThickness="{TemplateBinding BorderThickness}"
                                CornerRadius="10">
                            <ContentPresenter HorizontalAlignment="Center"
                                              VerticalAlignment="Center"
                                              Margin="{TemplateBinding Padding}"/>
                        </Border>
                    </ControlTemplate>
                </Setter.Value>
            </Setter>
        </Style>

    </Window.Resources>

    <Grid Margin="20">
        <Grid.RowDefinitions>
            <RowDefinition Height="Auto"/>  <!-- Header -->
            <RowDefinition Height="Auto"/>  <!-- LAN Info Bar -->
            <RowDefinition Height="Auto"/>  <!-- Server Buttons -->
            <RowDefinition Height="Auto"/>  <!-- Tool Buttons -->
            <RowDefinition Height="*"/>     <!-- Log Box -->
            <RowDefinition Height="Auto"/>  <!-- Footer -->
        </Grid.RowDefinitions>

        <!-- =========================================================
             ROW 0 : HEADER
        ========================================================= -->
        <Border Grid.Row="0"
                Background="#FFFFFF"
                BorderBrush="#CBD5E1"
                BorderThickness="2"
                CornerRadius="14"
                Padding="20,16"
                Margin="0,0,0,14">
            <Grid>
                <Grid.ColumnDefinitions>
                    <ColumnDefinition Width="*"/>
                    <ColumnDefinition Width="Auto"/>
                </Grid.ColumnDefinitions>

                <!-- Branding -->
                <StackPanel Grid.Column="0">
                    <StackPanel Orientation="Horizontal" VerticalAlignment="Center">
                        <Border Width="42" Height="42" Background="#0284C7" CornerRadius="10" Margin="0,0,14,0">
                            <TextBlock Text="D" Foreground="#FFFFFF" FontWeight="ExtraBold"
                                       FontSize="24" HorizontalAlignment="Center" VerticalAlignment="Center"/>
                        </Border>
                        <StackPanel>
                            <TextBlock Text="DEZZLY CREATIVE" Foreground="#0F172A"
                                       FontWeight="ExtraBold" FontSize="24"/>
                            <TextBlock Text="Panel Kontrol Server dan Deployment"
                                       Foreground="#0369A1" FontWeight="SemiBold" FontSize="13"/>
                        </StackPanel>
                    </StackPanel>
                    <TextBlock Text="Pusat kendali mudah untuk menyalakan, mengelola database, dan mengunggah file studio."
                               Foreground="#475569" FontSize="12.5" Margin="56,5,0,0"/>
                </StackPanel>

                <!-- Status Badges -->
                <StackPanel Grid.Column="1" Orientation="Horizontal" VerticalAlignment="Center">
                    <Border Name="DockerBadge"
                            Background="#FFF7ED" BorderBrush="#F97316"
                            BorderThickness="2" CornerRadius="10"
                            Padding="14,8" Margin="0,0,10,0">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="DockerDot" Width="12" Height="12" Fill="#F97316" Margin="0,0,8,0" VerticalAlignment="Center"/>
                            <TextBlock Name="DockerStatusText" Text="DOCKER..."
                                       Foreground="#C2410C" FontSize="13" FontWeight="Bold" VerticalAlignment="Center"/>
                        </StackPanel>
                    </Border>
                    <Border Name="ServerBadge"
                            Background="#FEF2F2" BorderBrush="#EF4444"
                            BorderThickness="2" CornerRadius="10" Padding="14,8">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="ServerDot" Width="12" Height="12" Fill="#EF4444" Margin="0,0,8,0" VerticalAlignment="Center"/>
                            <TextBlock Name="ServerStatusText" Text="SERVER OFFLINE"
                                       Foreground="#B91C1C" FontSize="13" FontWeight="Bold" VerticalAlignment="Center"/>
                        </StackPanel>
                    </Border>
                </StackPanel>
            </Grid>
        </Border>

        <!-- =========================================================
             ROW 1 : LAN INFO BAR
        ========================================================= -->
        <Border Grid.Row="1"
                Background="#EFF6FF"
                BorderBrush="#93C5FD"
                BorderThickness="2"
                CornerRadius="12"
                Padding="16,10"
                Margin="0,0,0,14">
            <Grid>
                <Grid.ColumnDefinitions>
                    <ColumnDefinition Width="*"/>
                    <ColumnDefinition Width="*"/>
                    <ColumnDefinition Width="Auto"/>
                </Grid.ColumnDefinitions>

                <StackPanel Grid.Column="0" Orientation="Horizontal">
                    <TextBlock Text="[ IP KOMPUTER INI ]  " Foreground="#1D4ED8" FontWeight="ExtraBold" FontSize="13"/>
                    <TextBlock Name="LanIpText" Text="Mendeteksi..." Foreground="#1E40AF" FontSize="13" FontWeight="Bold"/>
                </StackPanel>

                <StackPanel Grid.Column="1" Orientation="Horizontal">
                    <TextBlock Text="[ AKSES WEBSITE ]  " Foreground="#1D4ED8" FontWeight="ExtraBold" FontSize="13"/>
                    <TextBlock Name="LanUrlText" Text="Mendeteksi..." Foreground="#0369A1" FontSize="13" FontWeight="Bold"/>
                </StackPanel>

                <TextBlock Grid.Column="2"
                           Text="Bagikan alamat ini ke HP atau laptop lain di jaringan Wi-Fi yang sama"
                           Foreground="#3B82F6" FontSize="11.5" FontStyle="Italic" VerticalAlignment="Center"/>
            </Grid>
        </Border>

        <!-- =========================================================
             ROW 2 : KONTROL SERVER (4 tombol besar)
        ========================================================= -->
        <Border Grid.Row="2"
                Background="#FFFFFF"
                BorderBrush="#CBD5E1"
                BorderThickness="2"
                CornerRadius="14"
                Padding="18"
                Margin="0,0,0,14">
            <StackPanel>
                <TextBlock Text="1.  KONTROL SERVER DAN WEBSITE"
                           Foreground="#1E293B" FontSize="13" FontWeight="ExtraBold" Margin="0,0,0,12"/>
                <UniformGrid Columns="4" Rows="1">

                    <!-- NYALAKAN SERVER -->
                    <Button Name="BtnDockerUp" Margin="4"
                            Background="#15803D" BorderBrush="#166534" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ NYALAKAN ]" FontSize="14" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Server Docker" FontSize="12" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <!-- HENTIKAN SERVER -->
                    <Button Name="BtnDockerDown" Margin="4"
                            Background="#FEF2F2" BorderBrush="#DC2626" Foreground="#B91C1C">
                        <StackPanel>
                            <TextBlock Text="[ HENTIKAN ]" FontSize="14" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Server Docker" FontSize="12" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <!-- BUKA WEBSITE -->
                    <Button Name="BtnOpenBrowser" Margin="4"
                            Background="#0284C7" BorderBrush="#0369A1" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ BUKA WEBSITE ]" FontSize="14" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Halaman Publik" FontSize="12" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <!-- BUKA ADMIN -->
                    <Button Name="BtnOpenAdmin" Margin="4"
                            Background="#7C3AED" BorderBrush="#6D28D9" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ ADMIN PANEL ]" FontSize="14" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Dashboard Admin" FontSize="12" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                </UniformGrid>
            </StackPanel>
        </Border>

        <!-- =========================================================
             ROW 3 : ALAT OPERASIONAL (5 tombol utilitas)
        ========================================================= -->
        <Border Grid.Row="3"
                Background="#FFFFFF"
                BorderBrush="#CBD5E1"
                BorderThickness="2"
                CornerRadius="14"
                Padding="18"
                Margin="0,0,0,14">
            <StackPanel>
                <TextBlock Text="2.  ALAT DATABASE, TAMPILAN, DAN PENGUJIAN"
                           Foreground="#1E293B" FontSize="13" FontWeight="ExtraBold" Margin="0,0,0,12"/>
                <UniformGrid Columns="5" Rows="1">

                    <Button Name="BtnMigrateSeed" Margin="3" Height="46"
                            Background="#F0FDF4" BorderBrush="#4ADE80">
                        <StackPanel>
                            <TextBlock Text="[DB] Isi Ulang" FontSize="12.5" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Database" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <Button Name="BtnBuildProd" Margin="3" Height="46"
                            Background="#FFFBEB" BorderBrush="#FCD34D">
                        <StackPanel>
                            <TextBlock Text="[BUILD] Tampilan" FontSize="12.5" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Kompilasi Vite" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <Button Name="BtnClearCache" Margin="3" Height="46"
                            Background="#F8FAFC" BorderBrush="#94A3B8">
                        <StackPanel>
                            <TextBlock Text="[CACHE] Bersih" FontSize="12.5" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Hapus Cache" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <Button Name="BtnRunTests" Margin="3" Height="46"
                            Background="#FAF5FF" BorderBrush="#C084FC">
                        <StackPanel>
                            <TextBlock Text="[TEST] Periksa" FontSize="12.5" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Uji Kelayakan" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <Button Name="BtnDockerLogs" Margin="3" Height="46"
                            Background="#F0F9FF" BorderBrush="#7DD3FC">
                        <StackPanel>
                            <TextBlock Text="[LOG] Docker" FontSize="12.5" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Lihat Log Server" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                </UniformGrid>
            </StackPanel>
        </Border>

        <!-- =========================================================
             ROW 4 : LOG BOX
        ========================================================= -->
        <Border Grid.Row="4"
                Background="#FFFFFF"
                BorderBrush="#CBD5E1"
                BorderThickness="2"
                CornerRadius="14"
                Padding="18"
                Margin="0,0,0,14">
            <Grid>
                <Grid.RowDefinitions>
                    <RowDefinition Height="Auto"/>
                    <RowDefinition Height="*"/>
                </Grid.RowDefinitions>

                <Grid Grid.Row="0" Margin="0,0,0,10">
                    <TextBlock Text="3.  CATATAN AKTIVITAS DAN STATUS PROSES"
                               Foreground="#1E293B" FontSize="13" FontWeight="ExtraBold"
                               VerticalAlignment="Center"/>
                    <Button Name="BtnClearLog" HorizontalAlignment="Right"
                            Height="32" Padding="14,4" FontSize="12"
                            Background="#F1F5F9" BorderBrush="#CBD5E1" Foreground="#475569">
                        <TextBlock Text="Bersihkan Catatan"/>
                    </Button>
                </Grid>

                <TextBox Name="LogBox" Grid.Row="1"
                         Background="#F8FAFC" Foreground="#0F172A"
                         BorderBrush="#E2E8F0" BorderThickness="1.5"
                         FontFamily="Consolas, Lucida Console" FontSize="13"
                         IsReadOnly="True" TextWrapping="Wrap"
                         VerticalScrollBarVisibility="Auto" Padding="14"/>
            </Grid>
        </Border>

        <!-- =========================================================
             ROW 5 : FOOTER
        ========================================================= -->
        <Grid Grid.Row="5">
            <TextBlock Text="Dezzly Creative Studio  |  Laravel 13 + Tailwind v4 + SQLite + Docker"
                       Foreground="#64748B" FontSize="12" VerticalAlignment="Center" FontWeight="SemiBold"/>
            <StackPanel Orientation="Horizontal" HorizontalAlignment="Right">

                <Button Name="BtnGitStatus" Height="40" Padding="16,6" Margin="0,0,10,0"
                        Background="#F1F5F9" BorderBrush="#CBD5E1" FontSize="12">
                    <TextBlock Text="[GIT] Cek Perubahan File"/>
                </Button>

                <Button Name="BtnQuickDeploy" Height="40" Padding="20,6"
                        Background="#0369A1" BorderBrush="#0284C7" Foreground="#FFFFFF" FontSize="12">
                    <TextBlock Text="[UPLOAD] Simpan dan Kirim ke GitHub" FontWeight="Bold"/>
                </Button>

            </StackPanel>
        </Grid>

    </Grid>
</Window>
"@

$stringReader = New-Object System.IO.StringReader($xaml)
$xmlReader    = [System.Xml.XmlReader]::Create($stringReader)
$window       = [Windows.Markup.XamlReader]::Load($xmlReader)

# -----------------------------------------------------------------------
# Map Controls
# -----------------------------------------------------------------------
$btnDockerUp      = $window.FindName("BtnDockerUp")
$btnDockerDown    = $window.FindName("BtnDockerDown")
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
$serverBadge      = $window.FindName("ServerBadge")
$dockerDot        = $window.FindName("DockerDot")
$dockerStatusText = $window.FindName("DockerStatusText")
$dockerBadge      = $window.FindName("DockerBadge")
$lanIpText        = $window.FindName("LanIpText")
$lanUrlText       = $window.FindName("LanUrlText")

# -----------------------------------------------------------------------
# Helper: Log Writer
# -----------------------------------------------------------------------
function Write-GuiLog([string]$message, [string]$type = "INFO") {
    $timestamp = Get-Date -Format "HH:mm:ss"
    $logBox.AppendText("[$timestamp] [$type] $message`r`n")
    $logBox.ScrollToEnd()
}

# -----------------------------------------------------------------------
# Populate LAN info bar
# -----------------------------------------------------------------------
$lanIpText.Text  = $lanIp
$lanUrlText.Text = $baseUrl

# -----------------------------------------------------------------------
# Startup logs
# -----------------------------------------------------------------------
Write-GuiLog "Panel Kendali Dezzly Creative siap digunakan." "SISTEM"
Write-GuiLog "Folder proyek: $projectRoot" "INFO"
Write-GuiLog "IP jaringan terdeteksi: $lanIp" "JARINGAN"
Write-GuiLog "Alamat akses website: $baseUrl" "JARINGAN"
Write-GuiLog "Bagikan alamat di atas ke perangkat lain di jaringan Wi-Fi yang sama." "INFO"

# -----------------------------------------------------------------------
# Docker Detection
# -----------------------------------------------------------------------
$hasDocker = Get-Command "docker" -ErrorAction SilentlyContinue
if ($hasDocker) {
    $dockerDot.Fill            = [System.Windows.Media.Brushes]::ForestGreen
    $dockerStatusText.Text     = "DOCKER AKTIF"
    $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::DarkGreen
    $dockerBadge.Background    = [System.Windows.Media.Brushes]::Honeydew
    $dockerBadge.BorderBrush   = [System.Windows.Media.Brushes]::SeaGreen
    Write-GuiLog "Docker Desktop terdeteksi dan siap." "DOCKER"
} else {
    $dockerDot.Fill            = [System.Windows.Media.Brushes]::OrangeRed
    $dockerStatusText.Text     = "DOCKER BELUM AKTIF"
    $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::OrangeRed
    Write-GuiLog "Docker belum terdeteksi. Buka Docker Desktop terlebih dahulu." "PERHATIAN"
}

# -----------------------------------------------------------------------
# Server Badge Update
# -----------------------------------------------------------------------
function Update-ServerStatus([bool]$isRunning) {
    if ($isRunning) {
        $serverDot.Fill              = [System.Windows.Media.Brushes]::ForestGreen
        $serverStatusText.Text       = "SERVER AKTIF  (Port 8000)"
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::DarkGreen
        $serverBadge.Background      = [System.Windows.Media.Brushes]::Honeydew
        $serverBadge.BorderBrush     = [System.Windows.Media.Brushes]::SeaGreen
    } else {
        $serverDot.Fill              = [System.Windows.Media.Brushes]::Crimson
        $serverStatusText.Text       = "SERVER OFFLINE"
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::DarkRed
        $serverBadge.Background      = [System.Windows.Media.Brushes]::MistyRose
        $serverBadge.BorderBrush     = [System.Windows.Media.Brushes]::LightCoral
    }
}

# -----------------------------------------------------------------------
# Button: Nyalakan Server Docker
# -----------------------------------------------------------------------
$btnDockerUp.Add_Click({
    if (-not (Get-Command "docker" -ErrorAction SilentlyContinue)) {
        Write-GuiLog "Docker Desktop belum berjalan. Buka dulu dari Start Menu." "PERHATIAN"
        [System.Windows.MessageBox]::Show(
            "Docker Desktop belum berjalan.`n`nSilakan buka aplikasi Docker Desktop di Windows, tunggu sampai ikon Docker di Taskbar menjadi hijau, lalu klik tombol ini kembali.",
            "Docker Belum Aktif",
            [System.Windows.MessageBoxButton]::OK,
            [System.Windows.MessageBoxImage]::Information
        ) | Out-Null
        return
    }
    Write-GuiLog "Menyalakan kontainer Docker Dezzly Creative..." "PROSES"
    $output = docker compose up -d 2>&1
    Write-GuiLog ($output -join "`r`n") "DOCKER"
    Update-ServerStatus $true
    Write-GuiLog "Server aktif! Buka browser di alamat: $baseUrl" "SUKSES"
    Write-GuiLog "Perangkat lain di jaringan dapat akses: $baseUrl" "JARINGAN"
})

# -----------------------------------------------------------------------
# Button: Hentikan Server
# -----------------------------------------------------------------------
$btnDockerDown.Add_Click({
    Write-GuiLog "Menghentikan server..." "PROSES"
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        $output = docker compose down 2>&1
        Write-GuiLog ($output -join "`r`n") "DOCKER"
    }
    Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
    Update-ServerStatus $false
    Write-GuiLog "Server telah dimatikan." "SELESAI"
})

# -----------------------------------------------------------------------
# Button: Buka Website Publik
# -----------------------------------------------------------------------
$btnOpenBrowser.Add_Click({
    Write-GuiLog "Membuka halaman website: $baseUrl" "AKSI"
    Start-Process $baseUrl
})

# -----------------------------------------------------------------------
# Button: Buka Admin Panel
# -----------------------------------------------------------------------
$btnOpenAdmin.Add_Click({
    Write-GuiLog "Membuka halaman admin: $adminUrl" "AKSI"
    Start-Process $adminUrl
})

# -----------------------------------------------------------------------
# Button: Isi Ulang Database
# -----------------------------------------------------------------------
$btnMigrateSeed.Add_Click({
    Write-GuiLog "Memperbarui dan mengisi ulang database..." "DATABASE"
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        $out = docker compose exec -T app php artisan migrate:fresh --seed --no-interaction 2>&1
    } else {
        $out = php artisan migrate:fresh --seed --no-interaction 2>&1
    }
    Write-GuiLog ($out -join "`r`n") "DATABASE"
    Write-GuiLog "Database berhasil diperbarui!" "SUKSES"
})

# -----------------------------------------------------------------------
# Button: Kompilasi Tampilan (Vite Build)
# -----------------------------------------------------------------------
$btnBuildProd.Add_Click({
    Write-GuiLog "Mengompilasi aset tampilan (CSS dan JS)..." "PROSES"
    $buildOut = npm run build 2>&1
    Write-GuiLog ($buildOut -join "`r`n") "BUILD"
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        docker compose exec -T app php artisan optimize 2>&1 | Out-Null
    } else {
        php artisan optimize 2>&1 | Out-Null
    }
    Write-GuiLog "Kompilasi tampilan selesai!" "SUKSES"
})

# -----------------------------------------------------------------------
# Button: Bersihkan Cache
# -----------------------------------------------------------------------
$btnClearCache.Add_Click({
    Write-GuiLog "Membersihkan cache sistem..." "CACHE"
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        $out = docker compose exec -T app php artisan optimize:clear 2>&1
    } else {
        $out = php artisan optimize:clear 2>&1
    }
    Write-GuiLog ($out -join "`r`n") "CACHE"
    Write-GuiLog "Cache berhasil dibersihkan." "SUKSES"
})

# -----------------------------------------------------------------------
# Button: Uji Kelayakan Sistem
# -----------------------------------------------------------------------
$btnRunTests.Add_Click({
    Write-GuiLog "Menjalankan pengujian kelayakan seluruh fitur..." "PENGUJIAN"
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        $out = docker compose exec -T app php artisan test --compact 2>&1
    } else {
        $out = php artisan test --compact 2>&1
    }
    Write-GuiLog ($out -join "`r`n") "HASIL"
})

# -----------------------------------------------------------------------
# Button: Lihat Log Docker
# -----------------------------------------------------------------------
$btnDockerLogs.Add_Click({
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        Write-GuiLog "Mengambil 40 baris log terakhir dari server Docker..." "DOCKER"
        $out = docker compose logs --tail=40 2>&1
        Write-GuiLog ($out -join "`r`n") "DOCKER"
    } else {
        Write-GuiLog "Docker belum aktif. Tidak ada log untuk ditampilkan." "PERHATIAN"
    }
})

# -----------------------------------------------------------------------
# Button: Bersihkan Catatan Log
# -----------------------------------------------------------------------
$btnClearLog.Add_Click({
    $logBox.Clear()
    Write-GuiLog "Catatan log dibersihkan." "INFO"
})

# -----------------------------------------------------------------------
# Button: Cek Perubahan Git
# -----------------------------------------------------------------------
$btnGitStatus.Add_Click({
    Write-GuiLog "Memeriksa perubahan file proyek di Git..." "GIT"
    $out = git status -s 2>&1
    if ([string]::IsNullOrWhiteSpace($out)) {
        Write-GuiLog "Semua file sudah tersimpan rapi. Tidak ada perubahan tertunda." "GIT"
    } else {
        Write-GuiLog ($out -join "`r`n") "GIT"
    }
})

# -----------------------------------------------------------------------
# Button: Simpan dan Upload ke GitHub
# -----------------------------------------------------------------------
$btnQuickDeploy.Add_Click({
    $commitMsg = "Pembaruan Dezzly Creative: " + (Get-Date -Format "dd-MM-yyyy HH:mm")
    Write-GuiLog "Menyiapkan dan menyimpan seluruh perubahan file..." "GIT"
    git add . 2>&1 | Out-Null
    $commitOut = git commit -m "$commitMsg" 2>&1
    Write-GuiLog ($commitOut -join "`r`n") "GIT"
    Write-GuiLog "Mengunggah ke GitHub..." "DEPLOY"
    $pushOut = git push origin main 2>&1
    Write-GuiLog ($pushOut -join "`r`n") "DEPLOY"
    Write-GuiLog "Berhasil tersimpan dan diunggah ke GitHub!" "SUKSES"
})

# -----------------------------------------------------------------------
# Detect server status on startup
# -----------------------------------------------------------------------
$portActive = Test-NetConnection -ComputerName 127.0.0.1 -Port 8000 -InformationLevel Quiet -WarningAction SilentlyContinue
Update-ServerStatus $portActive

# Open Window
$window.ShowDialog() | Out-Null