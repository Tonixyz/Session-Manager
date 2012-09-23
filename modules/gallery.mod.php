<fieldset>
	<legend>Galerie</legend>
	<table>
		<tr>
			<td colspan='4'>
				<select id='gallery' size='1' onchange='gallery.change()'>
					<?
						
						$galleryLocation = $db->getOption("galleryLocation");
						$galleryTime = $db->getOption("galleryTime");
						
						$dir = dir("fotos");
						
						while($album = $dir->read()) {
							if(ereg("^\.", $album))
								continue;
							echo	"<option";
							echo	($album == $galleryLocation) ? " selected" : "";
							echo	">$album</option>";
						}
						
						$dir->close();
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td rowspan='2'><a id='galleryRefreshButton' class='refresh tooltip' href='javascript:gallery.reload();' 
							rel='Verzeichnis neu einlesen'>&nbsp;&reg;&nbsp;</a></td>
			<td rowspan='2'>Anzeigedauer je Bild (in Sekunden):</td>
			<td class='galleryStepper' valign='bottom'><a href='javascript:gallery.stepTime(1);'>&#9650;</a></td>
			<td rowspan='2' id='galleryTimeBox'>
				<input id='galleryTime' type='text' value='<?=$galleryTime;?>' disabled>
			</td>
		</tr>
		<tr>
			<td class='galleryStepper' valign='top'><a href='javascript:gallery.stepTime(-1);'>&#9660;</a></td>
		</tr>
	</table>
</fieldset>