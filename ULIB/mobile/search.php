<?php 
		// พ
			$kw=addslashes($kw);
			$s="select * from index_db where $idx like '%$kw%' and ispublish='yes' ";
			//echo $s;
			$s=tmqp("$s","index.php?kw=$kw&idx=$idx",NULL,10);
			while ($r=tfa($s)) {
				?><table width=100%>
				<tr valign=top>
					<td width=50><?php echo res_cov_dsp($r[mid]);?></td>
					<td><a href="detail.php?ID=<?php  echo $r[mid]?>" target=_blank data-ajax="false" ><?php echo marc_gettitle($r[mid]);?></a><br>
					<?php echo marc_getcalln($r[mid]);
					
				?></td>
				</tr>
				</table><?php 
			}
			echo $_pagesplit_btn_var;

	?>