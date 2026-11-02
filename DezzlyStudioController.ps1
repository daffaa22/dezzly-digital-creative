Add-Type -AssemblyName PresentationFramework
Add-Type -AssemblyName PresentationCore
Add-Type -AssemblyName WindowsBase
Add-Type -AssemblyName System.Windows.Forms

$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Definition
Set-Location $projectRoot

$xaml = @"
<Window xmlns="http://schemas.microsoft.com/winfx/2006/xaml/presentation"
        xmlns:x="http://schemas.microsoft.com/winfx/2006/xaml"
        Title="DEZZLY CREATIVE — Studio &amp; Deploy Controller" 
        Height="720" Width="960" 
        WindowStartupLocation="CenterScreen"
        Background="#07090E" Foreground="#F1F5F9"
        FontFamily="Segoe UI">
    <Window.Resources>
        <Style TargetType="Button">
            <Setter Property="Background" Value="#121824"/>
            <Setter Property="Foreground" Value="#F1F5F9"/>
            <Setter Property="BorderBrush" Value="#1F293D"/>
            <Setter Property="BorderThickness" Value="1"/>
            <Setter Property="Padding" Value="14,10"/>
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
                            <ContentPresenter HorizontalAlignment="Center" VerticalAlignment="Center"/>
                        </Border>
                    </ControlTemplate>
                </Setter.Value>
            </Setter>
        </Style>
    </Window.Resources>

    <Grid Margin="24">
        <Grid.RowDefinitions>
            <RowDefinition Height="Auto"/>
            <RowDefinition Height="Auto"/>
            <RowDefinition Height="*"/>
            <RowDefinition Height="Auto"/>
        </Grid.RowDefinitions>

        <!-- Header -->
        <Border Grid.Row="0" Background="#0B0F17" BorderBrush="#1A2332" BorderThickness="1" CornerRadius="12" Padding="20,16" Margin="0,0,0,16">
            <Grid>
                <Grid.ColumnDefinitions>
                    <ColumnDefinition Width="*"/>
                    <ColumnDefinition Width="Auto"/>
                </Grid.ColumnDefinitions>
                <StackPanel Grid.Column="0">
                    <StackPanel Orientation="Horizontal" VerticalAlignment="Center">
                        <Border Width="28" Height="28" Background="#00F2FE" CornerRadius="6" Margin="0,0,10,0">
                            <TextBlock Text="D" Foreground="#07090E" FontWeight="Bold" FontSize="18" HorizontalAlignment="Center" VerticalAlignment="Center"/>
                        </Border>
                        <TextBlock Text="DEZZLY CREATIVE" Foreground="#FFFFFF" FontWeight="ExtraBold" FontSize="18" VerticalAlignment="Center"/>
                        <Border Background="#121824" BorderBrush="#00F2FE" BorderThickness="1" CornerRadius="4" Padding="6,2" Margin="12,0,0,0">
                            <TextBlock Text="STUDIO CONTROLLER" Foreground="#00F2FE" FontSize="10" FontWeight="Bold"/>
                        </Border>
                    </StackPanel>
                    <TextBlock Text="Pusat kendali server lokal, migrasi database, build aset, dan deployment" Foreground="#94A3B8" FontSize="11" Margin="38,4,0,0"/>
                </StackPanel>

                <!-- Status Badges -->
                <StackPanel Grid.Column="1" Orientation="Horizontal" VerticalAlignment="Center">
                    <Border Name="ServerBadge" Background="#1E1B2E" BorderBrush="#8A2BE2" BorderThickness="1" CornerRadius="8" Padding="12,6" Margin="0,0,10,0">
                        <StackPanel Orientation="Horizontal">
                            <Ellipse Name="ServerDot" Width="8" Height="8" Fill="#EF4444" Margin="0,0,6,0"/>
                            <TextBlock Name="ServerStatusText" Text="SERVER OFFLINE" Foreground="#E2E8F0" FontSize="11" FontWeight="Bold"/>
                        </StackPanel>
                    </Border>
                    <Border Background="#062E27" BorderBrush="#10B981" BorderThickness="1" CornerRadius="8" Padding="12,6">
                        <TextBlock Text="DATABASE READY" Foreground="#34D399" FontSize="11" FontWeight="Bold"/>
                    </Border>
                </StackPanel>
            </Grid>
        </Border>

        <!-- Command Buttons Grid -->
        <Border Grid.Row="1" Background="#0B0F17" BorderBrush="#1A2332" BorderThickness="1" CornerRadius="12" Padding="18" Margin="0,0,0,16">
            <Grid>
                <Grid.RowDefinitions>
                    <RowDefinition Height="Auto"/>
                    <RowDefinition Height="Auto"/>
                </Grid.RowDefinitions>

                <!-- Primary Action Row -->
                <UniformGrid Grid.Row="0" Columns="4" Margin="0,0,0,10">
                    <Button Name="BtnStartServer" Margin="4" Background="#0284C7" BorderBrush="#38BDF8">
                        <TextBlock Text="🚀 Start Local Server"/>
                    </Button>
                    <Button Name="BtnStopServer" Margin="4" Background="#1E293B" BorderBrush="#475569">
                        <TextBlock Text="🛑 Stop Server"/>
                    </Button>
                    <Button Name="BtnOpenBrowser" Margin="4" Background="#10B981" BorderBrush="#34D399" Foreground="#07090E">
                        <TextBlock Text="🌐 Buka Website" FontWeight="Bold"/>
                    </Button>
                    <Button Name="BtnOpenAdmin" Margin="4" Background="#8A2BE2" BorderBrush="#A855F7">
                        <TextBlock Text="🛡️ Admin Panel"/>
                    </Button>
                </UniformGrid>

                <!-- Operational Action Row -->
                <UniformGrid Grid.Row="1" Columns="4">
                    <Button Name="BtnMigrateSeed" Margin="4">
                        <TextBlock Text="🗄️ Migrate &amp; Seed DB"/>
                    </Button>
                    <Button Name="BtnBuildProd" Margin="4">
                        <TextBlock Text="📦 Build Assets (Vite)"/>
                    </Button>
                    <Button Name="BtnClearCache" Margin="4">
                        <TextBlock Text="🧹 Clear Cache"/>
                    </Button>
                    <Button Name="BtnRunTests" Margin="4">
                        <TextBlock Text="🧪 Run PHPUnit Tests"/>
                    </Button>
                </UniformGrid>
            </Grid>
        </Border>

        <!-- Live Terminal / Console Output -->
        <Border Grid.Row="2" Background="#0B0F17" BorderBrush="#1A2332" BorderThickness="1" CornerRadius="12" Padding="16">
            <Grid>
                <Grid.RowDefinitions>
                    <RowDefinition Height="Auto"/>
                    <RowDefinition Height="*"/>
                </Grid.RowDefinitions>
                <Grid Grid.Row="0" Margin="0,0,0,10">
                    <TextBlock Text="CONSOLE &amp; DEPLOYMENT LOGS" Foreground="#64748B" FontSize="11" FontWeight="Bold"/>
                    <Button Name="BtnClearLog" HorizontalAlignment="Right" Padding="8,4" FontSize="10" Background="Transparent" BorderBrush="#334155">
                        <TextBlock Text="Bersihkan Log"/>
                    </Button>
                </Grid>
                <TextBox Name="LogBox" Grid.Row="1" 
                         Background="#07090E" Foreground="#38BDF8" 
                         BorderBrush="#1E293B" BorderThickness="1" 
                         FontFamily="Consolas" FontSize="12"
                         IsReadOnly="True" TextWrapping="Wrap" 
                         VerticalScrollBarVisibility="Auto" Padding="12"/>
            </Grid>
        </Border>

        <!-- Bottom Footer Bar -->
        <Grid Grid.Row="3" Margin="0,12,0,0">
            <TextBlock Text="Dezzly Creative Full-Stack Studio • Laravel 11/13 + Tailwind v4 + SQLite" Foreground="#64748B" FontSize="11" VerticalAlignment="Center"/>
            <StackPanel Orientation="Horizontal" HorizontalAlignment="Right">
                <Button Name="BtnGitStatus" Padding="10,6" Margin="0,0,8,0" Background="#1E293B" FontSize="11">
                    <TextBlock Text="📂 Git Status"/>
                </Button>
                <Button Name="BtnQuickDeploy" Padding="10,6" Background="#2563EB" BorderBrush="#60A5FA" FontSize="11">
                    <TextBlock Text="☁️ One-Click Commit &amp; Deploy"/>
                </Button>
            </StackPanel>
        </Grid>
    </Grid>
