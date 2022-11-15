<?php

$links = file_get_contents("calendar/purple.json");

$array = json_decode($links,true);



$urls = array_slice($array,count($array));   

 
   $myfile = fopen("calendar/purple.json","w") or die("Unable to open file!");

   fwrite($myfile, json_encode($urls));
   fclose($myfile);
   

    $array_41 = array_slice($array,0,count($array));   


echo json_encode($array_41);

?>