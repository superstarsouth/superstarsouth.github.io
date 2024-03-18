@echo off
set PATH=C:\php\;%PATH%
php -v || goto :errorPHP
node -v || goto :errorNode
node build.js
goto :EOF

:errorPHP
echo PHP NOT INSTALLED
pause
goto :EOF

:errorNode
echo NODE NOT INSTALLED
pause
goto :EOF