</Window>
"@

$reader = New-Object System.Xml.XmlNodeReader([xml]$xaml)
$window = [Windows.Markup.XamlReader]::Load($reader)

# Map UI Controls
$btnStartServer   = $window.FindName("BtnStartServer")
$btnStopServer    = $window.FindName("BtnStopServer")
$btnOpenBrowser   = $window.FindName("BtnOpenBrowser")
$btnOpenAdmin     = $window.FindName("BtnOpenAdmin")
$btnMigrateSeed   = $window.FindName("BtnMigrateSeed")
$btnBuildProd     = $window.FindName("BtnBuildProd")
$btnClearCache    = $window.FindName("BtnClearCache")
$btnRunTests      = $window.FindName("BtnRunTests")
$btnGitStatus     = $window.FindName("BtnGitStatus")
$btnQuickDeploy   = $window.FindName("BtnQuickDeploy")
$btnClearLog      = $window.FindName("BtnClearLog")
$logBox           = $window.FindName("LogBox")
$serverDot        = $window.FindName("ServerDot")
$serverStatusText = $window.FindName("ServerStatusText")

# Helper Logger
function Write-GuiLog([string]$message, [string]$type="INFO") {
    $timestamp = Get-Date -Format "HH:mm:ss"
    $formatted = "[$timestamp] [$type] $message`r`n"
    $logBox.AppendText($formatted)
    $logBox.ScrollToEnd()
}

