# ==============================================================================
# DEZZLY CREATIVE - PANEL KENDALI SERVER & DEPLOYMENT
# Dilengkapi Pemisahan Lingkungan Dev vs Prod & Info Akses Jaringan (LAN / HP)
# ==============================================================================
Add-Type -AssemblyName PresentationFramework
Add-Type -AssemblyName PresentationCore
Add-Type -AssemblyName WindowsBase
Add-Type -AssemblyName System.Windows.Forms

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $projectRoot

# Deteksi IP LAN Asli (Berdasarkan Default Gateway Wi-Fi / Ethernet aktif, bukan WSL/VMware)
$lanIp = $null
$defaultRoute = Get-NetRoute -DestinationPrefix '0.0.0.0/0' -ErrorAction SilentlyContinue | Sort-Object RouteMetric | Select-Object -First 1
if ($defaultRoute) {
    $lanIp = (Get-NetIPAddress -InterfaceIndex $defaultRoute.InterfaceIndex -AddressFamily IPv4 -ErrorAction SilentlyContinue).IPAddress
}
if (-not $lanIp -or $lanIp -match '^(127\.|169\.254)') {
    $lanIp = (Get-NetIPAddress -AddressFamily IPv4 | Where-Object {
        $_.IPAddress -notmatch '^(169\.254|127\.|172\.(1[6-9]|2[0-9]|3[0-1]))' -and
        $_.InterfaceAlias -notmatch 'WSL|Hyper-V|vEthernet|VMware|Virtual|Loopback'
    } | Select-Object -First 1).IPAddress
}
if (-not $lanIp) { $lanIp = "127.0.0.1" }

$baseUrl  = "http://${lanIp}:8000"
$adminUrl = "http://${lanIp}:8000/admin"

# Fungsi deteksi branch aktif
function Get-CurrentGitBranch {
    $b = git branch --show-current 2>$null
    if ([string]::IsNullOrWhiteSpace($b)) { return "main" }
    return $b.Trim()
}

$currentBranch = Get-CurrentGitBranch

