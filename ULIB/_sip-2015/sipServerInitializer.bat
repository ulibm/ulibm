
@echo ULibM SIP Server (Windows)
@echo Sock Server for port  initializing..
@echo ======================================

@echo starting port 8001
@start "ULibM SIP Server " "D:/ulibm_portable/php/php.exe" -q "D:/ulibm_portable/root/ULIB6/_sip/_serverport-8001.php"

@echo starting port 8002
@start "ULibM SIP Server " "D:/ulibm_portable/php/php.exe" -q "D:/ulibm_portable/root/ULIB6/_sip/_serverport-8002.php"

@echo starting port 8003
@start "ULibM SIP Server " "D:/ulibm_portable/php/php.exe" -q "D:/ulibm_portable/root/ULIB6/_sip/_serverport-8003.php"

@echo Socket initialized
@pause
