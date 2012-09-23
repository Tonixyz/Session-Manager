<fieldset>
	<legend>Specials</legend>
	<select id='specials' onchange='specials.change();' size='1'>
		<?
			
			$special = $db->getOption("special");
			
			$dir = dir("specials");
			
			while($album = $dir->read()) {
				if(ereg("^\.", $album))
					continue;
				echo	"<option";
				echo	($album == $special) ? " selected" : "";
				echo	">$album</option>";
			}
			
			$dir->close();
		?>
	</select>
	<a id='specialsRefreshButton' class='refresh tooltip'
			href='javascript:specials.reload();' rel='Verzeichnis neu einlesen'>&nbsp;&reg;&nbsp;</a>
</fieldset>