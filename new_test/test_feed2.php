<?php

$sr = json_decode($_POST["sr"]);

$url = $_POST["url"];

$node_count = count($sr);

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


for ($i = 0; $i < $node_count; $i++) {
    $req = [
        "signed_request" => $sr[$i],
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

    $get = [];
    $limit = [];

for ($i = 0; $i < $node_count; $i++) {
    $response = curl_multi_getcontent($curl_arr[$i]);

    // $limit++;
    //$key = "response[". $i. "]";

    if(strpos($response, 'just accepted')){
      $get[] = "success";
    }else{
      $limit[] = "limit";
    }
}

    $res_ = [
      "success" => count($get),
      "limit" => count($limit),
    ];

echo json_encode($res_);

