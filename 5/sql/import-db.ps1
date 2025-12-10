# Import qlbh_xe.sql into local MySQL/MariaDB
# Usage: Run in PowerShell as admin
# Example:
#   .\import-db.ps1 -User root -Password "" -Database qlbh_xe -SqlFile "C:\xampp\htdocs\FProjects\5\sql\qlbh_xe.sql"
param(
    [string]$User = 'root',
    [string]$Password = '',
    [string]$Database = 'qlbh_xe',
    [string]$SqlFile = "${PWD}\qlbh_xe.sql"
)

$mysql = "mysql"
if (-not (Get-Command $mysql -ErrorAction SilentlyContinue)) {
    Write-Error "MySQL client 'mysql' not found in PATH. Ensure MySQL/MariaDB is installed and 'mysql' is available in PATH (e.g., C:\\xampp\\mysql\\bin)."
    exit 1
}

$escapedPassword = $Password -replace '"', '\"'
$command = "`"$mysql`" -u $User"
if ($Password -ne '') { $command += " -p`"$escapedPassword`"" }
$command += " $Database < `"$SqlFile`""

Write-Host "Executing: $command"
cmd /c $command
if ($LASTEXITCODE -ne 0) {
    Write-Error "Import failed with exit code $LASTEXITCODE"
    exit $LASTEXITCODE
}

Write-Host "Import completed successfully."