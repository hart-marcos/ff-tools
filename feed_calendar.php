<?php

$n = date('h')%2;

$sr = file_get_contents('sr/sr_cal.json');

$array = json_decode($sr, true);

echo "File ".$n."\n";

$type = "t_calendar_everday_reward";

$yellow_ = [];

$purple_ = [];

$heart_ = [];

$others = json_decode(file_get_contents("calendar/us/others.json"));

$limit = 0;

$ok = 0;

$base_url = 'https://farm-us.centurygames.com/ar/facebook/get_feed_key/?signed_request=';


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
		
    function final_ ($type_,$new){
        
        if($type_ == "others"){
            
            $myfile = fopen("calendar/us/" . $type_ . ".json", "w") or die("Unable to open file!");
		    
		    fwrite($myfile, json_encode($new));
		   
		    fclose($myfile);
            
        }else{
        
            if(count($new) !== 0){
		    	
		    	$old = json_decode(file_get_contents("calendar/us/". $type_. ".json"));
		    	
		    	$myfile = fopen("calendar/us/" . $type_ . ".json", "w") or die("Unable to open file!");
            
                $final_urls = array_merge($old,$new);
		    	
		    	fwrite($myfile, json_encode($final_urls));
		    
		    	fclose($myfile);
		    
            }
        
        }	
	}

$urls = [];

foreach ($array as $value)
{

    $key = vk();
    $uid = json_decode(base64_decode(explode(".", $value) [1]))->{'user_id'};
    $hash = md5($uid . '_');

    $url_ = $base_url . $value . '&type=' . $type . '&key=' . $key . '&hash=-' . $hash . '-';

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

$null =0;

for($i = 0; $i < $node_count; $i++)
{
   // echo curl_multi_getcontent($curl_arr[$i]);
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
                        $xx = 'https://farm-us.centurygames.com'. $xxx;
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

            
                $ok++;
            
        }
        else
        {
            $limit++;
          //  echo "response[". $i. "] -> ". $response. " <br>";
        }

}

        final_("yellow",$yellow_);
		final_("purple",$purple_);
		final_("heart",$heart_);
		final_("others",$others);
		
           
           /**/
           
        echo " yellow -> " . count($yellow_)." purple -> " . count($purple_). " heart -> " . count($heart_)."<br><br> limit --> " . $limit. "\n <br>";

?>