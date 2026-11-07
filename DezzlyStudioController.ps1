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
    if ([string]::IsNullOrWhiteSpace($b)) { return "" }
    return $b.Trim()
}

# Fungsi cek keberadaan branch lokal
function Test-GitBranchExists([string]$Branch) {
    git rev-parse --verify "refs/heads/$Branch" 2>$null | Out-Null
    return ($LASTEXITCODE -eq 0)
}

$currentBranch = Get-CurrentGitBranch

$xaml = @"
<Window xmlns="http://schemas.microsoft.com/winfx/2006/xaml/presentation"
        xmlns:x="http://schemas.microsoft.com/winfx/2006/xaml"
        Title="DEZZLY CREATIVE - Panel Kendali Server, Jaringan &amp; Deployment"
        Height="1000" Width="1160"
        MinHeight="880" MinWidth="1000"
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
            <RowDefinition Height="Auto"/>  <!-- Row 4: Phase Pipeline (Setup -> Dev -> QA -> Staging -> Prod -> Hotfix) -->
            <RowDefinition Height="Auto"/>  <!-- Row 5: Utility Buttons -->
            <RowDefinition Height="*"/>     <!-- Row 6: Logs Output -->
            <RowDefinition Height="Auto"/>  <!-- Row 7: Footer -->
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

                    <!-- Docker Badge (Klik untuk cek/buka) -->
                    <Border Name="DockerBadge" Background="#FFF7ED" BorderBrush="#F97316" BorderThickness="2" CornerRadius="8" Padding="12,6" Margin="0,0,8,0" Cursor="Hand" ToolTip="Status Docker Engine Windows. Klik untuk refresh / buka Docker.">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="DockerDot" Width="10" Height="10" Fill="#F97316" Margin="0,0,6,0" VerticalAlignment="Center"/>
                            <TextBlock Name="DockerStatusText" Text="MEMERIKSA DOCKER..." Foreground="#C2410C" FontSize="11" FontWeight="Bold" VerticalAlignment="Center"/>
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

        <!-- ROW 2: KONTROL SERVER (DUAL ENGINE: DOCKER / PHP NATIVE / LOCALHOST) -->
        <Border Grid.Row="2" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="14" Margin="0,0,0,12">
            <StackPanel>
                <Grid Margin="0,0,0,8">
                    <TextBlock Text="1. KONTROL SERVER (DUAL ENGINE: DOCKER / PHP ARTISAN / PORT 8000)" Foreground="#1E293B" FontSize="12.5" FontWeight="ExtraBold"/>
                    <TextBlock Text="Akses Lokal: http://localhost:8000" Foreground="#64748B" FontSize="11.5" HorizontalAlignment="Right"/>
                </Grid>
                <UniformGrid Columns="5" Rows="1">
                    <!-- 1. Nyalakan Docker -->
                    <Button Name="BtnDockerUp" Margin="3" Background="#15803D" BorderBrush="#166534" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Name="TxtDockerUpTitle" Text="[ NYALAKAN DOCKER ]" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Name="TxtDockerUpSub" Text="Container (Port 8000)" FontSize="10" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <!-- 2. Nyalakan PHP Serve Native (Cepat tanpa Docker) -->
                    <Button Name="BtnPhpServe" Margin="3" Background="#059669" BorderBrush="#047857" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Name="TxtPhpServeTitle" Text="[ NYALAKAN PHP SERVE ]" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Name="TxtPhpServeSub" Text="Artisan (Tanpa Docker)" FontSize="10" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <!-- 3. Matikan Server -->
                    <Button Name="BtnDockerDown" Margin="3" Background="#FEF2F2" BorderBrush="#DC2626" Foreground="#B91C1C">
                        <StackPanel>
                            <TextBlock Name="TxtDockerDownTitle" Text="[ MATIKAN SERVER ]" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Name="TxtDockerDownSub" Text="Stop Docker &amp; PHP" FontSize="10" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <!-- 4. Buka Website Pengunjung -->
                    <Button Name="BtnOpenBrowser" Margin="3" Background="#0284C7" BorderBrush="#0369A1" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ BUKA WEBSITE ]" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Halaman Pengunjung" FontSize="10" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>

                    <!-- 5. Buka Admin Dashboard -->
                    <Button Name="BtnOpenAdmin" Margin="3" Background="#7C3AED" BorderBrush="#6D28D9" Foreground="#FFFFFF">
                        <StackPanel>
                            <TextBlock Text="[ ADMIN DASHBOARD ]" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Kelola Pesanan &amp; CMS" FontSize="10" HorizontalAlignment="Center"/>
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

        <!-- ROW 4: PHASE PIPELINE (SETUP -> DEVELOPMENT -> QUALITY GATE -> STAGING -> PRODUCTION -> HOTFIX) -->
        <Border Grid.Row="4" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="14" Margin="0,0,0,12">
            <StackPanel>
                <Grid Margin="0,0,0,8">
                    <TextBlock Text="3. FASE PENGEMBANGAN &amp; PIPELINE RILIS" Foreground="#1E293B" FontSize="12.5" FontWeight="ExtraBold"/>
                    <TextBlock Text="Dev -> Staging -> Production  |  Setiap fase punya tombol aksi sendiri" Foreground="#0369A1" FontSize="11.5" HorizontalAlignment="Right" FontWeight="SemiBold"/>
                </Grid>
                <UniformGrid Columns="6" Rows="1">
                    <Button Name="BtnPhaseSetup" Margin="3" Height="54" Background="#EFF6FF" BorderBrush="#93C5FD" Foreground="#1D4ED8">
                        <StackPanel>
                            <TextBlock Text="1. SETUP" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Install &amp; Migrate" FontSize="9.5" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>
                    <Button Name="BtnPhaseDev" Margin="3" Height="54" Background="#F0FDF4" BorderBrush="#86EFAC" Foreground="#15803D">
                        <StackPanel>
                            <TextBlock Text="2. DEVELOPMENT" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Commit &amp; Push Dev" FontSize="9.5" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>
                    <Button Name="BtnPhaseQuality" Margin="3" Height="54" Background="#F5F3FF" BorderBrush="#C4B5FD" Foreground="#6D28D9">
                        <StackPanel>
                            <TextBlock Text="3. QUALITY GATE" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Test &amp; Security Audit" FontSize="9.5" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>
                    <Button Name="BtnPhaseStaging" Margin="3" Height="54" Background="#FFFBEB" BorderBrush="#FCD34D" Foreground="#B45309">
                        <StackPanel>
                            <TextBlock Text="4. STAGING" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Merge &amp; Push Staging" FontSize="9.5" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>
                    <Button Name="BtnPhaseProd" Margin="3" Height="54" Background="#FEF2F2" BorderBrush="#FCA5A5" Foreground="#B91C1C">
                        <StackPanel>
                            <TextBlock Text="5. PRODUCTION" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Rilis ke Hosting Live" FontSize="9.5" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>
                    <Button Name="BtnPhaseHotfix" Margin="3" Height="54" Background="#F8FAFC" BorderBrush="#94A3B8" Foreground="#334155">
                        <StackPanel>
                            <TextBlock Text="6. HOTFIX" FontSize="12" FontWeight="ExtraBold" HorizontalAlignment="Center"/>
                            <TextBlock Text="Cabang Perbaikan Cepat" FontSize="9.5" HorizontalAlignment="Center"/>
                        </StackPanel>
                    </Button>
                </UniformGrid>
            </StackPanel>
        </Border>

        <!-- ROW 5: UTILITY ACTIONS (DB, BUILD, TEST, CACHE, LOG) -->
        <Border Grid.Row="5" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="12" Margin="0,0,0,12">
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

        <!-- ROW 6: LOG BOX -->
        <Border Grid.Row="6" Background="#FFFFFF" BorderBrush="#CBD5E1" BorderThickness="2" CornerRadius="12" Padding="14">
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

        <!-- ROW 7: FOOTER -->
        <Grid Grid.Row="7" Margin="0,8,0,0">
            <TextBlock Text="Dezzly Creative Platform  |  Arsitektur Dua Cabang (Dev vs Production)  |  Dual Engine (Docker / PHP Native)"
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
$btnDockerUp        = $window.FindName("BtnDockerUp")
$btnPhpServe        = $window.FindName("BtnPhpServe")
$btnDockerDown      = $window.FindName("BtnDockerDown")
$btnOpenBrowser     = $window.FindName("BtnOpenBrowser")
$btnOpenAdmin       = $window.FindName("BtnOpenAdmin")
$btnCopyLanUrl      = $window.FindName("BtnCopyLanUrl")
$btnOpenFirewall    = $window.FindName("BtnOpenFirewall")
$btnDeployDev       = $window.FindName("BtnDeployDev")
$btnDeployProd      = $window.FindName("BtnDeployProd")
$btnSwitchDev       = $window.FindName("BtnSwitchDev")
$btnSwitchProd      = $window.FindName("BtnSwitchProd")
$btnMigrateSeed     = $window.FindName("BtnMigrateSeed")
$btnBuildProd       = $window.FindName("BtnBuildProd")
$btnClearCache      = $window.FindName("BtnClearCache")
$btnRunTests        = $window.FindName("BtnRunTests")
$btnGitStatus       = $window.FindName("BtnGitStatus")
$btnPhaseSetup      = $window.FindName("BtnPhaseSetup")
$btnPhaseDev        = $window.FindName("BtnPhaseDev")
$btnPhaseQuality    = $window.FindName("BtnPhaseQuality")
$btnPhaseStaging    = $window.FindName("BtnPhaseStaging")
$btnPhaseProd       = $window.FindName("BtnPhaseProd")
$btnPhaseHotfix     = $window.FindName("BtnPhaseHotfix")
$btnClearLog        = $window.FindName("BtnClearLog")
$logBox             = $window.FindName("LogBox")
$serverDot          = $window.FindName("ServerDot")
$serverStatusText   = $window.FindName("ServerStatusText")
$serverBadge        = $window.FindName("ServerBadge")
$dockerDot          = $window.FindName("DockerDot")
$dockerStatusText   = $window.FindName("DockerStatusText")
$dockerBadge        = $window.FindName("DockerBadge")
$branchBadge        = $window.FindName("BranchBadge")
$branchText         = $window.FindName("BranchText")
$lanIpText          = $window.FindName("LanIpText")
$lanUrlText         = $window.FindName("LanUrlText")
$txtDockerUpTitle   = $window.FindName("TxtDockerUpTitle")
$txtDockerUpSub     = $window.FindName("TxtDockerUpSub")
$txtPhpServeTitle   = $window.FindName("TxtPhpServeTitle")
$txtPhpServeSub     = $window.FindName("TxtPhpServeSub")
$txtDockerDownTitle = $window.FindName("TxtDockerDownTitle")
$txtDockerDownSub   = $window.FindName("TxtDockerDownSub")

