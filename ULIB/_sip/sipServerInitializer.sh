
echo "ULibM SIP Server (Linux)"
echo "Sock Server for port  initializing.."
echo "======================================"


"/usr/bin/php" "ULibM SIP Server " -q /var/www/htdocs/ULIBM/_sip/killotherpid.php
sleep 3




echo "starting port 8001"
/usr/bin/php -q /var/www/htdocs/ULIBM/_sip/_serverport-8001.php&

echo "starting port 8002"
/usr/bin/php -q /var/www/htdocs/ULIBM/_sip/_serverport-8002.php&

echo "starting port 8003"
/usr/bin/php -q /var/www/htdocs/ULIBM/_sip/_serverport-8003.php&

echo "starting port 8004"
/usr/bin/php -q /var/www/htdocs/ULIBM/_sip/_serverport-8004.php&

echo "Socket initialized"

