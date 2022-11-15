<?php

$n = $_GET['n'];

$sr = file_get_contents('sr/sr_cal_'. $n. '.json');

$type = $_GET['type'];

$limit = 0;
$yellow = 0;
$purple = 0;
$heart = 0;
$other = 0;



function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


$array = json_decode($sr, true)['sr'];

foreach ($array as $value) {
 
 $key = generateRandomString();
 $uid = json_decode(base64_decode(explode(".", $value)[1]))->{'user_id'};
 $hash = md5($uid. '_');


$response = json_decode(file_get_contents('https://farm-us.centurygames.com/ar/facebook/get_feed_key/?signed_request='. $value. '&type='. $type. '&key='. $key. '&hash=-'. $hash. '-'));

if(isset($response->payload->reward->items)){
 if($response->payload->reward->items === "204281:1"){
     $yellow++;

     $myfile = fopen("links/yellow.txt", "a") or die("Unable to open file!");
     
     fwrite($myfile,'https://apps.facebook.com/family-farm/ar/facebook/get_reward/?vk='. $response->payload->key. '_'. $response->payload->snsid. '___'. $response->payload->type.  "\n\n");
     
     fclose($myfile);

 }else if($response->payload->reward->items === "207687:1"){
     $purple++;

     $myfile = fopen("links/purple.txt", "a") or die("Unable to open file!");
     
     fwrite($myfile,'https://apps.facebook.com/family-farm/ar/facebook/get_reward/?vk='. $response->payload->key. '_'. $response->payload->snsid. '___'. $response->payload->type.  "\n\n");
     
     fclose($myfile);

 }else if($response->payload->reward->items === "209207:1"){
     $heart++;

     $myfile = fopen("links/heart_3.txt", "a") or die("Unable to open file!");
     
     fwrite($myfile,'https://apps.facebook.com/family-farm/ar/facebook/get_reward/?vk='. $response->payload->key. '_'. $response->payload->snsid. '___'. $response->payload->type.  "\n\n");
     
     fclose($myfile);

 }else{
     $other++;
 } 

}else{
    $limit++;
}

}

echo 'yellow --> '. $yellow. "<br><br> purple --> ". $purple. "<br><br> heart --> ". $heart. "<br><br> other --> ". $other. "<br><br> limit --> ". $limit;

?>