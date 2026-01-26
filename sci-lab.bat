@echo off
title Sci-Lab System Server
color 0A

echo ======================================================
echo      STARTING SCI-LAB SYSTEM (HYBRID MODE)
echo ======================================================

:: 2. Find IP Address
for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr "IPv4 Address"') do (set IP=%%a)
set IP=%IP: =%

:: 3. Open Admin Browser
start http://localhost:8000

:: 4. GENERATE QR CODE AND SHOW INFO
cls
echo ======================================================
echo    SCI-LAB SYSTEM IS ONLINE
echo ======================================================
echo.
echo    [ ADMIN ACCESS ]   http://localhost:8000
echo.
echo    [ STUDENT ACCESS ] 
echo    Scan the code below or type: http://%IP%:8000
echo.

:: This line draws the QR code!
cd /d "%~dp0"
"%~dp0php\php.exe" artisan sci:qr http://%IP%:8000


:: 5. Start Server
"%~dp0php\php.exe" artisan serve --host=0.0.0.0 --port=8000