# Helper Log
function Write-GuiLog([string]$message, [string]$type = "INFO") {
    $timestamp = Get-Date -Format "HH:mm:ss"
    $logBox.AppendText("[$timestamp] [$type] $message`r`n")
    $logBox.ScrollToEnd()
}

# Helper: Jalankan perintah eksternal, catat output & exit code
function Invoke-GuiProcess([string]$Label, [string]$Command, [string[]]$Arguments, [string]$Type = "INFO") {
    Write-GuiLog "$Label" $Type
    $output = & $Command @Arguments 2>&1
    $exitCode = $LASTEXITCODE
    if ($null -ne $output -and ($output | Out-String).Trim().Length -gt 0) {
        Write-GuiLog (($output | Out-String).TrimEnd()) $Type
    }
    if ($exitCode -ne 0) {
        Write-GuiLog "GAGAL (exit code $exitCode): $Label" "ERROR"
    } else {
        Write-GuiLog "OK: $Label" "SUKSES"
    }
    return $exitCode
}

# Helper: Pindah branch dengan validasi
function Switch-GitBranch([string]$Branch) {
    $current = Get-CurrentGitBranch
    if ($current -eq $Branch) {
        Write-GuiLog "Sudah berada di branch '$Branch'." "GIT"
        return $true
    }

    Write-GuiLog "Berpindah ke branch '$Branch'..." "GIT"
    $output = git checkout $Branch 2>&1
    $exitCode = $LASTEXITCODE
    Write-GuiLog (($output | Out-String).TrimEnd()) "GIT"
    Update-BranchBadge

    if ($exitCode -ne 0) {
        Write-GuiLog "GAGAL: Tidak dapat berpindah ke branch '$Branch'. Pastikan working tree bersih." "ERROR"
        return $false
    }

    return $true
}

