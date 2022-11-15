<?php

$n = $_POST['n'];

$toids = $_POST['ids'];

$item_id = $_POST["item_id"];

$sr = file_get_contents('new_ids/ids' . $n . '.json');

$array = json_decode($sr, true);

$ids = "";

$ok = 0;

$base_url = 'https://farm-us.centurygames.com/index.php/gifts/addgiftdata/';

$arr = json_decode($toids);

foreach ($arr as $id_) {
    $ids = $ids. "&ids[]=". $id_;
}


$urls = [];

foreach ($array as $userid){

    $post = [
    'giftid' => $item_id,
    'tm' => time(),
    'appuserid'   => $userid,
    'requestid'   => "system_39c0". generateRandomString(),
    ];

    $data[] = http_build_query($post). $ids;

}

//echo "\n".$urls[0];

$node_count = count($array);

$curl_arr = array();
$master = curl_multi_init();

$headers = [
    'Connection: keep-alive',
    'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="99", "Opera GX";v="85"',
    'Content-Type: application/x-www-form-urlencoded',
    'X-Requested-With: XMLHttpRequest',
    'sec-ch-ua-mobile: ?0',
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84     Safari/537.36 OPR/85.0.4341.72',
    'sec-ch-ua-platform: "Windows"',
    'Origin: https://farm-us.centurygames.com',
    'Sec-Fetch-Site: same-origin',
    'Sec-Fetch-Mode: cors',
    'Sec-Fetch-Dest: empty',
    'Referer: https://farm-us.centurygames.com/?ref=bookmarks&fb_source=web_shortcut&count=660',
    'Accept-Language: en-GB,en-US;q=0.9,en;q=0.8'
  ];

for($i = 0; $i < $node_count; $i++)
{
    $url =$base_url;
    $curl_arr[$i] = curl_init($url);
    curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_arr[$i], CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl_arr[$i], CURLOPT_POST, true);
    curl_setopt($curl_arr[$i], CURLOPT_POSTFIELDS, $data[$i]);
    curl_multi_add_handle($master, $curl_arr[$i]);
}

$running = null;

do {
   $status =  curl_multi_exec($master,$running);
} while($status === CURLM_CALL_MULTI_PERFORM || $running);

$null =0;

$res_ = [];

for($i = 0; $i < $node_count; $i++)
{
    $response = curl_multi_getcontent($curl_arr[$i]);

           // $limit++;
          $key = "response[". $i. "]";
          $res_[$key] = $response;


}

$res_["done"] = count($res_);

echo json_encode($res_);


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