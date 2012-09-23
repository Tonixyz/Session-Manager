<?

include("../inc/specials.class.php");

switch($_POST['action']) {
	case "change":
		if(isset($_POST['value']))
			$specials->change();
		break;
	case "reload":
		$specials->reload();
		break;
	case "getfile":
		$specials->getFile();
		break;
}

?>