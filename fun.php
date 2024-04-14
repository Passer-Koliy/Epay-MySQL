<?php
function daddslashes($string, $force = 1)
{
    if (is_array($string)) {
        $keys = array_keys($string);
        foreach ($keys as $key) {
            $val = $string[$key];
            unset($string[$key]);
            $string[addslashes($key)] = daddslashes($val, $force);
        }
    } else {
        $string = addslashes($string);
    }
    return $string;
}


function wd_http($url, $param = array(), $data = array(), $method = 'GET', $header = '')
{
    $opts = array(
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    );
    $opts[CURLOPT_URL] = empty($param) ? $url : $url . '?' . http_build_query($param);

    if (strtoupper($method) == 'POST') {
        $opts[CURLOPT_POST] = 1;
        $opts[CURLOPT_POSTFIELDS] = $data;
    }
    if ($header) {
        $header = is_array($header) ? $header : array($header);
        $opts[CURLOPT_HTTPHEADER] = array(
            'Content-Type: application/json; charset=utf-8',
        );
        if (is_string($data)) {
            array_push($opts[CURLOPT_HTTPHEADER], 'Content-Length: ' . strlen($data));
        }
        $opts[CURLOPT_HTTPHEADER] = array_merge($opts[CURLOPT_HTTPHEADER], $header);
    }
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    return  $data;
}
