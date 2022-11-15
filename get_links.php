<?php

$uid = $_GET["uid"];

$v = $_GET["version"];

if($v !== "us" && $v !== "fr" && $v !== "th"){
    
    $empty = json_encode((object)[]);
    
    echo $v;
    
    exit($empty);
}

$all_links = json_decode(file_get_contents("calendar/". $v. "/others.json"));


if(isset($all_links->$uid)){

    echo json_encode($all_links->$uid);
    
    unset($all_links ->$uid);
    
    update_urls($all_links,$v);
    
}else{
    
  echo json_encode((object)[]);  
    
}

function update_urls($new,$v){
    
    $myfile = fopen("calendar/". $v. "/others.json", "w") or die("Unable to open file!");
    
	fwrite($myfile, json_encode($new));

	fclose($myfile);
    
}


?>