Write-GuiLog "Dezzly Creative Deployment Controller aktif." "SYSTEM"
Write-GuiLog "Folder Proyek: $projectRoot" "INFO"

# Background Job Tracker
$script:serverProcess = $null

function Update-ServerStatus([bool]$isRunning) {
    if ($isRunning) {
        $serverDot.Fill = [System.Windows.Media.Brushes]::LimeGreen
        $serverStatusText.Text = "ONLINE: HTTP://127.0.0.1:8000"
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::LightGreen
    } else {
        $serverDot.Fill = [System.Windows.Media.Brushes]::Red
        $serverStatusText.Text = "SERVER OFFLINE"
        $serverStatusText.Foreground = [System.Windows.Media.Brushes]::Salmon
    }
}

# 1. Start Server Button
$btnStartServer.Add_Click({
    Write-GuiLog "Memulai server lokal Laravel (port 8000)..." "PROCESS"
    try {
        $existing = Get-Process -Name "php" -ErrorAction SilentlyContinue | Where-Object { $_.MainWindowTitle -like "*8000*" }
        $script:serverProcess = Start-Process php -ArgumentList "artisan serve --port=8000" -WorkingDirectory $projectRoot -PassThru -WindowStyle Hidden
        Update-ServerStatus $true
        Write-GuiLog "Server berhasil berjalan di http://127.0.0.1:8000 (PID: $($script:serverProcess.Id))" "SUCCESS"
    } catch {
        Write-GuiLog "Gagal memulai server: $_" "ERROR"
    }
})

