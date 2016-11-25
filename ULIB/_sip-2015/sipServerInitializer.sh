
echo "ULibM SIP Server (Linux)"
echo "Sock Server for port  initializing.."
echo "======================================"
#killall php
"D:/ulibm_portable/php/php.exe" "ULibM SIP Server " -q D:/ulibm_portable/root/ULIB6/_sip/killotherpid.php
sleep 3

echo my pid is $$


echo "starting port 8001"
D:/ulibm_portable/php/php.exe -q D:/ulibm_portable/root/ULIB6/_sip/_serverport-8001.php&

echo "starting port 8002"
D:/ulibm_portable/php/php.exe -q D:/ulibm_portable/root/ULIB6/_sip/_serverport-8002.php&

echo "starting port 8003"
D:/ulibm_portable/php/php.exe -q D:/ulibm_portable/root/ULIB6/_sip/_serverport-8003.php&

echo "Socket initialized"

