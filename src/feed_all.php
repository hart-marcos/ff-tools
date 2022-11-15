<?php
$n = $_GET['n'];

$v = $_GET['v'];

$sr = file_get_contents('sr/'. $v .'/sr' . $n . '.json');

$array = json_decode($sr, true);

$types = json_decode('["t_get_farmclub_final_reward","t_get_mine_woodenChest","t_get_mine_goldenChest","t_get_Refinery_gas","t_water_ranch_lev","t_bingo","t_get_sky_adv_open"]');

$base_url = "";


    function vk(){
    
        $k = '';
        for ($i = 0;$i < 8;$i++)
        {
            $v1 = (1 + mt_rand(0, 10000) / 1000000) * dechex(415030);
            $v2 = floor($v1);
            $v3 = base_convert($v2, 10, 16);
    
            $k .= substr($v3, 1);
    
        }
    
        return $k;
    }

    switch ($v) {
        case 'us':
            $base_url = "https://farm-us.centurygames.com/am/facebook/";
            break;
        case 'th':
            $base_url = "https://farm-th.centurygames.com/en/facebook/";
            break;
        case 'fr':
            $base_url = "https://farm-fr.centurygames.com/en/facebook/";
            break;
    }


    
    foreach ($types as $type)
    {
        $limit = 0;
        $ok = 0;
        $new_urls = [];
        
        $old_urls = file_get_contents("links/". $v. "/" . $type . ".json");
        
        if(!isJson($old_urls)){
         $old_urls='[]';
        }
        
        $array_old = json_decode($old_urls, true);

        $link_nbr = count($array_old) + count($new_urls);
        
        $urls = [];

        if(($link_nbr > 200 && $v == "us") || ($link_nbr > 100 && $v != "us") ){
            echo $type . " --> " . $link_nbr. "   (full) <br>";
            continue;
          }

        foreach ($array as $value)
        {
        
            $key = vk();
            $uid = json_decode(base64_decode(explode(".", $value) [1]))->{'user_id'};
            $hash = md5($uid . '_');
        
            $url_ = $base_url. "get_feed_key/?signed_request=" . $value . '&type=' . $type . '&key=' . $key . '&hash=-' . $hash . '-';
        
            array_push($urls,$url_);
        }

        $nodes = $urls;
        $node_count = count($nodes);

        $curl_arr = array();
        $master = curl_multi_init();

        for($i = 0; $i < $node_count; $i++)
        {
            $url =$nodes[$i];
            $curl_arr[$i] = curl_init($url);
            curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($master, $curl_arr[$i]);
        }

        do {
            curl_multi_exec($master,$running);
        } while($running > 0);


        for($i = 0; $i < $node_count; $i++)
        {
            $response = json_decode(curl_multi_getcontent($curl_arr[$i]));
        
            if (isset($response
                ->payload
                ->reward
                ->items))
            {
        
                if ($type === 't_get_sky_adv_open')
                {
                    if ($response
                        ->payload
                        ->reward->items === '210136:1')
                    {
                        $xx = $base_url. 'get_reward/?vk=' . $response
                            ->payload->key . '_' . $response
                            ->payload->snsid . '___' . $response
                            ->payload->type;
        
                        array_push($new_urls, $xx);
        
                        $ok++;
                    }
                }
                else
                {
        
                    $xx = $base_url. 'get_reward/?vk=' . $response
                        ->payload->key . '_' . $response
                        ->payload->snsid . '___' . $response
                        ->payload->type;
        
                    array_push($new_urls, $xx);
        
                    $ok++;
                }
            }
            else
            {
                $limit++;
            }
        
        }
        
        $final_urls = array_merge($array_old,$new_urls);
        
        $myfile = fopen("links/". $v. "/" . $type . ".json", "w") or die("Unable to open file!");
        
        fwrite($myfile, json_encode($final_urls));
        
        fclose($myfile);
        
        echo $type . " --> " . $ok . "<br><br> limit --> " . $limit. "\n <br>";
        
    }
    
    
function isJson($string) {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}
       

?>