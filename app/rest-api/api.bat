@echo off

echo Welcome to the Api installer
echo.
:choice
set /P c=Are you sure you want to install the api[Y/N]?
if /I "%c%" EQU "Y" goto :Installing
if /I "%c%" EQU "N" goto :Exit

Goto :choice

:Exit
exit


:Installing

echo '> Installing Api...'
git clone --quiet https://github.com/Miketenklooster/api_frontend/tree/master/app/rest-api/v8 

echo Thank you for Installing my Api, I wish you a lot of fun!
pause
exit

