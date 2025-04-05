# Create wp-cli directory if it doesn't exist
New-Item -ItemType Directory -Force -Path C:\wp-cli

# Download WP-CLI
Invoke-WebRequest -Uri https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar -OutFile C:\wp-cli\wp-cli.phar

# Create wp.bat
@"
@ECHO OFF
php "C:\wp-cli\wp-cli.phar" %*
"@ | Out-File -Encoding ASCII C:\wp-cli\wp.bat

# Add to user's PATH
$userPath = [Environment]::GetEnvironmentVariable("Path", "User")
if ($userPath -notlike "*C:\wp-cli*") {
    [Environment]::SetEnvironmentVariable("Path", $userPath + ";C:\wp-cli", "User")
}

Write-Host "WP-CLI has been installed. Please restart your PowerShell window and try 'wp --info'" 