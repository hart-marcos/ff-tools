<?php

$coo1 = "language=4933e4bd3a5c2a2593e9ffa2521a76c3fa1fc359efe4654a9755efc4c38b91b3a%3A2%3A%7Bi%3A0%3Bs%3A8%3A%22language%22%3Bi%3A1%3Bs%3A5%3A%22en-US%22%3B%7D;";
$coo2 = "_csrf=f4806310e210a947b28cb7da03f745e48f0d92d87cdb7cb459657cb1aab6a993a%3A2%3A%7Bi%3A0%3Bs%3A5%3A%22_csrf%22%3Bi%3A1%3Bs%3A32%3A%22EwIJiZ7gfFz9xD93fva0DkGJ8Wt08DmM%22%3B%7D;";
$coo3 = "PHPSESSID=791li10s962pgsj0gn70eghhej";

$post = "_csrf=nL7JSCKCvndh6zH9vgWLcZufo6X8-HpyO-vah-9bm-3ZyYACS9iJEAetS8TGQbJC_enClbiTPTgDvK631x_2oA%3D%3D&LoginForm%5Blogin%5D=hartorito&LoginForm%5Bpassword%5D=Mahmoud-2020&LoginForm%5BrememberMe%5D=0&LoginForm%5BrememberMe%5D=1";

$c = curl_init('https://cronexec.com/index.php/en-US/user/login'); 
curl_setopt($c, CURLOPT_VERBOSE, 1); 
curl_setopt($c, CURLOPT_COOKIE, $coo1. $coo2. $coo3); 
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($c, CURLOPT_POSTFIELDS, $post);
$page = curl_exec($c); 


$last_url = curl_getinfo($c, CURLINFO_EFFECTIVE_URL);

curl_close($c); 

echo $last_url;

?>