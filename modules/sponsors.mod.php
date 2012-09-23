<fieldset>
	
	<legend>Sponsoren</legend>
	
	<div id='sponsorsAddSponsor'>
		<table>
			<tr>
				<td><a id='sponsorsAddToggle' href='javascript:sponsors.open();'>Sponsor hinzuf&uuml;gen &raquo;</a></td>
				<td class='sponsorsIndicator'><span id='sponsorsIndicator'>Sortierung ge&auml;ndert &#10004;</span></td>
			</tr>
		</table>
		<div id='sponsorsAddForm'>
			<form action='javascript:sponsors.save()'>
				<div id='sponsorsAddNameBox' class='sponsorsAddInput'>
					<input type='text' id='sponsorsAddName'>
					<label for='sponsorsAddName'>Name</label>
				</div>
				<div class='sponsorsAddInput'>
					<select id='sponsorsAddFile'>
						<?
							$dir = dir("sponsoren");
							while($f = $dir->read()) {
								if(ereg("(\.JPG|\.jpg|\.JPEG|\.jpeg)$", $f))
									echo	"<option>$f</option>";
							}
							$dir->close();
						?>
					</select>
					<label for='sponsorsAddFile'>Datei</label>
				</div>
				<div id='sponsorsAddTimeBox' class='sponsorsAddInput'>
					<input type='text' id='sponsorsAddTime'>
					<label for='sponsorsAddTime'>Zeit</label>
				</div>
				<div class='sponsorsAddSubmit'>
					<input type='submit' style='display: none;'>
					<a href='javascript:sponsors.save()'>hinzuf&uuml;gen &raquo;</a>
				</div>
			</form>
		</div>
	</div>
	
	<div id='sponsorsCollapse'>
		<a id='sponsorsCollapesButton' href='javascript:sponsors.toggleList()'>[&ndash;] Liste ausblenden</a>
	</div>

	<ul id='sponsors'>
		<?
			$sql = $db->select("sponsors", "*", "ORDER BY sortid");
			
			$fullTime = 0;
			$activeTime = 0;
			
			foreach($sql as $sponsor) {
				
				if($sponsor['enabled'] == "1") {
					$active = " active";
					$activeTime += $sponsor['time'];
				} else
					$active = "";
				
				echo	"<li id='sponsor_".$sponsor['id']."'>";
				echo		"<table><tr>";
				echo			"<td class='handle'>&equiv;</td>";
				echo			"<td id='sponsorname$sponsor[id]' class='name$active'>$sponsor[name]</td>";
				echo			"<td class='delete'>";
				echo				"<a href='javascript:sponsors.delete($sponsor[id]);'>&otimes;</a>";
				echo			"</td>";
				echo			"<td class='enabled'>";
				echo				"<a href='javascript:sponsors.toggleActive($sponsor[id]);'>&hArr;</a>";
				echo			"</td>";
				echo			"<td class='preview tooltip' rel='<img src=\"remotes/sponsors.remote.php?thumb=$sponsor[file]\">'>&#10063;</td>";
				echo			"<td class='time'>$sponsor[time] Min.</td>";
				echo		"</tr></table>";
				echo	"</li>";
				
				$fullTime += $sponsor['time'];
				
			}
		?>
	</ul>
		
	<div id='sponsorsFullTime'>
		<table>
			<tr>
				<td>Aktiv / Gesamt:</td>
				<td align='right'>
					<span id='sponsorsTime1'><?=$activeTime;?></span> / 
					<span id='sponsorsTime2'><?=$fullTime;?></span> Minuten
				</td>
			</tr>
		</table>
	</div>
	
	<?
		$listStatus = $db->getOption("sponsorsliststatus");
		echo "<script type='text/javascript'>var sponsorsListStatus = '$listStatus';</script>"; 
	?>
	
</fieldset>