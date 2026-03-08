<?php
function MloocCurl($url,$method,$ifurl,$post_data,$mobile=false){
    $UserAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36';#设置ua
    if($mobile){
        $UserAgent = 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Mobile Safari/537.36';
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, $UserAgent);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if ($method == "post") {
        curl_setopt($curl, CURLOPT_REFERER, $ifurl); 
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    }
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
$res = MloocCurl("https://github.com/AngelShadow2017/Love_Music",false,false,false);
//print_r($res);
//<a class="js-navigation-open link-gray-dark"
$ruleMatchDetailInList = "/a class=\"js-navigation-open link-gray-dark[\s\S]*?a>/i";
preg_match_all($ruleMatchDetailInList, $res,$matchData);
$matchData = $matchData[0];
$cnt = count($matchData);
for($i = 0;$i<$cnt;$i++){
    $matchData[$i] = explode("</a",explode(">",$matchData[$i])[1])[0];
}
print_r($matchData);
$filename = "songData.json";
$needInformationArr = $matchData;
//print_r($needInformationArr);
$songs = json_encode($needInformationArr);
file_put_contents($filename,$songs);
echo $songs;
?>