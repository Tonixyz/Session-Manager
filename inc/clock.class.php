<?

include("database.class.php");

class Clock {
	
	public function toggleActive() {
		global $db;
		
		$status = $db->getOption("showClock");
		
		$newStatus = ($status == "1") ? "0" : "1";
		
		echo	"<script type='text/javascript'>\n";
		if($db->setOption("showClock", $newStatus)) {
			if($newStatus == "1")
				echo	"clockMorph.start('#sidebar .active');\n";
			else
				echo	"clockMorph.start('#sidebar .inactive');\n";
		}
		echo	"</script>";
		
	}
	
	public function getStatus() {
		global $db;
		
		$status = $db->getOption("showClock");
		
		echo ($status == "1") ? "in" : "out";
		
	}
	
}
$clock = new Clock();

?>