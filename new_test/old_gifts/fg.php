<?php

$toids = $_POST['ids'];

$item_id = $_POST["item_id"];

$num = $_POST["num"];

$ids = "";

$data_ = file_get_contents("data.json");

$users = json_decode($data_);

if(isset($users->$toids)){

    $from = $users->$toids;

}else{

    $from = 0;
}

$to = $num;

if((intval($from/1000) == intval(($to+$from)/1000))){
   $n = intval($from/1000)+1;
}else{
  $n = intval(($from+$to)/1000);
  $from = intval($to/1000)*1000;
}


$sr = file_get_contents('ids/ids' . $n . '.json');

$array = json_decode($sr, true);


$base_url = 'https://farm-us.centurygames.com/index.php/gifts/addgiftdata/';

$need = array_slice($array,($from%1000),$to);

$urls = [];

foreach ($need as $userid){

    $post = [
    'giftid' => $item_id,
    'tm' => time(),
    'appuserid'   => $userid,
    'requestid'   => "system_39c0". generateRandomString(),
    'ids[]'   => $toids
    ];

    $data[] = http_build_query($post);

}


$node_count = count($need);

$curl_arr = array();
$master = curl_multi_init();

for($i = 0; $i < $node_count; $i++)
{
    $curl_arr[$i] = curl_init($base_url);
    curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_arr[$i], CURLOPT_POST, true);
    curl_setopt($curl_arr[$i], CURLOPT_POSTFIELDS, $data[$i]);
    curl_multi_add_handle($master, $curl_arr[$i]);
}

do {
   $status =  curl_multi_exec($master,$running);
} while($running > 0);

$null =0;

$done = 0;

$res_ = [];

for($i = 0; $i < $node_count; $i++)
{
   // echo curl_multi_getcontent($curl_arr[$i]);
    $response = curl_multi_getcontent($curl_arr[$i]);

           // $limit++;
          $key = "response[". $i. "]";
          $res_[$key] = $response;
          if($response == "success"){
            $done = $done+1;  
          }


}
$res_["update"] = update_nbr($toids,($from+$num));

$res_["done"] = $done;

echo json_encode($res_);


function update_nbr($id,$new){

    $old_ = file_get_contents("data.json");

    $data = json_decode($old_);

    $data ->$id = $new;


    $myfile = fopen("data.json", "w") or die("Unable to open file!");

    fwrite($myfile, json_encode($data));
    fclose($myfile);

    return "OK -> ".$new;
}

function generateRandomString($length = 16) {
    $characters = '0123456789abcdef';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>