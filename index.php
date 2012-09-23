<?php
	include("inc/database.class.php");
	define("WINW", 1024);
	define("WINH", 768);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv='cache-control' content='no-cache'>
<link rel='stylesheet' type='text/css' href='css/index.css'>
<style type='text/css'>
.container { width: <?=WINW;?>px; height: <?=WINH;?>px; }
#loaderBox { top: 0px; }
#trace { top: <?=WINH;?>px; width: <?=(WINW-20);?>px; }
</style>
<script type='text/javascript' src='js/moocore.js'></script>
<script type='text/javascript' src='js/moomore2.js'></script>
<title>Q12 Session</title>
</head>
<body style="overflow:hidden;">
	<div id='schwarz' class='container'></div>
	<div id='galerie' class='container'><div id='gal0'></div><div id='gal1'></div></div>
	<div id='sponsor' class='container'></div>
	<div id='special' class='container'></div>
	<marquee id='ticker' direction='left' scrollamount='5' scrolldelay='30'></marquee>
	<div id='clock'></div>
	<div id='loaderBox'><div id='loader'></div></div>
	<pre id='trace'></pre>
</body>
</html>
<script type='text/javascript' src='js/index.js'></script>