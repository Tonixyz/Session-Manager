<?

include("database.class.php");

class Sponsors {
	
	public function delete() {
		global $db;
		$id = $_POST['id'];
		
		echo	"<script type='text/javascript'>\n";
		if($db->delete("sponsors", "WHERE id = '$id'"))
			echo	"sponsors.remove($id);\n";
		else
			echo	"alert('Server-Fehler');\n";
		echo	"</script>";
		
	}
	
	public function loadFiles() {
		
		$dir = dir("../sponsoren/");
		
		$out = "";
		while($s = $dir->read()) {
			
			if(ereg("^\.", $s))
				continue;
			$out .= "<option>$s</option>";
			
		}
		
		echo	"<script type='text/javascript'>\n";
		echo		"$('sponsorsAddFile').set('html', '$out');\n";
		echo	"</script>";
		
		$dir->close();
		
	}
	
	public function save() {
		global $db;
		$name = $_POST['name'];
		$file = $_POST['file'];
		$time = $_POST['time'];
		
		$succ = $db->insert("sponsors", array("name" => "'$name'", "file" => "'$file'", "time" => "'$time'"));
		
		echo	"<script type='text/javascript'>\n";
		if($succ) {
			$id = $db->insertID;
			
			$text =		"<table><tr>";
			$text.=			"<td class='handle'><span>&uarr;&darr;</span></td>";
			$text.=			"<td id='sponsorname$id' class='name active'>$name</td>";
			$text.=			"<td class='delete'>";
			$text.=				"<a href='javascript:sponsors.delete($id);'>&otimes;</a>";
			$text.=			"</td>";
			$text.=			"<td class='enabled'>";
			$text.=				"<a href='javascript:sponsors.toggleActive($id);'>&hArr;</a>";
			$text.=			"</td>";
			$text.=			"<td class='preview tooltip' rel='<img src=\\\"remotes/sponsors.remote.php?thumb=$file\\\">'>&#10063;</td>";
			$text.=			"<td class='time'>$time Min.</td>";
			$text.=		"</tr></table>";
			
			echo	"sponsors.close();\n";
			echo	"sponsors.add('$id', \"$text\");\n";
		} else {
			echo	"alert('Server-Fehler');\n";
		}
		echo	"</script>";
		
	}
	
	public function serialize() {
		global $db;
		
		$sql = $db->select("sponsors", "id");
		
		$ids = array();
		foreach($sql as $id)
			array_push($ids, (string) $id['id']);
		
		$succ = true;
		foreach($ids as $id) {
			if(!$succ)
				break;
			
			$sortid = $_POST[$id] + 1;
			$succ = $db->update("sponsors", array("sortid" => $sortid), "WHERE id = '$id'");
		}
		
		echo	"<script type='text/javascript'>\n";
		if($succ)
			echo	"$('sponsorsIndicator').fade('show').fade('out');\n";
		else
			echo	"alert('Scriptfehler:\\nSponsoren wurden nicht umsortiert');\n";
		echo	"</script>";
		
	}
	
	public function toggleActive() {
		global $db;
		$id = $_POST['id'];
		
		$enable = $db->field("sponsors", "enabled", "WHERE id = '$id'");
		
		$newValue = ($enable == "1") ? "0" : "1";
		
		$succ = $db->update("sponsors", array("enabled" => $newValue), "WHERE id = '$id'");
		
		echo	"<script type='text/javascript'>\n";
		if($succ) {
			
			$activeTime = 0;
			$sql = $db->select("sponsors", "time", "WHERE enabled = '1'");
			foreach($sql as $t) {
				$activeTime += $t['time'];
			}
			
			echo	"$('sponsorsTime1').set('html', '$activeTime');\n";
			
			if($newValue == "1")
				echo	"$('sponsorname$id').addClass('active');\n";
			else
				echo	"$('sponsorname$id').removeClass('active');\n";
		} else {
			echo	"alert('fehler');\n";
		}
		echo	"</script>";
		
	}
	
	public function toggleList() {
		global $db;
		
		$status = $_POST['status'];
		
		$success = $db->setOption("sponsorsliststatus", $status);
		
	}
	
	
	public function thumb() {
		$thumb = $_GET['thumb'];
		
		if(file_exists("../img/sponsorthumbs/".$thumb))
			die(header("Location:../img/sponsorthumbs/".$thumb));
		else {
			
			// Options
			$desWidth = 320; # Width of returned thumbnail
			
			$srcImgSize = getimagesize("../sponsoren/".$thumb);
			$desHeight = $desWidth / ($srcImgSize[0] / $srcImgSize[1]);
			
			$srcImg = imagecreatefromjpeg("../sponsoren/".$thumb);
			$desImg = imagecreate($desWidth, $desHeight);
			
			imagecopyresized($desImg, $srcImg, 0, 0, 0, 0, $desWidth, $desHeight, $srcImgSize[0], $srcImgSize[1]);
			
			imagejpeg($desImg, "../img/sponsorthumbs/".$thumb, 100);
			
			die(header("Location:../img/sponsorthumbs/".$thumb));
			
		}
	}
	
	
	public function loadData() {
		global $db;
		$id = (int) $_POST['id'];
		
		$action = $db->getOption("action");
		
		if($action == "sponsor") {
			
			$data = $db->select("sponsors", "sortid, file, time", "WHERE sortid > '$id' AND enabled = '1' ORDER BY sortid LIMIT 1");
			
			echo	"<script type='text/javascript'>\n";
			
			if($data) {
				
				$sort = $data[0]['sortid'];
				$file = $data[0]['file'];
				$time = $data[0]['time'];
				echo	"sponsors.showFile('sponsoren/$file', $time, $sort);\n";
				
			} else
				$db->setOption("forceschwarz", "1");
			
			echo	"</script>";
			
		}
		
	}
	
}
$sponsors = new Sponsors();

?>