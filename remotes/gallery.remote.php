<?

include("../inc/gallery.class.php");

if(isset($_POST['action'])) {
	switch($_POST['action']) {
		case "change":
			if(isset($_POST['value']))
				$gallery->change();
			break;
		case "reload":
			$gallery->reload();
			break;
		case "time":
			if(isset($_POST['time']))
				$gallery->changeTime();
			break;
		case "getprogress":
			$gallery->getProgress();
			break;
		case "getdata":
			$gallery->getData();
			break;
		case "setprogress":
			if(isset($_POST['count']))
				$gallery->setProgress();
			break;
		case "forceschwarz":
			$gallery->forceSchwarz();
			break;
	}
}

?>