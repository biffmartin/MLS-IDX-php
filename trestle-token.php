<?php

use \Firebase\JWT\JWT;

$curl = curl_init();
$err     = curl_errno($curl);
$errmsg  = curl_error($curl) ;

/* Sample Data Feed - WebAPI 
Notes:  Author:  Bare Wire Networks Corp
        Website: www.barewirenetworks.com
        Usage:  include 'trestle-token.php'
		then read the file called aaa.out
		get your credentials from Trestle/CoreLogic First.
*/
$data = array(
    "client_id" => "your client ID goes here. ",
    "client_secret" => "your client secret goes here. copy + paste ",
    "scope" => "api",
    "grant_type" => "client_credentials"
);

$mydata = http_build_query($data);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-prod.corelogic.com/trestle/oidc/connect/token',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_POST => 1,
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 60,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => $mydata,
  CURLOPT_HTTPHEADER => array(
    'cache-control: no-cache',
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);
$err     = curl_errno($curl);
$errmsg  = curl_error($curl) ;

/*
echo "\nresponse: ";
echo $response;
echo "\nerr:";
echo $err;
echo "\nerrmsg:";
echo $errmsg;
echo "\n";
*/

$auth = json_decode($response);
if ($response == NULL) {
   echo $err;
   echo $errmsg;
   die("failure");
}

$myfile = fopen("aaa.out", "w") or die("Unable to open file!");
fwrite($myfile, "access_token:".$auth->{'access_token'});
fclose($myfile);

?>
