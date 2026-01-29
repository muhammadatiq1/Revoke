@echo off
cd /d "C:\Users\Atif Traders\OneDrive\Desktop\Revoke"

REM Remove merge state
del /f ".git\MERGE_HEAD" 2>nul
del /f ".git\MERGE_MSG" 2>nul
del /f ".git\MERGE_MODE" 2>nul

REM Move files from revoke folder to root
setlocal enabledelayedexpansion
for /D %%D in (revoke\*) do move "%%D" . >nul 2>&1
for %%F in (revoke\*) do move "%%F" . >nul 2>&1
rmdir /s /q revoke >nul 2>&1

REM Git operations
git reset --hard HEAD
git add .
git commit -m "Restructure repository - move code to root" --allow-empty
git branch -M master main
git push origin main --force

echo Repository updated successfully!
pause
