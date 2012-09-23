<?

include("database.class.php");

class Specials {
	
	public function change() {
		global $db;
		
		$value = $_POST['value'];
		
		echo	"<script type='text/javascript'>\n";
		if($db->setOption("special", $value))
			echo	"specials.highlightSelect('#7f7');\n";
		else
			echo	"specials.highlightSelect('#f77');\n";
		echo	"</script>";
		
		
	}
	
	public function reload() {
		global $db;
		
		$special = $db->getOption("special");
		
		$dir = dir("../specials/");
		
		$out = "";
		while($s = $dir->read()) {
			
			if(ereg("^\.", $s))
				continue;
			$out .= "<option";
			$out .= ($s == $special) ? " selected" : "";
			$out .= ">$s</option>";
			
		}
		
		echo	"<script type='text/javascript'>\n";
		echo		"$('specials').set('html', '$out');\n";
		echo		"specials.highlightRefresh();\n";
		echo	"</script>";
		
		$dir->close();
		
	}
	
	public function getFile() {
		global $db;
		
		$file = $db->getOption("special");
		
		echo	"<script type='text/javascript'>\n";
		echo		"specials.showFile('specials/$file');\n";
		echo	"</script>";
		
	}
	
}
$specials = new Specials();

?>