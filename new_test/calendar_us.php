<?php


$sr = $_GET["sr"] ?? null;

if($sr === null){
    exit("input error ...");
}

$base_url = "https://farm-us.centurygames.com/ar/facebook/get_feed_key/";

$yellow_ = [];

$purple_ = [];

$heart_ = [];

$others = json_decode("{}");

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
    "Referer: https://farm-th.centurygames.com/?ref=bookmarks&fb_source=web_shortcut&count=660",
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

$limit = [];

for($i = 0; $i < $node_count; $i++)
{
    $response = json_decode(curl_multi_getcontent($curl_arr[$i]));

        if (isset($response
        ->payload
        ->reward
        ->items))
        {
            $link_txt = $response ->payload->linkText;
        
                $xxx = '/ar/facebook/get_reward/?vk=' . $response
                    ->payload->key . '_' . $response
                    ->payload->snsid . '___' . $response
                    ->payload->type;
        
                $item_ = $response ->payload->reward->items;

                switch ($item_) {
                    case "204281:1":
                        $xx = 'https://apps.facebook.com/family-farm'. $xxx;
                        array_push($yellow_, $xx);
                        break;
                    case "207687:1":
                        $xx = 'https://apps.facebook.com/family-farm'. $xxx;
                        array_push($purple_, $xx);
                        break;
                    case "209207:1":
                        $xx = 'https://apps.facebook.com/family-farm'. $xxx;
                        array_push($heart_, $xx);
                        break;
                    default:
                        $u = $response->payload->snsid;
                        $xx = 'https://apps.facebook.com/family-farm'. $xxx;
                       
                       if(isset($others ->$u)){
                           
                           if(isset($others ->$u->$link_txt)){
                               
                               array_push($others ->$u->$link_txt, $xx);
                               
                           }else{
                              
                              $others ->$u->$link_txt =  [$xx];
                               
                           }
                          
                        }else{
                          
                          $others ->$u = new stdClass;
                          
                          $others ->$u->$link_txt =  [$xx];
                          
                        }
                }
            
        }
        else
        {
            $limit[] = $response;
        }

}


$res_["yellow"] = $yellow_;
$res_["purple"] = $purple_;
$res_["heart"] = $heart_;
$res_["others"] = $others;
$res_["limit"] = $limit;

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


