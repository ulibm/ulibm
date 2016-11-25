<?php 
//printr($_SESSION);
					member_showlonginfo($_memid);
	


					member_showhold($_memid);
					member_showrequest($_memid);
					member_showrequestlist($_memid);
					member_showfine($_memid);


	$c2=tmq("select * from member_type where type='$row[type]'  ");
		$c2=tmq_fetch_array($c2);
		if ($c2[grant_room]=='yes') {
			 echo "<br>";
        pagesection("ข้อมูลการจองห้อง::l::Room request information");	
        $dsp[2][text]="ห้อง::l::room";
        $dsp[2][field]="maintb";
        $dsp[2][filter]="foreign:-localdb-,rqroom_maintb,code,name";
        $dsp[2][width]="30%";
        
        $dsp[4][text]="ช่วงเวลา/ห้องย่อย-ที่นั่ง::l::Period/room-seat";
        $dsp[4][field]="period";
        $dsp[4][width]="30%";
        $dsp[4][filter]="module:localiconname";
        

        function localiconname($wh) {
			 $c=tmq("select * from rqroom_periodinfo where maintb='$wh[maintb]' and code='$wh[period]' ");
			 $c=tmq_fetch_array($c);
			 $roomsub=tmq("select * from rqroom_roomsub where code='$wh[roomsub]' and maintb='$wh[maintb]' ");
			 $roomsub=tmq_fetch_array($roomsub);
        	$s="";
        	$s.=" ".getlang("ช่วงเวลา::l::Period")."<B> $c[name]</B> ($c[time])<BR>
			".getlang("ห้องย่อย-ที่นั่ง::l::room-seat")." <B>$roomsub[name]</B><BR>";
        	$s.="&nbsp;&nbsp;&nbsp;$c[descr]";
        	return $s;
        }
        $tbname="rqroom_timetbi";
		$now=time();
        fixform_tablelister($tbname," loginid='$_memid' and dt>=$now  ",$dsp,"no","no","yes","mi=$mi",$c);
        echo "<center>".getlang("คุณสามารถจองห้องที่ให้บริการได้จากเมนูการจองห้อง ที่หน้าหลัก::l::You can use request-room module from homepage")."</center>";

		}
					?>