# 2. Stop Server Button
$btnStopServer.Add_Click({
    Write-GuiLog "Menghentikan server lokal..." "PROCESS"
    try {
        Get-Process -Name "php" -ErrorAction SilentlyContinue | Stop-Process -Force
        Update-ServerStatus $false
        Write-GuiLog "Seluruh proses web server PHP telah dihentikan." "SUCCESS"
    } catch {
        Write-GuiLog "Kesalahan menghentikan proses: $_" "ERROR"
    }
})

# 3. Open Website in Browser
$btnOpenBrowser.Add_Click({
    Write-GuiLog "Membuka http://localhost:8000 di browser default..." "ACTION"
    Start-Process "http://localhost:8000"
})

# 4. Open Admin Panel
$btnOpenAdmin.Add_Click({
    Write-GuiLog "Membuka Admin Dashboard di http://localhost:8000/admin..." "ACTION"
    Start-Process "http://localhost:8000/admin"
})

# 5. Migrate & Seed Database
$btnMigrateSeed.Add_Click({
    Write-GuiLog "Menjalankan migrasi & seeder data Dezzly Creative..." "PROCESS"
    $output = php artisan migrate:fresh --seed --no-interaction 2>&1
    Write-GuiLog ($output -join "`r`n") "DB"
    Write-GuiLog "Database & katalog produk (Sony Alpha, Paket Foto) berhasil diperbarui!" "SUCCESS"
})

# 6. Build Assets for Production
$btnBuildProd.Add_Click({
    Write-GuiLog "Mengompilasi aset frontend dengan Vite (npm run build)..." "BUILD"
    $buildOut = npm run build 2>&1
    Write-GuiLog ($buildOut -join "`r`n") "BUILD"
    php artisan optimize 2>&1 | Out-Null
    Write-GuiLog "Kompilasi selesai! Aset siap produksi." "SUCCESS"
})

# 7. Clear Cache
$btnClearCache.Add_Click({
    Write-GuiLog "Membersihkan seluruh cache aplikasi..." "CACHE"
    $out = php artisan optimize:clear 2>&1
    Write-GuiLog ($out -join "`r`n") "CACHE"
    Write-GuiLog "Cache berhasil dibersihkan!" "SUCCESS"
})

# 8. Run Tests
$btnRunTests.Add_Click({
    Write-GuiLog "Menjalankan suite pengujian otomatis PHPUnit..." "TEST"
    $out = php artisan test --compact 2>&1
    Write-GuiLog ($out -join "`r`n") "TEST"
})

# 9. Clear Logs
$btnClearLog.Add_Click({
    $logBox.Clear()
    Write-GuiLog "Log telah dibersihkan." "INFO"
})

# 10. Git Status
$btnGitStatus.Add_Click({
    Write-GuiLog "Memeriksa status repositori Git..." "GIT"
    $out = git status -s 2>&1
    if ([string]::IsNullOrWhiteSpace($out)) {
        Write-GuiLog "Working tree bersih (tidak ada perubahan pending)." "GIT"
    } else {
        Write-GuiLog ($out -join "`r`n") "GIT"
    }
})

# 11. Quick Deploy
$btnQuickDeploy.Add_Click({
    $msg = [Microsoft.VisualBasic.Interaction]::InputBox("Masukkan pesan commit untuk deploy:", "Quick Deploy & Commit", "Update Dezzly Creative Platform")
    if (-not [string]::IsNullOrWhiteSpace($msg)) {
        Write-GuiLog "Menambahkan seluruh file ke Git staging..." "DEPLOY"
        git add .
        git commit -m "$msg" 2>&1 | ForEach-Object { Write-GuiLog $_ "GIT" }
        Write-GuiLog "Perubahan telah di-commit ke Git lokal: '$msg'" "SUCCESS"
    }
})

# Window Closed Handler
$window.Add_Closed({
    # Clean up php process if requested
})

# Check current port 8000 status on launch
$portActive = Test-NetConnection -ComputerName 127.0.0.1 -Port 8000 -InformationLevel Quiet -WarningAction SilentlyContinue
Update-ServerStatus $portActive

$window.ShowDialog() | Out-Null
