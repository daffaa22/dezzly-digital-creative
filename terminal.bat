@echo off
title DEZZLY CREATIVE Terminal Controller
cd /d "%~dp0"
powershell -ExecutionPolicy Bypass -NoProfile -File "%~dp0terminal-controller.ps1"
