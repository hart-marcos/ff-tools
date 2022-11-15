<?php

$type = $_GET['type'];

$v_ = $_GET['v'];

$links = file_get_contents("links/" . $v_ . "/" . $type . ".json");

$array = json_decode($links, true);

$do = true;

if (count($array) >= 41) {
    $urls = array_slice($array, 41);
    $array_41 = array_slice($array, 0, 41);
} else if (count($array) >= 10) {
    $urls = [];
    $array_41 = array_slice($array, 0 ,count($array));
} else {
    $do = false;
}

if($do){

$myfile = fopen("links/" . $v_ . "/" . $type . ".json", "w") or die("Unable to open file!");

fwrite($myfile, json_encode($urls));
fclose($myfile);

echo json_encode($array_41);

}else{
    
    echo json_encode([]);
    
}

?>