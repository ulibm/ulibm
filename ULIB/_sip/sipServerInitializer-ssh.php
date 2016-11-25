<?php 
 echo "<PRE>";
include_once('Net/SSH2.php');

$ssh = new Net_SSH2('61.7.230.236');
if (!$ssh->login('root', 'Phayao123R')) {
    exit('Login Failed');
}

  

echo "killing tcp 8001";
echo $ssh->exec('/usr/bin/fuser -k -n tcp 8001');
 
   
  

echo "killing tcp 8002";
echo $ssh->exec('/usr/bin/fuser -k -n tcp 8002');
 
   
  

echo "killing tcp 8003";
echo $ssh->exec('/usr/bin/fuser -k -n tcp 8003');
 
   
  

echo "killing tcp 8004";
echo $ssh->exec('/usr/bin/fuser -k -n tcp 8004');
 
    ;
sleep(2);
echo "After kill:";

echo $ssh->exec('/bin/netstat -tulpn | grep 800');
echo $ssh->exec('/var/www/htdocs/ULIBM/_sip/sipServerInitializer.sh > /dev/null 2>/dev/null &');
echo "After restart:";


sleep(2);
echo $ssh->exec('/bin/netstat -tulpn | grep 800');

//echo shell_exec("/var/www/htdocs/ULIBM/_sip/sipServerInitializer.sh > /dev/null 2>/dev/null &");

 ?>.eof