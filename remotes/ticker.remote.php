<?

include("../inc/ticker.class.php");

if(isset($_POST['action'])) {
	switch($_POST['action']) {
		case "add":
			$ticker->add();
			break;
		case "change":
			if(isset($_POST['text']))
				$ticker->change();
			break;
		case "delete":
			if(isset($_POST['id']))
				$ticker->delete();
			break;
		case "toggleactive":
			$ticker->toggleActive();
			break;
		case "get":
			$ticker->getData();
			break;
	}
}

?>