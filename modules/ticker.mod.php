<fieldset>
	<legend>Ticker</legend>
	<?
		$sqlTicker = $db->getOption("tickerText");
	?>
	<div id='tickerNewTicker'>
		<input id='tickerNewText' type='text' onkeyup='ticker.change();' value='<?=$sqlTicker;?>'>&nbsp;
		<a href='javascript:ticker.fav();' class='tooltip' rel='in Favoriten speichern'>&oplus;</a>
	</div>
	<ul id='ticker'>
		<?
			$sqlTicker = $db->select("ticker", "*", "ORDER BY id");
			
			foreach($sqlTicker as $t) {
				
				echo	"<li id='tickerFav_$t[id]'><table><tr>";
				echo		"<td class='text'><a id='tickerUse_$t[id]' href='javascript:ticker.useFav($t[id]);'>$t[text]</a></td>";
				echo		"<td class='delete tooltip' rel='aus Favoritenliste l&ouml;schen'>";
				echo			"<a href='javascript:ticker.deleteFav($t[id]);'>&otimes;</a>";
				echo		"</td>";
				echo	"</tr></table></li>";
			}
		?>
	</ul>
</fieldset>