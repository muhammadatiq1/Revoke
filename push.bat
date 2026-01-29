@echo off
setlocal enabledelayedexpansion

cd /d "C:\Users\Atif Traders\OneDrive\Desktop\Revoke"

REM Remove .git folder
if exist .git (
    echo Removing .git folder...
    for /f %%A in ('dir /b') do (
        if /i "%%A"==".git" (
            rmdir /s /q ".git"
        )
    )
)

REM Move all files from revoke to current directory
echo Moving files from revoke folder to root...
cd revoke
for /f %%A in ('dir /b') do (
    move "%%A" ".." >nul 2>&1
)
cd ..
rmdir /s /q revoke 2>nul

REM Initialize new git repo
echo Initializing git...
git init
git config user.name "Muhammad Atiq"
git config user.email "muhammadatiq1@example.com"

REM Add all and commit
echo Adding files...
git add .
git commit -m "Initial Revoke project commit"

REM Set remote and push
echo Pushing to GitHub...
git remote add origin https://github.com/muhammadatiq1/Revoke.git
git branch -M main
git push -u origin main --force

echo.
echo ✓ Done! Repository updated at https://github.com/muhammadatiq1/Revoke
pause
