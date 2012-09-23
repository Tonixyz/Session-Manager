<?
	include("inc/database.class.php");
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel='stylesheet' type='text/css' href='css/admin.css'>
<link rel='stylesheet' type='text/css' href='css/sponsors.css'>
<link rel='stylesheet' type='text/css' href='css/gallery.css'>
<link rel='stylesheet' type='text/css' href='css/specials.css'>
<link rel='stylesheet' type='text/css' href='css/ticker.css'>
<script type='text/javascript' src='js/moocore.js'></script>
<script type='text/javascript' src='js/moomore.js'></script>
<title>SessionManager</title>
</head>
<body>
	<div id='sidebar'>
		<?
			$actions = array("schwarz", "galerie", "sponsor", "special");
			$currentAction = $db->getOption("action");
			
			foreach($actions as $a) {
				$active = ($a == $currentAction) ? " active" : "";
				echo	"<a id='action_$a' class='menuitem$active' href='javascript:action(\"$a\");'>$a</a>\n";
			}
		?>
		<span class='menuspacer'></span>
		<?
			$showClock = ($db->getOption("showClock")) ? " active" : "";
			$showTicker = ($db->getOption("showTicker")) ? " active" : "";
		?>
		<a id='clockButton' class='menuitem<?=$showClock; ?>' href='javascript:clock.toggle();'>Uhr</a>
		<a id='tickerButton' class='menuitem<?=$showTicker; ?>' href='javascript:ticker.toggle();'>Ticker</a>
		<?
			$date = date("H:i:s");
		?>
		<div id='clock' class='menuplugin'></div>
		<div id='shortcutsTrigger'>
			<a href='javascript:shortcuts.show()'>Shortcuts anzeigen</a><br>
			<a id='scrollToggler' href='javascript:enableScroll()'>Scrollen aktivieren</a>
		</div>
		<div id='galleryProgress'></div>
	</div>
	
	<?
		$modOrder1 = $db->getOption("moduleorderCol1");
		$modOrder2 = $db->getOption("moduleorderCol2");
		
		echo	"<ul id='col1'>";
		if($modOrder1 != "") {
			$modOrder1 = explode(",", $modOrder1);
			foreach($modOrder1 as $mod) {
				echo	"<li id='mod_$mod'>";
				include("modules/$mod.mod.php");
				echo	"</li>";
			}
		}
		echo	"</ul>";
		
		echo	"<ul id='col2'>";
		if($modOrder2 != "") {
			$modOrder2 = explode(",", $modOrder2);
			foreach($modOrder2 as $mod) {
				echo	"<li id='mod_$mod'>";
				include("modules/$mod.mod.php");
				echo	"</li>";
			}
		}
		echo	"</ul>";
	?>
	<div id='konami'>
		<div style='text-align: left'>
			<a href='http://en.wikipedia.org/wiki/Konami_code' target='_blank'>Konami Code</a> is geek...
		</div>
		<div style='text-align: right; color:#FF11AA;'>
			...and I love it!
		</div>
	</div>
	<div id='shortcuts' onclick='shortcuts.hide()'>
		<table>
			<tr>
				<td>Strg + Alt + 1</td>
				<td>Bildschirm: Schwarz</td>
			</tr>
			<tr>
				<td>Strg + Alt + 2</td>
				<td>Bildschirm: Galerie</td>
			</tr>
			<tr>
				<td>Strg + Alt + 3</td>
				<td>Bildschirm: Sponsor</td>
			</tr>
			<tr>
				<td>Strg + Alt + 4</td>
				<td>Bildschirm: Special</td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<td>Strg + Alt + 9</td>
				<td>Uhr an- / ausschalten</td>
			</tr>
			<tr>
				<td>Strg + Alt + 0</td>
				<td>Ticker an- / ausschalten</td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<td>Strg + Alt + R</td>
				<td>Galerien und Specials neu laden</td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<td>Strg + Alt + T</td>
				<td>Tickertext ändern</td>
			</tr>
			<tr>
				<td>Strg + Pfeiltaste unten</td>
				<td>Aktuellen Tickertext in Favoriten speichern</td>
			</tr>
			<tr>
				<td colspan='2'>&nbsp;</td>
			</tr>
			<tr>
				<td>Strg + Alt + Pfeiltaste oben</td>
				<td>Galerie: Zeit/Bild um 1 Sekunde verlängern</td>
			</tr>
			<tr>
				<td>Strg + Alt + Pfeiltaste unten</td>
				<td>Galerie: Zeit/Bild um 1 Sekunde verkürzen</td>
			</tr>
			<tr>
				<td>Strg + Alt + Umschalt + Pfeiltaste oben</td>
				<td>Galerie: Zeit/Bild um 10 Sekunden verlängern</td>
			</tr>
			<tr>
				<td>Strg + Alt + Umschalt + Pfeiltaste unten</td>
				<td>Galerie: Zeit/Bild um 10 Sekunden verkürzen</td>
			</tr>
		</table>
	</div>
</body>
</html>
<script type='text/javascript' src='js/sponsors.js'></script>
<script type='text/javascript' src='js/gallery.js'></script>
<script type='text/javascript' src='js/specials.js'></script>
<script type='text/javascript' src='js/ticker.js'></script>
<script type='text/javascript' src='js/admin.js'></script>