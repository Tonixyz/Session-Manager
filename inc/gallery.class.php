<?

include("database.class.php");

class Gallery {
	
	public function change() {
		global $db;
		$value = $_POST['value'];
		
		echo	"<script type='text/javascript'>\n";
		if($db->setOption("galleryLocation", $value))
			echo	"gallery.highlightSelect('#7f7');\n";
		else
			echo	"gallery.highlightSelect('#f77');\n";
		echo	"</script>";
		
		
	}
	
	public function changeTime() {
		global $db;
		$time = $_POST['time'];
		
		echo	"<script type='text/javascript'>\n";
		if($db->setOption("galleryTime", $time))
			echo	"$('galleryTime').set('value', '$time');\n";
		else
			echo	"alert('Server-Fehler!');\n";
		echo	"</script>";
		
	}
	
	public function reload() {
		global $db;
		
		$gallery = $db->getOption("galleryLocation");
		
		$dir = dir("../fotos/");
		
		$out = "";
		while($g = $dir->read()) {
			
			if(ereg("^\.", $g))
				continue;
			$out .= "<option";
			$out .= ($g == $gallery) ? " selected" : "";
			$out .= ">$g</option>";
			
		}
		
		echo	"<script type='text/javascript'>\n";
		echo		"$('gallery').set('html', '$out');\n";
		echo		"gallery.highlightRefresh();\n";
		echo	"</script>";
		
		$dir->close();
		
	}
	
	public function getProgress() {
		global $db;
		
		$total = $db->getOption("galleryImageCount");
		$current = $db->getOption("galleryCurrentImage");
		$time = $db->getOption("galleryTime");
		
		if($total == 0 && $current == 0)
			$str = "";
		else {
			$totalTime = $time * ($total-$current);
			$min = floor($totalTime / 60);
			$sec = $totalTime % 60;
			
			$str = "$current / $total (Noch ca. $min Min. $sec Sek.)";
		}
		
		echo	"<script type='text/javascript'>\n";
		echo		"$('galleryProgress').set('html', '$str');\n";
		echo	"</script>";
		
	}
	
	public function getData() {
		global $db;
		
		$folder = $db->getOption("galleryLocation");
		$time	= $db->getOption("galleryTime");
		
		$dir = dir("../fotos/$folder/");
		
		$fileArray = array();
		while($file = $dir->read())
			if(eregi("(\.JPG)$", $file))
				array_push($fileArray, "fotos/$folder/$file");
		
		$db->setOption("galleryImageCount", count($fileArray));
		
		$files = "['";
		$files.= implode("','", $fileArray);
		$files.= "']";
		
		echo	"<script type='text/javascript'>\n";
		echo		"gallery.saveData($time, $files);\n";
		echo	"</script>";
		
	}
	
	public function setProgress() {
		global $db;
		$count = $_POST['count'];
		
		if($count == "reset") {
			$db->setOption("galleryImageCount", "0");
			$count = 0;
		}
		$db->setOption("galleryCurrentImage", $count);
		
	}
	
	public function forceSchwarz() {
		global $db;
		
		$db->setOption("forceschwarz", "1");
		
	}
	
}
$gallery = new Gallery();

?>