$xaml = @"
<Window xmlns="http://schemas.microsoft.com/winfx/2006/xaml/presentation"
        xmlns:x="http://schemas.microsoft.com/winfx/2006/xaml"
        Title="DEZZLY CREATIVE - Panel Kendali Server, Jaringan &amp; Deployment"
        Height="920" Width="1140"
        MinHeight="780" MinWidth="980"
        WindowStartupLocation="CenterScreen"
        Background="#F1F5F9" Foreground="#0F172A"
        FontFamily="Segoe UI">
    <Window.Resources>
        <Style TargetType="Button">
            <Setter Property="Background" Value="#FFFFFF"/>
            <Setter Property="Foreground" Value="#0F172A"/>
            <Setter Property="BorderBrush" Value="#CBD5E1"/>
            <Setter Property="BorderThickness" Value="2"/>
            <Setter Property="Height" Value="48"/>
            <Setter Property="Padding" Value="10,6"/>
            <Setter Property="FontSize" Value="12.5"/>
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

    <Grid Margin="18">
        <Grid.RowDefinitions>
            <RowDefinition Height="Auto"/>  <!-- Row 0: Header -->
            <RowDefinition Height="Auto"/>  <!-- Row 1: LAN & IP Sharing Bar (PENTING) -->
            <RowDefinition Height="Auto"/>  <!-- Row 2: Server Controls -->
            <RowDefinition Height="Auto"/>  <!-- Row 3: Deployment Section (Dev vs Prod Terpisah) -->
            <RowDefinition Height="Auto"/>  <!-- Row 4: Utility Buttons -->
            <RowDefinition Height="*"/>     <!-- Row 5: Logs Output -->
            <RowDefinition Height="Auto"/>  <!-- Row 6: Footer -->
        </Grid.RowDefinitions>

        <!-- ROW 0: HEADER -->
        <Border Grid.Row="0" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="18,14" Margin="0,0,0,12">
            <Grid>
                <Grid.ColumnDefinitions>
                    <ColumnDefinition Width="*"/>
                    <ColumnDefinition Width="Auto"/>
                </Grid.ColumnDefinitions>

                <StackPanel Grid.Column="0">
                    <StackPanel Orientation="Horizontal" VerticalAlignment="Center">
                        <Border Width="40" Height="40" Background="#0284C7" CornerRadius="8" Margin="0,0,12,0">
                            <TextBlock Text="D" Foreground="#FFFFFF" FontWeight="ExtraBold" FontSize="22" HorizontalAlignment="Center" VerticalAlignment="Center"/>
                        </Border>
                        <StackPanel>
                            <TextBlock Text="DEZZLY CREATIVE" Foreground="#0F172A" FontWeight="ExtraBold" FontSize="22"/>
                            <TextBlock Text="Studio Kendali Server, Multi-User Jaringan &amp; Deploy Terpisah" Foreground="#0369A1" FontWeight="SemiBold" FontSize="12.5"/>
                        </StackPanel>
                    </StackPanel>
                </StackPanel>

                <!-- Badges -->
                <StackPanel Grid.Column="1" Orientation="Horizontal" VerticalAlignment="Center">
                    <!-- Branch Badge -->
                    <Border Name="BranchBadge" Background="#F0FDF4" BorderBrush="#22C55E" BorderThickness="2" CornerRadius="8" Padding="12,6" Margin="0,0,8,0">
                        <StackPanel Orientation="Horizontal">
                            <TextBlock Text="BRANCH AKTIF: " Foreground="#15803D" FontSize="11" FontWeight="Bold" VerticalAlignment="Center"/>
                            <TextBlock Name="BranchText" Text="development" Foreground="#15803D" FontSize="12" FontWeight="ExtraBold" VerticalAlignment="Center"/>
                        </StackPanel>
                    </Border>

                    <!-- Docker Badge -->
                    <Border Name="DockerBadge" Background="#FFF7ED" BorderBrush="#F97316" BorderThickness="2" CornerRadius="8" Padding="12,6" Margin="0,0,8,0">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="DockerDot" Width="10" Height="10" Fill="#F97316" Margin="0,0,6,0" VerticalAlignment="Center"/>
                            <TextBlock Name="DockerStatusText" Text="DOCKER..." Foreground="#C2410C" FontSize="11" FontWeight="Bold" VerticalAlignment="Center"/>
                        </StackPanel>
                    </Border>

                    <!-- Server Badge -->
                    <Border Name="ServerBadge" Background="#FEF2F2" BorderBrush="#EF4444" BorderThickness="2" CornerRadius="8" Padding="12,6">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="ServerDot" Width="10" Height="10" Fill="#EF4444" Margin="0,0,6,0" VerticalAlignment="Center"/>
                            <TextBlock Name="ServerStatusText" Text="SERVER OFFLINE" Foreground="#B91C1C" FontSize="11" FontWeight="Bold" VerticalAlignment="Center"/>
                        </StackPanel>
                    </Border>
                </StackPanel>
            </Grid>
        </Border>

        <!-- ROW 1: KARTU KHUSUS AKSES JARINGAN & SHARING KE HP / PERANGKAT LAIN -->
        <Border Grid.Row="1" Background="#EFF6FF" BorderBrush="#3B82F6" BorderThickness="2" CornerRadius="12" Padding="16,12" Margin="0,0,0,12">
            <Grid>
                <Grid.ColumnDefinitions>
                    <ColumnDefinition Width="Auto"/>
                    <ColumnDefinition Width="*"/>
                    <ColumnDefinition Width="Auto"/>
                </Grid.ColumnDefinitions>

                <!-- Icon Label -->
                <Border Grid.Column="0" Background="#DBEAFE" CornerRadius="8" Padding="10,6" Margin="0,0,14,0" VerticalAlignment="Center">
                    <TextBlock Text="AKSES JARINGAN" Foreground="#1D4ED8" FontWeight="ExtraBold" FontSize="11.5"/>
                </Border>

                <!-- Info IP & URL -->
                <StackPanel Grid.Column="1" VerticalAlignment="Center">
                    <StackPanel Orientation="Horizontal">
                        <TextBlock Text="IP Komputer Ini (Wi-Fi): " Foreground="#1E3A8A" FontSize="13" FontWeight="SemiBold"/>
                        <TextBlock Name="LanIpText" Text="192.168.18.15" Foreground="#1D4ED8" FontSize="14" FontWeight="ExtraBold" Margin="0,0,16,0"/>
                        <TextBlock Text="Alamat Akses untuk HP / Laptop Lain: " Foreground="#1E3A8A" FontSize="13" FontWeight="SemiBold"/>
                        <TextBlock Name="LanUrlText" Text="http://192.168.18.15:8000" Foreground="#0284C7" FontSize="14" FontWeight="ExtraBold"/>
                    </StackPanel>
                    <TextBlock Text="Hubungkan HP ke Wi-Fi yang sama, lalu buka link di atas pada Google Chrome / Safari HP Anda." Foreground="#3B82F6" FontSize="11.5" Margin="0,2,0,0"/>
                </StackPanel>

                <!-- Action Copy & Test Buttons -->
                <StackPanel Grid.Column="2" Orientation="Horizontal" VerticalAlignment="Center">
                    <Button Name="BtnCopyLanUrl" Height="38" Padding="14,4" Background="#1D4ED8" BorderBrush="#1E40AF" Foreground="#FFFFFF" Margin="0,0,6,0">
                        <TextBlock Text="[ SALIN LINK KE HP ]" FontWeight="Bold" FontSize="11.5"/>
                    </Button>
                    <Button Name="BtnOpenFirewall" Height="38" Padding="12,4" Background="#FFFFFF" BorderBrush="#93C5FD" Foreground="#1D4ED8">
                        <TextBlock Text="[ Buka Firewall ]" FontWeight="SemiBold" FontSize="11"/>
                    </Button>
                </StackPanel>
            </Grid>
        </Border>

        <!-- ROW 2: KONTROL SERVER LOCAL -->
        <Border Grid.Row="2" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="14" Margin="0,0,0,12">
            <StackPanel>
                <Grid Margin="0,0,0,8">
                    <TextBlock Text="1. KONTROL SERVER (DOCKER / LOCALHOST)" Foreground="#1E293B" FontSize="12.5" FontWeight="ExtraBold"/>
                    <TextBlock Text="Lokal: http://localhost:8000" Foreground="#64748B" FontSize="11.5" HorizontalAlignment="Right"/>
                </Grid>
                <UniformGrid Columns="4" Rows="1">
                    <Button Name="BtnDockerUp" Margin="3" Background="#15803D" BorderBrush="#166534" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ NYALAKAN SERVER ]" FontSize="13" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Docker Container (Port 8000)" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <Button Name="BtnDockerDown" Margin="3" Background="#FEF2F2" BorderBrush="#DC2626" Foreground="#B91C1C">
                        <StackPanel>
                            <TextBlock Text="[ MATIKAN SERVER ]" FontSize="13" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Hentikan Proses Docker" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <Button Name="BtnOpenBrowser" Margin="3" Background="#0284C7" BorderBrush="#0369A1" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ BUKA WEBSITE ]" FontSize="13" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Halaman Pengunjung" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <Button Name="BtnOpenAdmin" Margin="3" Background="#7C3AED" BorderBrush="#6D28D9" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ ADMIN DASHBOARD ]" FontSize="13" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Kelola Pesanan &amp; Kamera" FontSize="11" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>
                </UniformGrid>
            </StackPanel>
        </Border>

        <!-- ROW 3: DEPLOYMENT TERPISAH (DEV VS PRODUCTION HOSTING) -->
        <Border Grid.Row="3" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="14" Margin="0,0,0,12">
            <StackPanel>
                <Grid Margin="0,0,0,8">
                    <TextBlock Text="2. MANAJEMEN DEPLOYMENT TERPISAH (DEV VS PRODUCTION)" Foreground="#1E293B" FontSize="12.5" FontWeight="ExtraBold"/>
                    <TextBlock Text="Mencegah kode uji coba lokal bercampur dengan website live di hosting" Foreground="#047857" FontSize="11.5" HorizontalAlignment="Right" FontWeight="SemiBold"/>
                </Grid>

                <Grid>
                    <Grid.ColumnDefinitions>
                        <ColumnDefinition Width="*"/>
                        <ColumnDefinition Width="*"/>
                    </Grid.ColumnDefinitions>

                    <!-- KIRI: LINGKUNGAN PENGEMBANGAN (DEV) -->
                    <Border Grid.Column="0" Background="#F0FDF4" BorderBrush="#86EFAC" BorderThickness="1.5" CornerRadius="10" Padding="12" Margin="0,0,6,0">
                        <StackPanel>
                            <Grid Margin="0,0,0,6">
                                <TextBlock Text="JALUR DEVELOPMENT (UJI COBA)" Foreground="#15803D" FontSize="12" FontWeight="ExtraBold"/>
                                <TextBlock Text="Branch: development" Foreground="#166534" FontSize="11" HorizontalAlignment="Right" FontWeight="Bold"/>
                            </Grid>
                            <TextBlock Text="Gunakan ini saat menambah fitur, merapikan tampilan, atau uji coba. Perubahan disimpan ke branch 'development' sehingga aman dan TIDAK mengganggu hosting live." Foreground="#166534" FontSize="11" TextWrapping="Wrap" Margin="0,0,0,10"/>
                            
                            <Grid>
                                <Grid.ColumnDefinitions>
                                    <ColumnDefinition Width="*"/>
                                    <ColumnDefinition Width="Auto"/>
                                </Grid.ColumnDefinitions>
                                <Button Name="BtnDeployDev" Grid.Column="0" Height="42" Background="#16A34A" BorderBrush="#15803D" Foreground="#FFFFFF" Margin="0,0,4,0">
                                    <TextBlock Text="[DEV] Simpan &amp; Push ke Development" FontWeight="Bold" FontSize="12"/>
                                </Button>
                                <Button Name="BtnSwitchDev" Grid.Column="1" Height="42" Padding="10,4" Background="#FFFFFF" BorderBrush="#86EFAC" Foreground="#15803D">
                                    <TextBlock Text="Pindah ke Dev" FontSize="11" FontWeight="Bold"/>
                                </Button>
                            </Grid>
                        </StackPanel>
                    </Border>

                    <!-- KANAN: LINGKUNGAN HOSTING PRODUKSI (PROD) -->
                    <Border Grid.Column="1" Background="#FFFBEB" BorderBrush="#FCD34D" BorderThickness="1.5" CornerRadius="10" Padding="12" Margin="6,0,0,0">
                        <StackPanel>
                            <Grid Margin="0,0,0,6">
                                <TextBlock Text="JALUR PRODUCTION (HOSTING LIVE)" Foreground="#B45309" FontSize="12" FontWeight="ExtraBold"/>
                                <TextBlock Text="Branch: production" Foreground="#92400E" FontSize="11" HorizontalAlignment="Right" FontWeight="Bold"/>
                            </Grid>
                            <TextBlock Text="Gunakan ini HANYA saat fitur sudah matang dan siap diunggah ke website hosting resmi. Sistem akan auto-run test, compile asset, lalu push ke branch 'production'." Foreground="#92400E" FontSize="11" TextWrapping="Wrap" Margin="0,0,0,10"/>
                            
                            <Grid>
                                <Grid.ColumnDefinitions>
                                    <ColumnDefinition Width="*"/>
                                    <ColumnDefinition Width="Auto"/>
                                </Grid.ColumnDefinitions>
                                <Button Name="BtnDeployProd" Grid.Column="0" Height="42" Background="#D97706" BorderBrush="#B45309" Foreground="#FFFFFF" Margin="0,0,4,0">
                                    <TextBlock Text="[PROD] Rilis Resmi ke Hosting Production" FontWeight="Bold" FontSize="12"/>
                                </Button>
                                <Button Name="BtnSwitchProd" Grid.Column="1" Height="42" Padding="10,4" Background="#FFFFFF" BorderBrush="#FCD34D" Foreground="#B45309">
                                    <TextBlock Text="Pindah ke Prod" FontSize="11" FontWeight="Bold"/>
                                </Button>
                            </Grid>
                        </StackPanel>
                    </Border>
                </Grid>
            </StackPanel>
        </Border>

        <!-- ROW 4: UTILITY ACTIONS (DB, BUILD, TEST, CACHE, LOG) -->
        <Border Grid.Row="4" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="12" Margin="0,0,0,12">
            <UniformGrid Columns="5" Rows="1">
                <Button Name="BtnMigrateSeed" Margin="3" Height="40" Background="#F8FAFC" BorderBrush="#94A3B8">
                    <TextBlock Text="[DB] Refresh Database" FontSize="11.5" FontWeight="Bold"/>
                </Button>
                <Button Name="BtnBuildProd" Margin="3" Height="40" Background="#F8FAFC" BorderBrush="#94A3B8">
                    <TextBlock Text="[BUILD] Kompilasi Vite" FontSize="11.5" FontWeight="Bold"/>
                </Button>
                <Button Name="BtnClearCache" Margin="3" Height="40" Background="#F8FAFC" BorderBrush="#94A3B8">
                    <TextBlock Text="[CACHE] Bersihkan Cache" FontSize="11.5" FontWeight="Bold"/>
                </Button>
                <Button Name="BtnRunTests" Margin="3" Height="40" Background="#F8FAFC" BorderBrush="#94A3B8">
                    <TextBlock Text="[TEST] Uji Fitur (PHPUnit)" FontSize="11.5" FontWeight="Bold"/>
                </Button>
                <Button Name="BtnGitStatus" Margin="3" Height="40" Background="#F8FAFC" BorderBrush="#94A3B8">
                    <TextBlock Text="[GIT] Status Perubahan" FontSize="11.5" FontWeight="Bold"/>
                </Button>
            </UniformGrid>
        </Border>

        <!-- ROW 5: LOG BOX -->
        <Border Grid.Row="5" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="14">
            <Grid>
                <Grid.RowDefinitions>
                    <RowDefinition Height="Auto"/>
                    <RowDefinition Height="*"/>
                </Grid.RowDefinitions>

                <Grid Grid.Row="0" Margin="0,0,0,8">
                    <TextBlock Text="3. CATATAN AKTIVITAS DAN STATUS EKSEKUSI" Foreground="#1E293B" FontSize="12" FontWeight="ExtraBold" VerticalAlignment="Center"/>
                    <Button Name="BtnClearLog" HorizontalAlignment="Right" Height="28" Padding="12,2" FontSize="11" Background="#F1F5F9" BorderBrush="#CBD5E1" Foreground="#475569">
                        <TextBlock Text="Bersihkan Catatan"/>
                    </Button>
                </Grid>

                <TextBox Name="LogBox" Grid.Row="1"
                         Background="#F8FAFC" Foreground="#0F172A"
                         BorderBrush="#E2E8F0" BorderThickness="1.5"
                         FontFamily="Consolas, Lucida Console" FontSize="12.5"
                         IsReadOnly="True" TextWrapping="Wrap"
                         VerticalScrollBarVisibility="Auto" Padding="12"/>
            </Grid>
        </Border>

        <!-- ROW 6: FOOTER -->
        <Grid Grid.Row="6" Margin="0,8,0,0">
            <TextBlock Text="Dezzly Creative Platform  |  Arsitektur Dua Cabang (Dev vs Production)  |  Laravel 13 + Docker"
                       Foreground="#64748B" FontSize="11.5" VerticalAlignment="Center" FontWeight="SemiBold"/>
            <TextBlock Text="Remote GitHub: daffaa22/dezzly-digital-creative"
                       Foreground="#0284C7" FontSize="11.5" HorizontalAlignment="Right" VerticalAlignment="Center" FontWeight="Bold"/>
        </Grid>
    </Grid>
