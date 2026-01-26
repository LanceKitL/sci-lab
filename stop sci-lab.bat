@echo off
color 0C
echo Stopping Sci-Lab System...

:: Kill PHP (Laravel Serve)
taskkill /F /IM php.exe /T >nul 2>&1
taskkill /F /IM cmd.exe /T >nul 2>&1

echo.
echo System Stopped. Goodbye!
timeout /t 3