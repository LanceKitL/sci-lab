@echo off
title Sci-Lab Admin Creator
color 0A

echo ===================================================
echo      SCI-LAB: ADMIN ACCOUNT CREATOR
echo ===================================================
echo.
echo This tool will help you add a new Administrator.
echo.

:: Run the Laravel command using the local PHP folder
"%~dp0php\php.exe" artisan user:create-admin

echo.
echo ===================================================
echo Done! You can now close this window.
timeout /t 4