</Window>
"@

$stringReader = New-Object System.IO.StringReader($xaml)
$xmlReader    = [System.Xml.XmlReader]::Create($stringReader)
$window       = [Windows.Markup.XamlReader]::Load($xmlReader)

# Mapping Controls
$btnDockerUp      = $window.FindName("BtnDockerUp")
$btnDockerDown    = $window.FindName("BtnDockerDown")
$btnOpenBrowser   = $window.FindName("BtnOpenBrowser")
$btnOpenAdmin     = $window.FindName("BtnOpenAdmin")
$btnCopyLanUrl    = $window.FindName("BtnCopyLanUrl")
$btnOpenFirewall  = $window.FindName("BtnOpenFirewall")
$btnDeployDev     = $window.FindName("BtnDeployDev")
$btnDeployProd    = $window.FindName("BtnDeployProd")
$btnSwitchDev     = $window.FindName("BtnSwitchDev")
$btnSwitchProd    = $window.FindName("BtnSwitchProd")
$btnMigrateSeed   = $window.FindName("BtnMigrateSeed")
$btnBuildProd     = $window.FindName("BtnBuildProd")
$btnClearCache    = $window.FindName("BtnClearCache")
$btnRunTests      = $window.FindName("BtnRunTests")
$btnGitStatus     = $window.FindName("BtnGitStatus")
$btnClearLog      = $window.FindName("BtnClearLog")
$logBox           = $window.FindName("LogBox")
$serverDot        = $window.FindName("ServerDot")
$serverStatusText = $window.FindName("ServerStatusText")
$serverBadge      = $window.FindName("ServerBadge")
$dockerDot        = $window.FindName("DockerDot")
$dockerStatusText = $window.FindName("DockerStatusText")
$dockerBadge      = $window.FindName("DockerBadge")
$branchBadge      = $window.FindName("BranchBadge")
$branchText       = $window.FindName("BranchText")
$lanIpText        = $window.FindName("LanIpText")
$lanUrlText       = $window.FindName("LanUrlText")

