<?php

$from = $_GET["from"] ?? "";

if((date('H') >= 20 && date('H') < 23 && date('i') >= 1) || ($from == "admin")){

$v = $_GET["v"];

    
  $file = "calendar/". $v. "/yellow.json"; 
  

$links = file_get_contents($file);

$array = json_decode($links,true);

$max=count($array);

if($max >= 60 || (($v == "th" || $v == "fr" ) && $max >= 10)){


   $myfile = fopen("calendar/back_up/". $v. ".json","w") or die("Unable to open file!");

   fwrite($myfile, json_encode($array));
   fclose($myfile);


   $urls = array_slice($array,$max);   

 
   $myfile = fopen($file,"w") or die("Unable to open file!");

   fwrite($myfile, json_encode($urls));
   fclose($myfile);
   

    $array_41 = array_slice($array,0,$max);   


    echo json_encode($array_41);
    
}else{
    
    echo json_encode([]);
    
}



    
}else{
    
   echo json_encode([]);
   
}

?>