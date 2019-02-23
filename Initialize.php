<?php
$API_KEY = "Your API_KEY";
$SECRECT_KEY="Your SECRECT_KEY";
$USERNAME="Your Username";
$PASSWORD="Your Password";

function callAPI($method, $url, $data){
   $curl = curl_init();

   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }

   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}

$data_array =  array(
      "ApiKey"        => $API_KEY,
      "SecretKey"        => $SECRECT_KEY,
      "Username"        => $USERNAME,
      "Password"        => $PASSWORD      
);

$make_call = callAPI('POST', 'http://api.terragreen.io/api/Wallet/Initialize', json_encode($data_array));

$response = json_decode($make_call, true);
$access_token=$response['access_token'];
$token_type=$response['token_type'];
$expires_in=$response['expires_in'];
$userName=$response['userName'];
$issued=$response['.issued'];
$expires=$response['.expires'];

?>