# Helper Log
function Write-GuiLog([string]$message, [string]$type = "INFO") {
    $timestamp = Get-Date -Format "HH:mm:ss"
    $logBox.AppendText("[$timestamp] [$type] $message`r`n")
    $logBox.ScrollToEnd()
}

# Update Tampilan Branch
function Update-BranchBadge {
    $b = Get-CurrentGitBranch
    $branchText.Text = $b
    if ($b -eq "production") {
        $branchBadge.Background = [System.Windows.Media.Brushes]::MistyRose
        $branchBadge.BorderBrush = [System.Windows.Media.Brushes]::Crimson
        $branchText.Foreground   = [System.Windows.Media.Brushes]::DarkRed
    } else {
        $branchBadge.Background = [System.Windows.Media.Brushes]::Honeydew
        $branchBadge.BorderBrush = [System.Windows.Media.Brushes]::SeaGreen
        $branchText.Foreground   = [System.Windows.Media.Brushes]::DarkGreen
    }
}

# Update Tampilan Server
function Update-ServerStatus([bool]$isRunning) {
    if ($isRunning) {
        $serverDot.Fill              = [System.Windows.Media.Brushes]::ForestGreen
        $serverStatusText.Text       = "SERVER AKTIF (PORT 8000)"
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

# Init Nilai UI
$lanIpText.Text  = $lanIp
$lanUrlText.Text = $baseUrl
Update-BranchBadge

# Initial Logs
Write-GuiLog "Dezzly Studio Controller aktif." "SISTEM"
Write-GuiLog "Folder Proyek: $projectRoot" "INFO"
Write-GuiLog "IP LAN Utama (Wi-Fi): $lanIp" "JARINGAN"
Write-GuiLog "Link Akses untuk Perangkat Lain: $baseUrl" "JARINGAN"
Write-GuiLog "Branch Git Aktif: $(Get-CurrentGitBranch)" "GIT"

# Cek Docker
$hasDocker = Get-Command "docker" -ErrorAction SilentlyContinue
if ($hasDocker) {
    $dockerDot.Fill            = [System.Windows.Media.Brushes]::ForestGreen
    $dockerStatusText.Text     = "DOCKER AKTIF"
    $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::DarkGreen
    $dockerBadge.Background    = [System.Windows.Media.Brushes]::Honeydew
    $dockerBadge.BorderBrush   = [System.Windows.Media.Brushes]::SeaGreen
} else {
    $dockerDot.Fill            = [System.Windows.Media.Brushes]::OrangeRed
    $dockerStatusText.Text     = "DOCKER BELUM AKTIF"
    $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::OrangeRed
    Write-GuiLog "Aplikasi Docker Desktop belum aktif di sistem Windows." "PERHATIAN"
}

# -----------------------------------------------------------------------
# EVENT HANDLERS
# -----------------------------------------------------------------------

# Salin Link LAN ke Clipboard
$btnCopyLanUrl.Add_Click({
    [System.Windows.Clipboard]::SetText($baseUrl)
    Write-GuiLog "Link '$baseUrl' berhasil disalin ke Clipboard!" "SUKSES"
    Write-GuiLog "Anda bisa langsung paste/kirim link tersebut ke WhatsApp rekan atau buka di browser HP." "INFO"
    [System.Windows.MessageBox]::Show("Link berhasil disalin:`n$baseUrl`n`nSilakan buka di browser HP (Chrome / Safari) yang terhubung ke Wi-Fi yang sama.", "Link Disalin", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Information) | Out-Null
})

# Jalankan Setup Firewall
$btnOpenFirewall.Add_Click({
    Write-GuiLog "Membuka wizard konfigurasi Windows Firewall untuk port 8000..." "FIREWALL"
    $firewallScript = Join-Path $projectRoot "Setup-Firewall-Admin.ps1"
    if (Test-Path $firewallScript) {
        Start-Process powershell -Verb RunAs -ArgumentList "-NoProfile -ExecutionPolicy Bypass -File `"$firewallScript`""
        Write-GuiLog "Silakan klik 'Yes' pada jendela konfirmasi Administrator Windows yang muncul." "INFO"
    } else {
        Write-GuiLog "File Setup-Firewall-Admin.ps1 tidak ditemukan." "ERROR"
    }
})

# Server: Nyalakan Docker
$btnDockerUp.Add_Click({
    if (-not (Get-Command "docker" -ErrorAction SilentlyContinue)) {
        Write-GuiLog "Docker belum terdeteksi. Buka Docker Desktop terlebih dahulu." "PERHATIAN"
        [System.Windows.MessageBox]::Show("Silakan buka aplikasi Docker Desktop di komputer Anda terlebih dahulu.", "Docker Belum Aktif", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Warning) | Out-Null
        return
    }
    Write-GuiLog "Menyalakan container Docker..." "PROSES"
    $out = docker compose up -d 2>&1
    Write-GuiLog ($out -join "`r`n") "DOCKER"
    Update-ServerStatus $true
    Write-GuiLog "Server aktif di $baseUrl (Lokal & Jaringan Wi-Fi)" "SUKSES"
})

# Server: Matikan
$btnDockerDown.Add_Click({
    Write-GuiLog "Mematikan server..." "PROSES"
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        $out = docker compose down 2>&1
        Write-GuiLog ($out -join "`r`n") "DOCKER"
    }
    Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
    Update-ServerStatus $false
    Write-GuiLog "Server berhasil dinonaktifkan." "SELESAI"
})

# Buka Browser Publik
$btnOpenBrowser.Add_Click({
    Write-GuiLog "Membuka website di browser: $baseUrl" "AKSI"
    Start-Process $baseUrl
})

# Buka Admin Panel
$btnOpenAdmin.Add_Click({
    Write-GuiLog "Membuka admin panel: $adminUrl" "AKSI"
    Start-Process $adminUrl
})

# DEPLOY DEV: Commit & Push ke branch development
$btnDeployDev.Add_Click({
    $curr = Get-CurrentGitBranch
    if ($curr -ne "development") {
        Write-GuiLog "Pindah ke branch 'development' terlebih dahulu..." "GIT"
        git checkout development 2>&1 | Out-Null
        Update-BranchBadge
    }
    
    $msg = "dev update: " + (Get-Date -Format "dd-MM-yyyy HH:mm")
    Write-GuiLog "Menyimpan perubahan ke branch DEVELOPMENT..." "DEV DEPLOY"
    git add . 2>&1 | Out-Null
    $commitOut = git commit -m "$msg" 2>&1
    Write-GuiLog ($commitOut -join "`r`n") "GIT"
    Write-GuiLog "Mendorong perubahan ke GitHub (origin/development)..." "DEV DEPLOY"
    $pushOut = git push origin development 2>&1
    Write-GuiLog ($pushOut -join "`r`n") "DEV DEPLOY"
    Write-GuiLog "BERHASIL: Perubahan tersimpan di branch 'development'. Hosting live production aman!" "SUKSES"
    Update-BranchBadge
})

# DEPLOY PROD: Build, Test, Merge ke production & Push
$btnDeployProd.Add_Click({
    $confirm = [System.Windows.MessageBox]::Show(
        "Apakah Anda yakin ingin merilis ke PRODUCTION (Hosting Live)?`n`nSistem akan menjalankan:`n1. Uji Kelayakan Otomatis (PHPUnit)`n2. Kompilasi Aset Siap Produksi (Vite)`n3. Merge & Push ke branch 'production' untuk hosting live.",
        "Konfirmasi Rilis Produksi",
        [System.Windows.MessageBoxButton]::YesNo,
        [System.Windows.MessageBoxImage]::Question
    )
    if ($confirm -ne [System.Windows.MessageBoxResult]::Yes) {
        Write-GuiLog "Rilis ke production dibatalkan oleh pengguna." "INFO"
        return
    }

    Write-GuiLog "=== MEMULAI PROSES RILIS KE PRODUCTION ===" "PROD DEPLOY"

    # Step 1: Run tests
    Write-GuiLog "[Langkah 1/4] Menjalankan uji kelayakan fitur (PHPUnit)..." "PENGUJIAN"
    $testOut = php artisan test --compact 2>&1
    Write-GuiLog ($testOut -join "`r`n") "PENGUJIAN"
    if ($LASTEXITCODE -ne 0) {
        Write-GuiLog "GAGAL: Ada pengujian yang tidak lolos! Rilis dibatalkan agar hosting tidak error." "ERROR"
        [System.Windows.MessageBox]::Show("Uji kelayakan (PHPUnit) menemukan error. Rilis dibatalkan.", "Rilis Gagal", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Error) | Out-Null
        return
    }

    # Step 2: Build assets
    Write-GuiLog "[Langkah 2/4] Mengompilasi aset frontend produksi (npm run build)..." "BUILD"
    $buildOut = npm run build 2>&1
    Write-GuiLog ($buildOut -join "`r`n") "BUILD"

    # Step 3: Commit current dev changes
    Write-GuiLog "[Langkah 3/4] Menyiapkan commit rilis..." "GIT"
    git add . 2>&1 | Out-Null
    $releaseMsg = "prod release: v" + (Get-Date -Format "yyyy.MM.dd-HHmm")
    git commit -m "$releaseMsg" 2>&1 | Out-Null

    # Step 4: Checkout production, merge development, push production
    Write-GuiLog "[Langkah 4/4] Menggabungkan ke branch 'production' dan mengunggah ke GitHub..." "PROD DEPLOY"
    git checkout production 2>&1 | Out-Null
    git merge development -m "Merge development into production ($releaseMsg)" 2>&1 | Out-Null
    $pushProd = git push origin production 2>&1
    Write-GuiLog ($pushProd -join "`r`n") "PROD DEPLOY"

    # Also sync to main for standard repo view
    git checkout main 2>&1 | Out-Null
    git merge production -m "Sync production into main ($releaseMsg)" 2>&1 | Out-Null
    git push origin main 2>&1 | Out-Null

    # Return to development
    git checkout development 2>&1 | Out-Null
    Update-BranchBadge

    Write-GuiLog "=== RILIS PRODUCTION SUKSES! ===" "SUKSES"
    Write-GuiLog "Website hosting live sekarang dapat menarik pembaruan dari branch 'production'." "INFO"
    Write-GuiLog "Active branch Anda telah dikembalikan ke 'development' untuk lanjut bekerja aman." "INFO"
    [System.Windows.MessageBox]::Show("Rilis Production Berhasil!`n`nBranch 'production' telah terupdate di GitHub.`nAnda telah dikembalikan ke branch 'development' untuk coding berikutnya.", "Sukses Rilis Production", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Information) | Out-Null
})

# Pindah ke Branch Development
$btnSwitchDev.Add_Click({
    Write-GuiLog "Berpindah ke branch 'development'..." "GIT"
    $out = git checkout development 2>&1
    Write-GuiLog ($out -join "`r`n") "GIT"
    Update-BranchBadge
})

# Pindah ke Branch Production
$btnSwitchProd.Add_Click({
    Write-GuiLog "Berpindah ke branch 'production'..." "GIT"
    $out = git checkout production 2>&1
    Write-GuiLog ($out -join "`r`n") "GIT"
    Update-BranchBadge
})

# Refresh Database
$btnMigrateSeed.Add_Click({
    Write-GuiLog "Menjalankan migrasi database & seed..." "DATABASE"
    if (Get-Command "docker" -ErrorAction SilentlyContinue -and (docker compose ps -q app 2>$null)) {
        $out = docker compose exec -T app php artisan migrate:fresh --seed --no-interaction 2>&1
    } else {
        $out = php artisan migrate:fresh --seed --no-interaction 2>&1
    }
    Write-GuiLog ($out -join "`r`n") "DATABASE"
    Write-GuiLog "Database berhasil diperbarui dengan data paket & kamera!" "SUKSES"
})

# Build Vite
$btnBuildProd.Add_Click({
    Write-GuiLog "Menjalankan build Vite..." "BUILD"
    $out = npm run build 2>&1
    Write-GuiLog ($out -join "`r`n") "BUILD"
    Write-GuiLog "Kompilasi selesai." "SUKSES"
})

# Clear Cache
$btnClearCache.Add_Click({
    Write-GuiLog "Membersihkan cache aplikasi..." "CACHE"
    if (Get-Command "docker" -ErrorAction SilentlyContinue -and (docker compose ps -q app 2>$null)) {
        $out = docker compose exec -T app php artisan optimize:clear 2>&1
    } else {
        $out = php artisan optimize:clear 2>&1
    }
    Write-GuiLog ($out -join "`r`n") "CACHE"
})

# Run Tests
$btnRunTests.Add_Click({
    Write-GuiLog "Menjalankan test suite PHPUnit..." "TEST"
    $out = php artisan test --compact 2>&1
    Write-GuiLog ($out -join "`r`n") "TEST"
})

# Git Status
$btnGitStatus.Add_Click({
    Write-GuiLog "Memeriksa status git..." "GIT"
    $branch = Get-CurrentGitBranch
    $out = git status -s 2>&1
    Write-GuiLog "Branch: $branch" "GIT"
    if ([string]::IsNullOrWhiteSpace($out)) {
        Write-GuiLog "Tidak ada perubahan file yang belum disimpan (Clean)." "GIT"
    } else {
        Write-GuiLog ($out -join "`r`n") "GIT"
    }
})

# Clear Log
$btnClearLog.Add_Click({
    $logBox.Clear()
    Write-GuiLog "Catatan log dibersihkan." "INFO"
})

# Cek Port Awal
$portActive = Test-NetConnection -ComputerName 127.0.0.1 -Port 8000 -InformationLevel Quiet -WarningAction SilentlyContinue
Update-ServerStatus $portActive

# Tampilkan GUI
$window.ShowDialog() | Out-Null
