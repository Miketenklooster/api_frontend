@echo off

echo Welcome to the myKube installer
echo.
:choice
set /P c=Are you sure you want to install the myKube[Y/N]?
if /I "%c%" EQU "Y" goto :Installing
if /I "%c%" EQU "N" goto :Exit

Goto :choice

:Exit
exit


:Installing

echo '> Installing myKube...'
git clone --quiet https://github.com/Miketenklooster/api_frontend/tree/master/app/frameworks/kube/myKube

echo Thank you for Installing my myKube, I wish you a lot of fun!
pause
exit

