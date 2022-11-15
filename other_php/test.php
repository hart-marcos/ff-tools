<?php

$now = strtotime("now");
$next = $now + 5;

$type_ = $_GET['type'];
$name = '';
$type = '';


switch ($type_)
{
    case "Gasoline1":
        $type = 't_get_farmclub_final_reward';
        $name = 'بنزين';
    break;
    case "superFertilizer":
        $type = 't_get_mine_woodenChest';
        $name = 'سماد خارق';
    break;
    case "superkettle":
        $type = 't_get_mine_goldenChest';
        $name = 'دلو خارق';
    break;
    case "fertilizer":
        $type = 't_get_Refinery_gas';
        $name = 'سماد*25';
    break;
    case "OrganicAquaticFertilizer":
        $type = 't_water_ranch_lev';
        $name = 'سماد مائي';
    break;
    case "BingoGoldenBall":
        $type = 't_bingo';
        $name = 'bingo';
    break;
    case "SkyAdventureEnergy_1":
        $type = 't_get_sky_adv_open';
        $name = 'طاقة جوية';
    break;
}



while(strtotime("now") < $next){


}
// strtotime is a function that will take a string parameter 
// that specifies a date, and returns a unix time stamp bassed
// on that

if(strtotime("now") >= $next){
    echo " تم ارسال  ". $name;
}


?>