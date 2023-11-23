<?php
$curl = curl_init();
$base_url = "https://taxinformation.cbic.gov.in/api/cbic-notification-msts/";
$year=2017;
$current_year = date("Y");
$count=$current_year-2017+1;
$counter=1;
$jsonData = [];
while ($counter<$count){
$urls=[$base_url."fetchNotificationByYearAndCategory?page=0&size=200&taxId=1000001&category=Integrated%20Tax"
];
  $results=[];
$counter1=count($urls)-1;
for($i=0; $i<=$counter; $i++ ){
  $fullUrl = $base_url . $urls[$i] . "&year=$year";
curl_setopt_array($curl, [CURLOPT_URL=>$fullUrl,  CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'GET',
CURLOPT_HTTPHEADER => array(
  'Accept: application/json, text/plain, */*',
  'Accept-Language: en-US,en;q=0.9',
  'Cache-Control: no-cache',
  'Connection: keep-alive',
  'Pragma: no-cache',
  'Referer: https://taxinformation.cbic.gov.in/content-page/explore-notification',
  'Sec-Fetch-Dest: empty',
  'Sec-Fetch-Mode: cors',
  'Sec-Fetch-Site: same-origin',
  'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
  'language: en',
  'sec-ch-ua: "Chromium";v="112", "Google Chrome";v="112", "Not:A-Brand";v="99"',
  'sec-ch-ua-mobile: ?0',
  'sec-ch-ua-platform: "Windows"'
),
]);

$response = curl_exec($curl);
//echo $response;
if($response !== false){
  $json=json_decode($response,true);

if($json !== null){
  $result[$year]=$json;
}
//echo '<pre>';
//print_r($json);
//echo '</pre>';
$year++;
$counter++;
  }
}
}
$base_url='http://vinfur.in';
header("Content-Type: text/xml;charset=iso-8859-1");
echo "<?xml version='1.0' encoding='UTF-8' ?>" . PHP_EOL;
echo "<rss version='2.0'>".PHP_EOL;
echo "<channel>".PHP_EOL;
echo "<title>Central Tax Notification | RSS</title>".PHP_EOL;
echo "<link>".$base_url."index.php</link>".PHP_EOL;
echo "<description>Central Tax Notification</description>".PHP_EOL;
echo "<language>en-us</language>".PHP_EOL;


$counter=count($json)-1;

for($i=0;$i<=$counter;$i++){
  echo "<item>".PHP_EOL;
  echo "<title>".clean($json[$i]['notificationName'])."</title>".PHP_EOL;
 
  echo "<link>https://old.cbic.gov.in/resources//htdocs-cbec/gst/".$json[$i]['docFileName']."</link>".PHP_EOL;
  echo "<guid>https://old.cbic.gov.in/resources//htdocs-cbec/gst/".$json[$i]['docFileName']."</guid>".PHP_EOL;
  //echo "<pubDate>".$json[$i]['notificationDt']."</pubDate>".PHP_EOL;
  //echo "<description><![CDATA[".substr($row["post_description"], 0, 300) ."]]></description>".PHP_EOL;
  /*  echo "<dc:creator>".$row["author"]."</dc:creator>".PHP_EOL;
  
  echo "<enclosure url='images/".$row["post_image"]."' length='".$image_size."' type='".$image_mime."' />".PHP_EOL;
  echo "<category>PHP tutorial</category>".PHP_EOL;   */
  echo "</item>".PHP_EOL;

}
  echo '</channel>'.PHP_EOL;
  echo '</rss>'.PHP_EOL;
  
  curl_close($curl);
function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
 
    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
 }