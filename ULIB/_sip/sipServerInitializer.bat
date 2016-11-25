
@echo ULibM SIP Server (Windows)
@echo Sock Server for port  initializing..
@echo ======================================

@echo starting port 8001
@start "ULibM SIP Server " "/usr/bin/php" -q "/var/www/htdocs/ULIBM/_sip/_serverport-8001.php"

@echo starting port 8002
@start "ULibM SIP Server " "/usr/bin/php" -q "/var/www/htdocs/ULIBM/_sip/_serverport-8002.php"

@echo starting port 8003
@start "ULibM SIP Server " "/usr/bin/php" -q "/var/www/htdocs/ULIBM/_sip/_serverport-8003.php"

@echo starting port 8004
@start "ULibM SIP Server " "/usr/bin/php" -q "/var/www/htdocs/ULIBM/_sip/_serverport-8004.php"

@echo Socket initialized
@pause
