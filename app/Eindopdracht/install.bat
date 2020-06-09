@echo off

echo Welcome to the frontend_calls installer
echo.
:choice
set /P c=Are you sure you want to install the frontend_calls[Y/N]?
if /I "%c%" EQU "Y" goto :Installing
if /I "%c%" EQU "N" goto :Exit

Goto :choice

:Exit
exit


:Installing

echo '> Installing Program...'
git clone --quiet https://github.com/Miketenklooster/api_frontend/tree/master/app/Eindopdracht

echo Thank you for Installing my frontend_calls, I wish you a lot of fun!
pause
exit

