<? 

include("../inc/general.class.php");

if(isset($_POST['action'])) {
	switch($_POST['action']) {
		case "changeaction":
			if(isset($_POST['id']))
				$general->changeAction();
			break;
		case "sortmodules":
			if(isset($_POST['order']))
				$general->sortModules();
			break;
		case "get":
			$general->getAction();
			break;
		case "forceschwarz":
			$general->forceSchwarz();
			break;
		case "getforce":
			$general->getForce();
			break;
	}
}

?>