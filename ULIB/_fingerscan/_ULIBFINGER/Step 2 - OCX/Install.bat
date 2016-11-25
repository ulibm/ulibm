@echo off
echo %WINDIR%\system32
echo Copying file...
@copy Biokey.ocx %WINDIR%\system32\ >NUL
regsvr32  %WINDIR%\system32\Biokey.ocx
pause