@echo off
title DEZZLY CREATIVE Controller Launcher
cd /d "%~dp0"
echo Membuka DEZZLY CREATIVE Studio & Deploy Controller...
powershell -ExecutionPolicy Bypass -NoProfile -WindowStyle Normal -File "%~dp0DezzlyStudioController.ps1"
