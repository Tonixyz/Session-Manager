<?

include("../inc/sponsors.class.php");

if(isset($_POST['action'])) {
	switch($_POST['action']) {
		case "delete":
			if(isset($_POST['id']))
				$sponsors->delete();
			break;
		case "loadfiles":
			$sponsors->loadFiles();
			break;
		case "save":
			if(isset($_POST['name'], $_POST['file'], $_POST['time']))
				$sponsors->save();
			break;
		case "serialize":
			$sponsors->serialize();
			break;
		case "toggleactive":
			if(isset($_POST['id']))
				$sponsors->toggleActive();
			break;
		case "togglelist":
			if(isset($_POST['status']))
				$sponsors->toggleList();
			break;
		case "loaddata":
			if(isset($_POST['id']))
				$sponsors->loadData();
			break;
	}
} else {
	if(isset($_GET['thumb']) && file_exists("../sponsoren/".$_GET['thumb']))
		$sponsors->thumb();
}

?>