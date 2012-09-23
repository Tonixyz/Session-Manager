<?

include("database.class.php");

class Ticker {
	
	public function toggleActive() {
		global $db;
		
		$status = $db->getOption("showTicker");
		
		$newStatus = ($status == "1") ? "0" : "1";
		
		echo	"<script type='text/javascript'>\n";
		if($db->setOption("showTicker", $newStatus)) {
			if($newStatus == "1")
				echo	"tickerMorph.start('#sidebar .active');\n";
			else
				echo	"tickerMorph.start('#sidebar .inactive');\n";
		}
		echo	"</script>";
		
	}
	
	public function change() {
		global $db;
		$txt = htmlentities(urldecode($_POST['text']));
		
		$db->setOption("tickerText", $txt);
		
	}
	
	public function add() {
		global $db;
		
		$txt = $db->getOption("tickerText");
		
		$succ = $db->insert("ticker", array("id" => "NULL", "text" => "'$txt'"));
		
		echo	"<script type='text/javascript'>\n";
		if($succ) {
			
			$t = $db->select("ticker", "*", "WHERE id = '".$db->insertID."'");
			$t = $t[0];
			
			$html = "<table><tr>";
			$html.=		"<td class='text'><a id='tickerUse_$t[id]' href='javascript:ticker.useFav($t[id])' >$t[text]</a></td>";
			$html.=		"<td class='delete tooltip' rel='aus Favoritenliste l&ouml;schen'>";
			$html.=			"<a href='javascript:ticker.deleteFav($t[id]);'>&otimes;</a>";
			$html.=		"</td>";
			$html.=	"</tr></table>";
			
			echo	"ticker.addFav('$t[id]', \"$html\")\n";
		
		} else {
			echo	"alert('fehler');\n";
		}
		echo	"</script>";
		
	}
	
	public function delete() {
		global $db;
		$id = $_POST['id'];
		
		if($db->delete("ticker", "WHERE id = '$id'")) {
			
			$sql = $db->select("ticker");
			
			$out = "";
			foreach($sql as $t) {
				
				$out .= "<li><table><tr>";
				$out .=		"<td class='text'>$t[text]</td>";
				$out .=		"<td class='delete tooltip' rel='aus Favoritenliste l&ouml;schen'>";
				$out .=			"<a href='javascript:ticker.deleteFav($t[id]);'>&otimes;</a>";
				$out .=		"</td>";
				$out .=	"</tr></table></li>";
				
			}
			
			echo	"<script type='text/javascript'>\n";
			echo		"ticker.hideFav($id);\n";
			echo	"</script>";
			
		}
	}
	
	public function getData() {
		global $db;
		
		$state = $db->getOption("showTicker");
		$text = ereg_replace('\$', '&euro;', $db->getOption("tickerText"));
		
		$statusText = ($state == "1") ? "in" : "out";
		
		echo	$statusText . "-=-" . $text;
		
	}
	
}
$ticker = new Ticker();

?>