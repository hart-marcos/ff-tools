<?php
$n = $_GET['n'];

$sr = file_get_contents('sr/sr' . $n . '.json');

$type_ = $_GET['type'];

$limit = 0;
$ok = 0;

$new_urls = [];

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

$array = json_decode($sr, true) ['sr'];

foreach ($array as $value)
{

    $key = vk();
    $uid = json_decode(base64_decode(explode(".", $value) [1]))->{'user_id'};
    $hash = md5($uid . '_');

    $response = json_decode(file_get_contents('https://farm-us.centurygames.com/ar/facebook/get_feed_key/?signed_request=' . $value . '&type=' . $type . '&key=' . $key . '&hash=-' . $hash . '-'));

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
                $xx = 'https://farm-us.centurygames.com/ar/facebook/get_reward/?vk=' . $response
                    ->payload->key . '_' . $response
                    ->payload->snsid . '___' . $response
                    ->payload->type;

                array_push($new_urls, $xx);

                $ok++;
            }
        }
        else
        {

            $xx = 'https://farm-us.centurygames.com/ar/facebook/get_reward/?vk=' . $response
                ->payload->key . '_' . $response
                ->payload->snsid . '___' . $response
                ->payload->type;

            array_push($new_urls, $xx);
        }
    }

}

echo json_encode($new_urls);

?>