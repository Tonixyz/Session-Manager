<?

include("../inc/clock.class.php");

if(isset($_POST['action'])) {
	switch($_POST['action']) {
		case "toggleactive":
			$clock->toggleActive();
			break;
		case "get":
			$clock->getStatus();
			break;
	}
}

?>