@echo off
setlocal

:: Run as Administrator Check
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo Requesting administrator privileges...
    powershell -Command "Start-Process cmd.exe -ArgumentList '/c %~s0' -Verb RunAs"
    exit /b
)

:: Install Cloudflared using winget (Auto-accept terms)
echo Installing Cloudflared...
winget install --id Cloudflare.cloudflared -e --accept-source-agreements --accept-package-agreements

:: Verify installation
where cloudflared >nul 2>&1
if %errorlevel% neq 0 (
    echo Cloudflared installation failed. Exiting.
    exit /b 1
)

:: Register PCRU UNIVERSITY tunnel
echo Registering PCRU UNIVERSITY tunnel...
cloudflared.exe service install eyJhIjoiMTZhN2RhYzc2ZDkyZmZiNjkyZjYzMTE3MWUwMDZmZGEiLCJ0IjoiMzFiMmUxZDUtYjc0OC00Mzk2LWJjMjAtOTcwZDZjYWI5MzdiIiwicyI6Ik5qa3dZMk0yWXpFdE5ETTNZUzAwTkdReExXSXlOemd0Tm1Rd01qQmhaREF4TlRrMyJ9

echo Cloudflare tunnel setup complete.
exit /b 0
