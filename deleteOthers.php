<?php

$versions = array("us","th","fr");

foreach ($versions as $value) {

    $myfile = fopen("calendar/". $value. "/others.json", "w") or die("Unable to open file!");
    
	fwrite($myfile, json_encode((object)[]));

	fclose($myfile);
	
	echo "ok -> ". $value. " -> ( ". date("y/m/d h:i:s",time()). " )\n";

}

?>