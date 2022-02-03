<?php
namespace nova_ext_discord_account_confirmation;

class System {
	
	public function __construct() {
		$this->ci =& get_instance();

		
	}


	
    public function redirectUrl($code,$redirect)
    {



        $extConfigFilePath = dirname(__FILE__) . '/../config.json';

        if (!file_exists($extConfigFilePath))
        {
            return [];
        }
        $file = file_get_contents($extConfigFilePath);
        $json = json_decode($file, true);





$apiToken= $json['setting']['apiToken'];
$apiKey= $json['setting']['api_key'];
$gameToken=urlencode($json['setting']['gameToken']);
$secretApi=$json['setting']['secretApi'];

$secretUrl="$secretApi?apiToken=$apiToken&botClient=$apiKey&gameToken=$gameToken";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$secretUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$secret = curl_exec($ch);
curl_close($ch);


$secret= trim($secret, '""');
if(!empty($secret))
{

$url = 'https://discord.com/api/oauth2/token';
 $data = [
    'client_id'=> $apiKey,
    'client_secret'=> $secret,
    'grant_type'=> 'authorization_code',
    'code'=> $code,
    'redirect_uri'=> $redirect
  ];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,
            $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close($ch);
$result= json_decode($server_output);

if(!isset($result->error))
{


$accesToken= $result->access_token;
$url="https://discord.com/api/oauth2/@me";
 $ch = curl_init();

$authorization = "Authorization: Bearer $accesToken";
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$apiresult= json_decode($response);
if(isset($apiresult->user->id))
{


 $output['discord_id']=$apiresult->user->id;


}else {
     $output['error']= "Something Went Wrong";
}

}else {

    $output['error']= $result->error;
    
}   
}else {
    $output['error']= "Secret is empty";
}
return $output;
}

	
}