# Helper: Konfirmasi aksi berisiko
function Confirm-GuiAction([string]$Message, [string]$Title) {
    $result = [System.Windows.MessageBox]::Show(
        $Message,
        $Title,
        [System.Windows.MessageBoxButton]::YesNo,
        [System.Windows.MessageBoxImage]::Warning
    )
    return ($result -eq [System.Windows.MessageBoxResult]::Yes)
}

# Helper: Pastikan .env & APP_KEY siap
function Ensure-EnvironmentFile {
    if (-not (Test-Path ".env")) {
        if (Test-Path ".env.example") {
            Copy-Item ".env.example" ".env"
            Write-GuiLog "File .env dibuat dari .env.example." "SETUP"
        } else {
            Write-GuiLog "GAGAL: .env.example tidak ditemukan." "ERROR"
            return $false
        }
    }

    $keyLine = Select-String -Path ".env" -Pattern '^APP_KEY=.+$' -ErrorAction SilentlyContinue
    if (-not $keyLine) {
        Write-GuiLog "APP_KEY belum diisi. Membuat application key..." "SETUP"
        $exitCode = Invoke-GuiProcess "Generate application key..." "php" @("artisan", "key:generate", "--force") "SETUP"
        if ($exitCode -ne 0) { return $false }
    }

    return $true
}

# Helper: Cek Port 8000 Super Cepat & Non-Blocking (<400ms)
function Test-PortFast([int]$port = 8000) {
    $tcp = New-Object System.Net.Sockets.TcpClient
    try {
        $iar = $tcp.BeginConnect("127.0.0.1", $port, $null, $null)
        $wait = $iar.AsyncWaitHandle.WaitOne(400, $false)
        if ($wait -and $tcp.Connected) {
            $tcp.EndConnect($iar)
            return $true
        }
        return $false
    } catch {
        return $false
    } finally {
        $tcp.Close()
    }
}

# Helper: Cek Docker Daemon Engine Asli (Bukan sekadar docker.exe)
function Test-DockerDaemonFast {
    if (-not (Get-Command "docker" -ErrorAction SilentlyContinue)) {
        return $false
    }
    try {
        $pinfo = New-Object System.Diagnostics.ProcessStartInfo
        $pinfo.FileName = "docker"
        $pinfo.Arguments = "info --format '{{.ServerVersion}}'"
        $pinfo.RedirectStandardOutput = $true
        $pinfo.RedirectStandardError = $true
        $pinfo.UseShellExecute = $false
        $pinfo.CreateNoWindow = $true
        $p = [System.Diagnostics.Process]::Start($pinfo)
        $exited = $p.WaitForExit(1200)
        if (-not $exited) {
            $p.Kill()
            return $false
        }
        return ($p.ExitCode -eq 0)
    } catch {
        return $false
    }
}

