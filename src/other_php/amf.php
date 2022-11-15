<?php

header('Content-Type: application/x-amf');

$url = "https://restninja.io/in/proxy";
$post_fields = file_get_contents('php://input');
$headers = ['request: eyJtZXRob2QiOiJQT1NUIiwidXJpIjoiaHR0cDovL2Zhcm0tdXMuZnVucGx1c2dhbWUuY29tL2dhdGV3YXkucGhwIiwiaGVhZGVycyI6eyJDb25uZWN0aW9uIjoia2VlcC1hbGl2ZSIsIkNvbnRlbnQtTGVuZ3RoIjoiNTI1Iiwic2VjLWNoLXVhIjoiXCIgTm90IEE7QnJhbmRcIjt2PVwiOTlcIiwgXCJDaHJvbWl1bVwiO3Y9XCI5MlwiLCBcIk9wZXJhIEdYXCI7dj1cIjc4XCIiLCJzZWMtY2gtdWEtbW9iaWxlIjoiPzAiLCJVc2VyLUFnZW50IjoiTW96aWxsYS81LjAgKFdpbmRvd3MgTlQgMTAuMDsgV2luNjQ7IHg2NCkgQXBwbGVXZWJLaXQvNTM3LjM2IChLSFRNTCwgbGlrZSBHZWNrbykgQ2hyb21lLzkyLjAuNDUxNS4xMzEgU2FmYXJpLzUzNy4zNiBPUFIvNzguMC40MDkzLjE4NiIsIkNvbnRlbnQtVHlwZSI6ImFwcGxpY2F0aW9uL3gtYW1mIiwiQWNjZXB0IjoiKi8qIiwiT3JpZ2luIjoiaHR0cHMiLCJTZWMtRmV0Y2gtU2l0ZSI6InNhbWUtb3JpZ2luIiwiU2VjLUZldGNoLU1vZGUiOiJjb3JzIiwiU2VjLUZldGNoLURlc3QiOiJlbXB0eSIsIlJlZmVyZXIiOiJodHRwcyIsIkFjY2VwdC1FbmNvZGluZyI6Imd6aXAsIGRlZmxhdGUsIGJyIiwiQWNjZXB0LUxhbmd1YWdlIjoiZW4tR0IsZW4tVVM7cT0wLjksZW47cT0wLjgifSwiYXV0aCI6eyJfdCI6Ik5vbmUifX0='];

echo cUrlGetData($url, $post_fields, $headers);

function cUrlGetData($url, $post_fields = null, $headers = null) {

    $ch = curl_init();
    $timeout = 10;
    curl_setopt($ch, CURLOPT_URL, $url);

    if (!empty($post_fields)) {

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    }

    if (!empty($headers))
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);

    if (curl_errno($ch)) {

        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);
    return $data;
}

?>