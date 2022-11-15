<?php
$n = $_GET['n'];

$sr = file_get_contents('sr/sr' . $n . '.json');

$array = json_decode($sr, true) ['sr'];

$types = json_decode('["t_get_farmclub_final_reward","t_get_mine_woodenChest","t_get_mine_goldenChest","t_get_Refinery_gas","t_water_ranch_lev","t_bingo","t_get_sky_adv_open"]');


$url = '3.230.168.217/ar/facebook/';


    function vk()
    {
    
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


    
    foreach ($types as $type)
    {
        $limit = 0;
        $ok = 0;
        $new_urls = [];
        
        $old_urls = file_get_contents("links/" . $type . ".json");
        
        $array_old = json_decode($old_urls, true);
        
        
        
        foreach ($array as $value)
        {
            
           $link_nbr = count($array_old) + count($new_urls);
            
          if($link_nbr > 123){
            break;
          }
        
            $key = vk();
            $uid = json_decode(base64_decode(explode(".", $value) [1]))->{'user_id'};
            $hash = md5($uid . '_');
        
            $response = json_decode(get_web_page($url. 'get_feed_key/?signed_request=' . $value . '&type=' . $type . '&key=' . $key . '&hash=-' . $hash . '-'));
        
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
                        $xx = $url. 'get_reward/?vk=' . $response
                            ->payload->key . '_' . $response
                            ->payload->snsid . '___' . $response
                            ->payload->type;
        
                        array_push($new_urls, $xx);
        
                        $ok++;
                    }
                }
                else
                {
        
                    $xx = $url. 'get_reward/?vk=' . $response
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
        
        $myfile = fopen("links/" . $type . ".json", "w") or die("Unable to open file!");
        
        fwrite($myfile, json_encode($final_urls));
        
        fclose($myfile);
        
        echo $type . " --> " . $ok . "<br><br> limit --> " . $limit. "\n <br>";
        
    }
    
function get_web_page($url) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 30,    // time-out on connect
        CURLOPT_TIMEOUT        => 3,    // time-out on response
    ); 

    $ch = curl_init($url);
    curl_setopt_array($ch, $options);

    $content  = curl_exec($ch);

    curl_close($ch);

    return $content;
}
    

?>