# Update Tampilan Branch
function Update-BranchBadge {
    $b = Get-CurrentGitBranch
    if ([string]::IsNullOrWhiteSpace($b)) {
        $branchText.Text = "(detached / tanpa branch)"
        $branchBadge.Background = [System.Windows.Media.Brushes]::WhiteSmoke
        $branchBadge.BorderBrush = [System.Windows.Media.Brushes]::Gray
        $branchText.Foreground   = [System.Windows.Media.Brushes]::DimGray
        return
    }

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

# Update Status Docker Badge
function Update-DockerBadge {
    $hasDockerCli = Get-Command "docker" -ErrorAction SilentlyContinue
    if (-not $hasDockerCli) {
        $dockerDot.Fill            = [System.Windows.Media.Brushes]::SlateGray
        $dockerStatusText.Text     = "DOCKER TIDAK TERPASANG"
        $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::DimGray
        $dockerBadge.Background    = [System.Windows.Media.Brushes]::WhiteSmoke
        $dockerBadge.BorderBrush   = [System.Windows.Media.Brushes]::LightGray
        return $false
    }

    $daemonUp = Test-DockerDaemonFast
    if ($daemonUp) {
        $dockerDot.Fill            = [System.Windows.Media.Brushes]::ForestGreen
        $dockerStatusText.Text     = "DOCKER ENGINE AKTIF"
        $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::DarkGreen
        $dockerBadge.Background    = [System.Windows.Media.Brushes]::Honeydew
        $dockerBadge.BorderBrush   = [System.Windows.Media.Brushes]::SeaGreen
        return $true
    } else {
        $dockerDot.Fill            = [System.Windows.Media.Brushes]::DarkOrange
        $dockerStatusText.Text     = "DOCKER ENGINE BELUM JALAN"
        $dockerStatusText.Foreground = [System.Windows.Media.Brushes]::DarkGoldenrod
        $dockerBadge.Background    = [System.Windows.Media.Brushes]::Cornsilk
        $dockerBadge.BorderBrush   = [System.Windows.Media.Brushes]::BurlyWood
        return $false
    }
}

# Update Tampilan Server & State Tombol secara UX Interaktif
function Update-ServerStatus([bool]$isRunning, [string]$source = "") {
    if ($isRunning) {
        $serverDot.Fill              = [System.Windows.Media.Brushes]::ForestGreen
        if ($source -ne "") {
            $serverStatusText.Text   = "SERVER AKTIF ($source | PORT 8000)"
        } else {
            $serverStatusText.Text   = "SERVER AKTIF (PORT 8000)"
        }
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::DarkGreen
        $serverBadge.Background      = [System.Windows.Media.Brushes]::Honeydew
        $serverBadge.BorderBrush     = [System.Windows.Media.Brushes]::SeaGreen

        # Visual Tombol Saat Server Aktif
        $btnDockerDown.IsEnabled     = $true
        $btnDockerDown.Opacity       = 1.0
        $txtDockerDownTitle.Text     = "[ MATIKAN SERVER ]"

        $btnOpenBrowser.IsEnabled    = $true
        $btnOpenBrowser.Opacity      = 1.0
        $btnOpenAdmin.IsEnabled      = $true
        $btnOpenAdmin.Opacity        = 1.0

        $btnDockerUp.Opacity         = 0.75
        $btnPhpServe.Opacity         = 0.75
    } else {
        $serverDot.Fill              = [System.Windows.Media.Brushes]::Crimson
        $serverStatusText.Text       = "SERVER OFFLINE"
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::DarkRed
        $serverBadge.Background      = [System.Windows.Media.Brushes]::MistyRose
        $serverBadge.BorderBrush     = [System.Windows.Media.Brushes]::LightCoral

        # Visual Tombol Saat Server Mati
        $btnDockerUp.IsEnabled       = $true
        $btnDockerUp.Opacity         = 1.0
        $txtDockerUpTitle.Text       = "[ NYALAKAN DOCKER ]"
        $txtDockerUpSub.Text         = "Container (Port 8000)"

        $btnPhpServe.IsEnabled       = $true
        $btnPhpServe.Opacity         = 1.0
        $txtPhpServeTitle.Text       = "[ NYALAKAN PHP SERVE ]"
        $txtPhpServeSub.Text         = "Artisan (Tanpa Docker)"

        $btnDockerDown.IsEnabled     = $false
        $btnDockerDown.Opacity       = 0.5
        $txtDockerDownTitle.Text     = "[ SERVER OFF ]"

        $btnOpenBrowser.Opacity      = 0.8
        $btnOpenAdmin.Opacity        = 0.8
    }
}

# Init Nilai UI
$lanIpText.Text  = $lanIp
$lanUrlText.Text = $baseUrl
Update-BranchBadge
$initDocker = Update-DockerBadge
$initPort   = Test-PortFast 8000
Update-ServerStatus $initPort

# Initial Logs
Write-GuiLog "Dezzly Studio Controller aktif." "SISTEM"
Write-GuiLog "Folder Proyek: $projectRoot" "INFO"
Write-GuiLog "IP LAN Utama (Wi-Fi): $lanIp" "JARINGAN"
Write-GuiLog "Link Akses untuk Perangkat Lain: $baseUrl" "JARINGAN"
Write-GuiLog "Branch Git Aktif: $(Get-CurrentGitBranch)" "GIT"
if ($initDocker) {
    Write-GuiLog "Engine Docker Desktop terdeteksi AKTIF." "DOCKER"
} else {
    Write-GuiLog "Engine Docker Desktop belum aktif. Anda bisa menggunakan 'NYALAKAN PHP SERVE' atau buka Docker Desktop." "INFO"
}
if ($initPort) {
    Write-GuiLog "Port 8000 terdeteksi SUDAH AKTIF melayani koneksi." "SERVER"
} else {
    Write-GuiLog "Port 8000 siap dinyalakan." "SERVER"
}

# -----------------------------------------------------------------------
# DISPATCHER TIMER: Real-time Background Polling (Setiap 3 Detik)
# Menjamin UX Tombol & Badge Selalu Sinkron 100% dengan Kondisi Nyata
# -----------------------------------------------------------------------
$timer = New-Object System.Windows.Threading.DispatcherTimer
$timer.Interval = [TimeSpan]::FromSeconds(3)
$timer.Add_Tick({
    $isListening = Test-PortFast 8000
    Update-ServerStatus $isListening
})
$timer.Start()

# -----------------------------------------------------------------------
# EVENT HANDLERS
# -----------------------------------------------------------------------

# Klik Badge Docker: Re-check atau Buka Docker Desktop
$dockerBadge.Add_MouseLeftButtonUp({
    $isUp = Update-DockerBadge
    if ($isUp) {
        Write-GuiLog "Engine Docker Desktop aktif dan siap digunakan." "DOCKER"
        [System.Windows.MessageBox]::Show("Engine Docker Desktop AKTIF dan siap menjalankan container.", "Status Docker", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Information) | Out-Null
    } else {
        $ask = [System.Windows.MessageBox]::Show(
            "Engine Docker Desktop belum berjalan.`n`nApakah Anda ingin membuka aplikasi Docker Desktop sekarang di Windows?",
            "Buka Docker Desktop",
            [System.Windows.MessageBoxButton]::YesNo,
            [System.Windows.MessageBoxImage]::Question
        )
        if ($ask -eq [System.Windows.MessageBoxResult]::Yes) {
            $dockerApp = "C:\Program Files\Docker\Docker\Docker Desktop.exe"
            if (Test-Path $dockerApp) {
                Start-Process $dockerApp
                Write-GuiLog "Membuka aplikasi Docker Desktop... Harap tunggu engine siap." "DOCKER"
            } else {
                Write-GuiLog "File Docker Desktop.exe tidak ditemukan di direktori standar." "PERINGATAN"
            }
        }
    }
})

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

# -----------------------------------------------------------------------
# ENGINE 1: NYALAKAN VIA DOCKER (DENGAN SMART FALLBACK UX)
# -----------------------------------------------------------------------
$btnDockerUp.Add_Click({
    # Cek apakah port sudah aktif
    if (Test-PortFast 8000) {
        Write-GuiLog "Server sudah aktif di port 8000! Anda bisa langsung membuka website." "INFO"
        Update-ServerStatus $true
        return
    }

    $txtDockerUpTitle.Text = "[ MEMULAI... ]"
    $txtDockerUpSub.Text   = "Memeriksa Engine..."
    [System.Windows.Forms.Application]::DoEvents()

    # Cek Docker Engine Sebenarnya
    $daemonReady = Test-DockerDaemonFast

    if (-not $daemonReady) {
        Update-DockerBadge
        $txtDockerUpTitle.Text = "[ NYALAKAN DOCKER ]"
        $txtDockerUpSub.Text   = "Container (Port 8000)"
        Write-GuiLog "Docker Engine belum berjalan di komputer ini." "PERHATIAN"

        # Dialog Pilihan UX yang Sangat Membantu User
        $choice = [System.Windows.MessageBox]::Show(
            "Engine Docker Desktop belum aktif di komputer Anda.`n`nPILIHAN CEPAT:`n• Klik 'Yes' untuk menjalankan SERVER CEPAT PHP (Port 8000) langsung tanpa Docker.`n• Klik 'No' untuk membuka aplikasi Docker Desktop.`n• Klik 'Cancel' untuk membatalkan.",
            "Docker Engine Belum Aktif",
            [System.Windows.MessageBoxButton]::YesNoCancel,
            [System.Windows.MessageBoxImage]::Question
        )

        if ($choice -eq [System.Windows.MessageBoxResult]::Yes) {
            # Jalankan Mode PHP Built-in
            Write-GuiLog "Menjalankan Server PHP Built-in di port 8000 (Mode Ringan)..." "PROSES"
            Start-Process -FilePath "php" -ArgumentList "artisan serve --host=0.0.0.0 --port=8000" -WorkingDirectory $projectRoot -WindowStyle Hidden
            Start-Sleep -Milliseconds 1200
            if (Test-PortFast 8000) {
                Update-ServerStatus $true "PHP"
                Write-GuiLog "SUKSES: Server PHP aktif di $baseUrl (Lokal & Wi-Fi)" "SUKSES"
            } else {
                Write-GuiLog "Gagal menyalakan server PHP. Periksa terminal atau port." "ERROR"
            }
            return
        } elseif ($choice -eq [System.Windows.MessageBoxResult]::No) {
            $dockerApp = "C:\Program Files\Docker\Docker\Docker Desktop.exe"
            if (Test-Path $dockerApp) {
                Start-Process $dockerApp
                Write-GuiLog "Membuka Docker Desktop... Harap tunggu engine siap (1-2 menit), lalu klik tombol ini lagi." "DOCKER"
            } else {
                Write-GuiLog "Aplikasi Docker Desktop tidak ditemukan." "ERROR"
            }
            return
        } else {
            return
        }
    }

    # Jika Docker Engine Aktif
    Write-GuiLog "Menyalakan container Docker (docker compose up -d)..." "PROSES"
    $txtDockerUpTitle.Text = "[ MEMULAI CONTAINER... ]"
    [System.Windows.Forms.Application]::DoEvents()

    $out = docker compose up -d 2>&1
    Write-GuiLog ($out -join "`r`n") "DOCKER"

    # Verifikasi konektivitas riil port 8000 (polling hingga 6 detik)
    $started = $false
    for ($i = 0; $i -lt 6; $i++) {
        Start-Sleep -Seconds 1
        if (Test-PortFast 8000) {
            $started = $true
            break
        }
    }

    if ($started) {
        Update-DockerBadge
        Update-ServerStatus $true "DOCKER"
        Write-GuiLog "SUKSES: Container Docker aktif dan merespon di $baseUrl" "SUKSES"
    } else {
        Update-ServerStatus $false
        Write-GuiLog "PERINGATAN: Container belum merespon di port 8000. Cek Docker Desktop." "PERHATIAN"
    }
})

# -----------------------------------------------------------------------
# ENGINE 2: NYALAKAN VIA PHP NATIVE (INSTAN, TANPA DOCKER, HEMAT RAM)
# -----------------------------------------------------------------------
$btnPhpServe.Add_Click({
    if (Test-PortFast 8000) {
        Write-GuiLog "Server sudah aktif di port 8000!" "INFO"
        Update-ServerStatus $true
        return
    }

    $txtPhpServeTitle.Text = "[ MEMULAI... ]"
    [System.Windows.Forms.Application]::DoEvents()

    Write-GuiLog "Menjalankan PHP Artisan Serve di 0.0.0.0:8000..." "PROSES"
    Start-Process -FilePath "php" -ArgumentList "artisan serve --host=0.0.0.0 --port=8000" -WorkingDirectory $projectRoot -WindowStyle Hidden
    
    # Tunggu dan verifikasi port 8000
    Start-Sleep -Milliseconds 1400
    if (Test-PortFast 8000) {
        Update-ServerStatus $true "PHP ARTISAN"
        Write-GuiLog "SUKSES: Server PHP Artisan aktif di $baseUrl (Siap Diakses HP & Lokal)" "SUKSES"
    } else {
        Update-ServerStatus $false
        Write-GuiLog "Gagal menyalakan PHP server. Pastikan PHP 8.4 terpasang di sistem." "ERROR"
    }
})

# -----------------------------------------------------------------------
# MATIKAN SERVER (BERSIHKAN CONTAINER DOCKER & PROSES PHP)
# -----------------------------------------------------------------------
$btnDockerDown.Add_Click({
    $txtDockerDownTitle.Text = "[ MEMATIKAN... ]"
    [System.Windows.Forms.Application]::DoEvents()

    Write-GuiLog "Menghentikan seluruh proses server (Docker & PHP)..." "PROSES"

    # Stop Docker jika ada
    if (Get-Command "docker" -ErrorAction SilentlyContinue) {
        $daemonUp = Test-DockerDaemonFast
        if ($daemonUp) {
            $out = docker compose down 2>&1
            Write-GuiLog ($out -join "`r`n") "DOCKER"
        }
    }

    # Stop proses PHP Artisan Serve
    Get-Process -Name "php" -ErrorAction SilentlyContinue | Where-Object {
        $_.MainWindowTitle -eq ""
    } | Stop-Process -Force -ErrorAction SilentlyContinue

    Start-Sleep -Milliseconds 800

    if (-not (Test-PortFast 8000)) {
        Update-ServerStatus $false
        Write-GuiLog "SUKSES: Server port 8000 berhasil dinonaktifkan." "SELESAI"
    } else {
        # Force terminate port jika masih ada yang mengikat
        $netstat = Get-NetTCPConnection -LocalPort 8000 -State Listen -ErrorAction SilentlyContinue
        if ($netstat) {
            Stop-Process -Id $netstat.OwningProcess -Force -ErrorAction SilentlyContinue
        }
        Update-ServerStatus $false
        Write-GuiLog "Server berhasil dihentikan." "SELESAI"
    }
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

# -----------------------------------------------------------------------
# PIPELINE FUNCTIONS (DIPAKAI OLEH TOMBOL DEPLOY & TOMBOL FASE)
# -----------------------------------------------------------------------
function Invoke-DevDeploy {
    if (-not (Switch-GitBranch "development")) { return $false }

    Write-GuiLog "Menyimpan perubahan ke branch DEVELOPMENT..." "DEV DEPLOY"
    git add . 2>&1 | Out-Null

    $status = git status --porcelain 2>&1
    if ([string]::IsNullOrWhiteSpace(($status | Out-String))) {
        Write-GuiLog "Tidak ada perubahan file baru untuk di-commit." "INFO"
    } else {
        $msg = "dev update: " + (Get-Date -Format "dd-MM-yyyy HH:mm")
        $commitExit = Invoke-GuiProcess "Commit perubahan development..." "git" @("commit", "-m", $msg) "GIT"
        if ($commitExit -ne 0) { return $false }
    }

    $pushExit = Invoke-GuiProcess "Push ke origin/development..." "git" @("push", "origin", "development") "DEV DEPLOY"
    if ($pushExit -ne 0) { return $false }

    Write-GuiLog "BERHASIL: Perubahan tersimpan di branch 'development'. Hosting live production aman!" "SUKSES"
    Update-BranchBadge
    return $true
}

function Invoke-QualityGate {
    Write-GuiLog "Menjalankan Quality Gate: style, analisis statis, test, dan audit keamanan..." "QUALITY"
    $failed = @()

    if ((Invoke-GuiProcess "Pint style check..." "php" @("vendor/bin/pint", "--test", "--format", "agent") "QUALITY") -ne 0) { $failed += "Pint" }
    if ((Invoke-GuiProcess "Larastan static analysis..." "php" @("vendor/bin/phpstan", "analyse", "--no-progress", "--memory-limit=1G") "QUALITY") -ne 0) { $failed += "Larastan" }
    if ((Invoke-GuiProcess "PHPUnit test suite..." "php" @("artisan", "test", "--compact") "TEST") -ne 0) { $failed += "PHPUnit" }
    if ((Invoke-GuiProcess "Composer security audit..." "composer" @("audit", "--no-interaction") "SECURITY") -ne 0) { $failed += "Composer Audit" }
    if ((Invoke-GuiProcess "NPM security audit..." "npm" @("audit", "--omit=dev", "--audit-level=high") "SECURITY") -ne 0) { $failed += "NPM Audit" }

    if ($failed.Count -gt 0) {
        Write-GuiLog ("GAGAL: Quality Gate tidak lolos. Komponen bermasalah: " + ($failed -join ", ")) "ERROR"
        [System.Windows.MessageBox]::Show(
            "Quality Gate tidak lolos.`n`nKomponen bermasalah: " + ($failed -join ", "),
            "Quality Gate Gagal",
            [System.Windows.MessageBoxButton]::OK,
            [System.Windows.MessageBoxImage]::Error
        ) | Out-Null
        return $false
    }

    Write-GuiLog "LOLOS: Seluruh Quality Gate berhasil." "SUKSES"
    return $true
}

function Invoke-SetupEnvironment {
    Write-GuiLog "Memulai Fase SETUP environment..." "SETUP"

    if ((Invoke-GuiProcess "Composer install..." "composer" @("install", "--no-interaction") "SETUP") -ne 0) { return $false }
    if (-not (Ensure-EnvironmentFile)) { return $false }
    if ((Invoke-GuiProcess "Migrasi database..." "php" @("artisan", "migrate", "--force") "DATABASE") -ne 0) { return $false }
    if ((Invoke-GuiProcess "NPM install..." "npm" @("install") "SETUP") -ne 0) { return $false }
    if ((Invoke-GuiProcess "Build aset produksi..." "npm" @("run", "build") "BUILD") -ne 0) { return $false }

    Write-GuiLog "SELESAI: Environment siap digunakan." "SUKSES"
    return $true
}

function Invoke-StagingDeploy {
    if (-not (Test-GitBranchExists "staging")) {
        Write-GuiLog "Branch 'staging' belum ada. Membuat dari 'development'..." "STAGING"
        $createExit = Invoke-GuiProcess "Membuat branch staging..." "git" @("branch", "staging", "development") "GIT"
        if ($createExit -ne 0) { return $false }
    }

    if (-not (Switch-GitBranch "staging")) { return $false }

    $mergeExit = Invoke-GuiProcess "Merge development ke staging..." "git" @("merge", "development") "STAGING"
    if ($mergeExit -ne 0) {
        Write-GuiLog "Konflik merge terdeteksi. Membatalkan merge..." "ERROR"
        git merge --abort 2>&1 | Out-Null
        Switch-GitBranch "development" | Out-Null
        return $false
    }

    $pushExit = Invoke-GuiProcess "Push ke origin/staging..." "git" @("push", "origin", "staging") "STAGING"
    Switch-GitBranch "development" | Out-Null
    if ($pushExit -ne 0) { return $false }

    Write-GuiLog "SELESAI: Staging diperbarui. Lakukan uji coba sebelum rilis production." "SUKSES"
    return $true
}

function Invoke-ProductionRelease {
    if (-not (Test-GitBranchExists "production")) {
        Write-GuiLog "GAGAL: Branch 'production' belum ada. Buat branch production terlebih dahulu." "ERROR"
        return $false
    }

    Write-GuiLog "Memulai pipeline rilis PRODUCTION..." "PROD PIPELINE"

    if (-not (Invoke-QualityGate)) {
        Write-GuiLog "Rilis production dibatalkan karena Quality Gate gagal." "ERROR"
        return $false
    }

    if ((Invoke-GuiProcess "Build aset produksi..." "npm" @("run", "build") "BUILD") -ne 0) {
        return $false
    }

    if (-not (Switch-GitBranch "production")) { return $false }

    $mergeExit = Invoke-GuiProcess "Merge development ke production..." "git" @("merge", "development") "GIT"
    if ($mergeExit -ne 0) {
        Write-GuiLog "Konflik merge terdeteksi. Membatalkan merge..." "ERROR"
        git merge --abort 2>&1 | Out-Null
        Switch-GitBranch "development" | Out-Null
        return $false
    }

    $pushExit = Invoke-GuiProcess "Push ke origin/production..." "git" @("push", "origin", "production") "GIT"
    Switch-GitBranch "development" | Out-Null
    if ($pushExit -ne 0) { return $false }

    Write-GuiLog "SELESAI: Versi terbaru berhasil dirilis ke Hosting Live PRODUCTION!" "SUKSES"
    return $true
}

function Invoke-HotfixBranch {
    $base = if (Test-GitBranchExists "production") { "production" } else { "development" }
    $name = "hotfix/" + (Get-Date -Format "yyyyMMdd-HHmm")

    $exitCode = Invoke-GuiProcess "Membuat branch $name dari $base..." "git" @("checkout", "-b", $name, $base) "HOTFIX"
    Update-BranchBadge
    if ($exitCode -ne 0) { return $false }

    Write-GuiLog "Branch hotfix '$name' siap. Lakukan perbaikan, commit, lalu merge ke production." "HOTFIX"
    return $true
}

# DEPLOY DEV: Commit & Push ke branch development
$btnDeployDev.Add_Click({
    Invoke-DevDeploy | Out-Null
})

# DEPLOY PROD: Quality Gate, Build, Merge ke production & Push
$btnDeployProd.Add_Click({
    $confirmed = Confirm-GuiAction "Apakah Anda yakin ingin merilis ke PRODUCTION (Hosting Live)?`n`nSistem akan menjalankan: Quality Gate (Pint, Larastan, PHPUnit, audit), build Vite, lalu merge & push ke branch 'production'." "Konfirmasi Rilis Produksi"
    if (-not $confirmed) {
        Write-GuiLog "Rilis ke production dibatalkan oleh user." "INFO"
        return
    }

    if (Invoke-ProductionRelease) {
        [System.Windows.MessageBox]::Show("Rilis Production Berhasil!`nWebsite live di hosting telah diperbarui dengan versi terbaru.", "Rilis Berhasil", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Information) | Out-Null
    } else {
        [System.Windows.MessageBox]::Show("Rilis production dibatalkan atau gagal. Periksa log untuk detailnya.", "Rilis Dibatalkan", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Error) | Out-Null
    }
})

# Pindah ke branch development
$btnSwitchDev.Add_Click({
    Switch-GitBranch "development" | Out-Null
})

# Pindah ke branch production
$btnSwitchProd.Add_Click({
    Switch-GitBranch "production" | Out-Null
})

# -----------------------------------------------------------------------
# TOMBOL FASE PENGEMBANGAN
# -----------------------------------------------------------------------
$btnPhaseSetup.Add_Click({
    $confirmed = Confirm-GuiAction "Fase SETUP akan menjalankan composer install, menyiapkan .env, migrasi database, npm install, dan build aset. Lanjutkan?" "Konfirmasi Fase Setup"
    if (-not $confirmed) {
        Write-GuiLog "Fase SETUP dibatalkan oleh user." "INFO"
        return
    }

    if (Invoke-SetupEnvironment) {
        [System.Windows.MessageBox]::Show("Fase Setup selesai. Environment siap digunakan.", "Setup Berhasil", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Information) | Out-Null
    } else {
        [System.Windows.MessageBox]::Show("Fase Setup gagal. Periksa log untuk detailnya.", "Setup Gagal", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Error) | Out-Null
    }
})

$btnPhaseDev.Add_Click({
    Invoke-DevDeploy | Out-Null
})

$btnPhaseQuality.Add_Click({
    Invoke-QualityGate | Out-Null
})

$btnPhaseStaging.Add_Click({
    $confirmed = Confirm-GuiAction "Fase STAGING akan merge branch 'development' ke 'staging' dan push ke origin/staging. Lanjutkan?" "Konfirmasi Fase Staging"
    if (-not $confirmed) {
        Write-GuiLog "Fase STAGING dibatalkan oleh user." "INFO"
        return
    }

    if (Invoke-StagingDeploy) {
        [System.Windows.MessageBox]::Show("Staging berhasil diperbarui. Silakan lakukan uji coba sebelum rilis production.", "Staging Berhasil", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Information) | Out-Null
    } else {
        [System.Windows.MessageBox]::Show("Deploy staging gagal. Periksa log untuk detailnya.", "Staging Gagal", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Error) | Out-Null
    }
})

$btnPhaseProd.Add_Click({
    $confirmed = Confirm-GuiAction "Fase PRODUCTION akan menjalankan Quality Gate, build aset, lalu merge & push ke branch 'production' (hosting live). Lanjutkan?" "Konfirmasi Fase Production"
    if (-not $confirmed) {
        Write-GuiLog "Fase PRODUCTION dibatalkan oleh user." "INFO"
        return
    }

    if (Invoke-ProductionRelease) {
        [System.Windows.MessageBox]::Show("Rilis Production Berhasil!`nWebsite live di hosting telah diperbarui.", "Rilis Berhasil", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Information) | Out-Null
    } else {
        [System.Windows.MessageBox]::Show("Rilis production dibatalkan atau gagal. Periksa log untuk detailnya.", "Rilis Dibatalkan", [System.Windows.MessageBoxButton]::OK, [System.Windows.MessageBoxImage]::Error) | Out-Null
    }
})

$btnPhaseHotfix.Add_Click({
    $confirmed = Confirm-GuiAction "Fase HOTFIX akan membuat branch hotfix baru dari branch production. Lanjutkan?" "Konfirmasi Fase Hotfix"
    if (-not $confirmed) {
        Write-GuiLog "Fase HOTFIX dibatalkan oleh user." "INFO"
        return
    }

    Invoke-HotfixBranch | Out-Null
})

# Migrate & Seed
$btnMigrateSeed.Add_Click({
    $confirmed = Confirm-GuiAction "Refresh database akan MENGHAPUS SELURUH DATA dan mengisi ulang data seeder. Tindakan ini tidak dapat dibatalkan. Lanjutkan?" "Konfirmasi Refresh Database"
    if (-not $confirmed) {
        Write-GuiLog "Refresh database dibatalkan oleh user." "INFO"
        return
    }

    $exitCode = Invoke-GuiProcess "Menjalankan migrate:fresh --seed..." "php" @("artisan", "migrate:fresh", "--seed", "--force") "DATABASE"
    if ($exitCode -eq 0) {
        Write-GuiLog "Database berhasil di-refresh dengan data dummy terbaru." "SUKSES"
    }
})

# Build Vite
$btnBuildProd.Add_Click({
    Invoke-GuiProcess "Mengompilasi aset frontend dengan Vite..." "npm" @("run", "build") "BUILD" | Out-Null
})

# Clear Cache
$btnClearCache.Add_Click({
    Invoke-GuiProcess "Membersihkan cache Laravel (Config, Route, View)..." "php" @("artisan", "optimize:clear") "CACHE" | Out-Null
})

# Run Tests
$btnRunTests.Add_Click({
    Invoke-GuiProcess "Menjalankan test suite PHPUnit..." "php" @("artisan", "test", "--compact") "TEST" | Out-Null
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

# Tampilkan GUI
$window.ShowDialog() | Out-Null
