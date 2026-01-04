# LawLite Development Server Starter
# This script starts the Laravel dev server in the background

$ProjectPath = "F:\Defence\LawLite"

# Kill any existing PHP processes
Write-Host "Stopping any existing PHP processes..." -ForegroundColor Yellow
Get-Process -Name php -ErrorAction SilentlyContinue | Stop-Process -Force -ErrorAction SilentlyContinue

# Start the server as a background job
Write-Host "Starting Laravel development server..." -ForegroundColor Green
$job = Start-Job -ScriptBlock {
    param($path)
    Set-Location $path
    & php artisan serve
} -ArgumentList $ProjectPath

Write-Host "Server started! (Job ID: $($job.Id))" -ForegroundColor Green
Write-Host "Access your app at: http://127.0.0.1:8000" -ForegroundColor Cyan
Write-Host ""
Write-Host "To check server status: Get-Job $($job.Id)" -ForegroundColor White
Write-Host "To view server output: Receive-Job $($job.Id) -Keep" -ForegroundColor White
Write-Host "To stop the server: Stop-Job $($job.Id); Remove-Job $($job.Id)" -ForegroundColor White
Write-Host ""

# Wait a moment and check if it started successfully
Start-Sleep -Seconds 2
$output = Receive-Job $job.Id -Keep
if ($output -match "Server running") {
    Write-Host "Server is running successfully!" -ForegroundColor Green
}
else {
    Write-Host "Server may not have started. Check output with: Receive-Job $($job.Id)" -ForegroundColor Red
}
