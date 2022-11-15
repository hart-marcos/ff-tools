<?php

$type = $_GET["type"];

$v = $_GET["v"];

if($type == "p"){

 $file = "calendar/". $v. "/purple.json";  

}else if($type == "h"){
    
 $file = "calendar/". $v. "/heart.json";  
  
}else{
    
    exit(json_encode([]));
    
}


$links = file_get_contents($file);

$array = json_decode($links,true);

$max = count($array); 

if($max >= 1){

$urls = array_slice($array,$max);   

 
   $myfile = fopen($file,"w") or die("Unable to open file!");

   fwrite($myfile, json_encode($urls));
   fclose($myfile);
   

    $array_41 = array_slice($array,0,$max);   


echo json_encode($array_41);
}else{
    echo json_encode([]);
}

?>