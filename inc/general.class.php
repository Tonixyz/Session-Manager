<?

include("database.class.php");

class General {
	
	public function changeAction() {
		global $db;
		$id = $_POST['id'];
		
		$oldAction = $db->getOption("action");
		
		if($id != $oldAction) {
			
			echo	"<script type='text/javascript'>\n";
			if($db->setOption("action", $id)) {
				echo	"actionMorph".ucfirst($id).".start('#sidebar .active');\n";
				echo	"actionMorph".ucfirst($oldAction).".start('#sidebar .inactive');\n";
			} else {
				echo	"alert('Fehler');\n";
			}
			echo	"</script>";
			
		}
	}
	
	public function sortModules() {
		global $db;
		$order = $_POST['order'];
		$order = explode("-", $order);
		
		$db->setOption("moduleorderCol1", $order[0]);
		$db->setOption("moduleorderCol2", $order[1]);
		
	}
	
	public function getAction() {
		global $db;
		
		echo $db->getOption("action");
		
	}
	
	public function forceSchwarz() {
		global $db;
		
		$db->setOption("forceschwarz", "1");
		
	}
	
	public function getForce() {
		global $db;
		
		$force = $db->getOption("forceschwarz");
		
		if($force == "1") {
			
			echo	"<script type='text/javascript'>\n";
			echo		"action('schwarz');\n";
			echo	"</script>";
			
			$db->setOption("forceschwarz", 0);
			
		}
		
	}
	
}
$general = new General();

?>