<?php

$base_url = "https://farm-us.centurygames.com/ar/facebook/get_feed_key/";

$sr = $_GET["sr"];

$node_count = 50;

$uid = json_decode(base64_decode(explode(".", $sr) [1]))->{'user_id'};
            $hash = md5($uid . '_');

$curl_arr = [];
$master = curl_multi_init();

$headers = [
    "Connection: keep-alive",
    'sec-ch-ua: " Not A;Brand";v="99", "Chromium";v="99", "Opera GX";v="85"',
    "Content-Type: application/x-www-form-urlencoded",
    "X-Requested-With: XMLHttpRequest",
    "sec-ch-ua-mobile: ?0",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84     Safari/537.36 OPR/85.0.4341.72",
    'sec-ch-ua-platform: "Windows"',
    "Origin: https://farm-us.centurygames.com",
    "Sec-Fetch-Site: same-origin",
    "Sec-Fetch-Mode: cors",
    "Sec-Fetch-Dest: empty",
    "Referer: https://farm-us.centurygames.com/?ref=bookmarks&fb_source=web_shortcut&count=660",
    "Accept-Language: en-GB,en-US;q=0.9,en;q=0.8",
];

$url = $base_url;

for ($i = 0; $i < $node_count; $i++) {
    $req = [
        "signed_request" => $sr,
        "type" => "t_calendar_everday_reward",
        "key" => vk(),
        "hash" => "-". $hash. "-",
    ];
    $curl_arr[$i] = curl_init($url);
    curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl_arr[$i], CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl_arr[$i], CURLOPT_POST, true);
    curl_setopt($curl_arr[$i], CURLOPT_POSTFIELDS, http_build_query($req));
    curl_multi_add_handle($master, $curl_arr[$i]);
}

$running = null;

do {
    $status = curl_multi_exec($master, $running);
} while ($status === CURLM_CALL_MULTI_PERFORM || $running);

$null = 0;

$res_ = [];

$other = [];
$limit = [];
$yellow = [];

for ($i = 0; $i < $node_count; $i++) {
    $response = curl_multi_getcontent($curl_arr[$i]);

  $res = json_decode($response);

  if($res !== null && $res->ok && isset($res->payload) && isset($res->payload->reward)){

    if($res->payload->reward->items == "204281:1"){
      $xxx = '/ar/facebook/get_reward/?vk=' . $res
                    ->payload->key . '_' . $res
                    ->payload->snsid . '___' . $res
                    ->payload->type;
      $link = 'https://apps.facebook.com/family-farm'. $xxx;
      $yellow[] = $link;
    }else{
      $other[] = $res;
    }
    
    }else{
      $limit[] = $res;
    }
  
}

$res_ = [
      "yellow" => $yellow,
      "others" => $other,
      "limit" => $limit,
    ];

echo json_encode($res_);

function vk()
{
    $k = "";
    for ($i = 0; $i < 8; $i++) {
        $v1 = (1 + mt_rand(0, 10000) / 1000000) * dechex(415030);
        $v2 = floor($v1);
        $v3 = base_convert($v2, 10, 16);

        $k .= substr($v3, 1);
    }

    return $k;
}
