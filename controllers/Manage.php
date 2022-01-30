<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once MODPATH . 'core/libraries/Nova_controller_admin.php';

class __extensions__nova_ext_discord_account_confirmation__Manage extends Nova_controller_admin
{
    public function __construct()
    {
        parent::__construct();

        $this->ci = & get_instance();
        $this->_regions['nav_sub'] = Menu::build('adminsub', 'manageext');
        //$this->_regions['nav_sub'] = Menu::build('sub', 'sim');
        

        
    }

    public function getQuery($switch)
    {
       $prefix= $this->db->dbprefix;

             
        switch ($switch)
        {   



            case 'discord_id':
                $sql = "ALTER TABLE {$prefix}users ADD COLUMN discord_id VARCHAR(255) DEFAULT NULL";
            break;

          

            default:
            break;
        }
        return isset($sql) ? $sql : '';
    }


    public function saveColumn($requiredCharacterFields)
    {
        $prefix= $this->db->dbprefix;


        if (isset($_POST['submit']) && $_POST['submit'] == 'Add')
        {
            $attr = isset($_POST['attribute']) ? $_POST['attribute'] : '';


            if (in_array($attr, $requiredCharacterFields['user']) == true)
            {
                $table = "{$prefix}users";

            }
            if (!empty($table))
            {

                if (!$this
                    ->db
                    ->field_exists($attr, $table))
                {
                    $sql = $this->getQuery($attr);
                    if (!empty($sql))
                    {
                        $query = $this
                            ->db
                            ->query($sql);

                        if (($key = array_search($attr, $requiredCharacterFields['user'])) !== false)
                        {
                            unset($requiredCharacterFields['user'][$key]);
                        }

                       
                        $list['user'] = $requiredCharacterFields;
                      
                        return $list;
                    }
                }

            }
        }

        return false;

    }

    public function config()
    {    
         
          Auth::check_access('site/settings');
        $data['title'] = 'Discord Account Setting';
        $requiredCharacterFields['user'] = ['discord_id'];

 
       

        if ($list = $this->saveColumn($requiredCharacterFields))
        {
            $requiredCharacterFields = $list['user'];
           
            $message = sprintf(lang('flash_success') ,
            // TODO: i18n...
            'Column Added successfully', '', '');

            $flash['status'] = 'success';
            $flash['message'] = text_output($message);

            $this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
        }

        $extConfigFilePath = dirname(__FILE__) . '/../config.json';

        if (!file_exists($extConfigFilePath))
        {
            return [];
        }
        $file = file_get_contents($extConfigFilePath);
        $data['jsons'] = json_decode($file, true);
        if (isset($_POST['submit']) && $_POST['submit'] == 'Submit')
        {

              $data['jsons']['setting']['apiToken'] = $_POST['apiToken'];
              

            $jsonEncode = json_encode($data['jsons'], JSON_PRETTY_PRINT);

            file_put_contents($extConfigFilePath, $jsonEncode);

            $message = sprintf(lang('flash_success') ,
            // TODO: i18n...
            'Configuration', lang('actions_updated') , '');

            $flash['status'] = 'success';
            $flash['message'] = text_output($message);

            $this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);

        }

       

     $prefix= $this->db->dbprefix;
     $table= "{$prefix}users";
     $charFields = $this
            ->db
            ->list_fields("$table");
       
        
      
        $leftFields = [];
        foreach ($requiredCharacterFields['user'] as $key)
        {
            if (in_array($key, $charFields) == false)
            {
                $leftFields[] = $key;
            }
        }
       
        $data['fields'] = $leftFields;

      
        $this->_regions['title'] .= 'Discord Account Setting';
        $this->_regions['content'] = $this->extension['nova_ext_discord_account_confirmation']
            ->view('config', $this->skin, 'admin', $data);

        Template::assign($this->_regions);
        Template::render();
    }



    public function discord()
    {

         Auth::check_access('site/settings');
        $data['title'] = 'Discord Setting';


          $extConfigFilePath = dirname(__FILE__) . '/../config.json';

        if (!file_exists($extConfigFilePath))
        {
            return [];
        }
        $file = file_get_contents($extConfigFilePath);
        $data['jsons'] = json_decode($file, true);

      
      if (isset($_POST['submit']) && $_POST['submit'] == 'Submit')
        {  

          $redirect= site_url('extensions/nova_ext_discord_account_confirmation/Manage/redirect');
       $client_id= $data['jsons']['setting']['api_key'];
       $url= "https://discord.com/api/oauth2/authorize?response_type=code&client_id=$client_id&scope=identify%20guilds.join&state=15773059ghq9183habn&redirect_uri=$redirect&prompt=consent";
        redirect($url);
        }

         $id = $this->session->userdata('userid');
         $user=  $this->user->get_user($id);
        $data['userModel']=$user;
        $this->_regions['title'] .= 'Discord Setting';
        $this->_regions['content'] = $this->extension['nova_ext_discord_account_confirmation']
            ->view('discord', $this->skin, 'admin', $data);
        
        Template::assign($this->_regions);
        Template::render();
    }

     public function redirect()
    {  

         $id = $this->session->userdata('userid');
         $user=  $this->user->get_user($id);
          
         $code= $_REQUEST['code'];

           $extConfigFilePath = dirname(__FILE__) . '/../config.json';

        if (!file_exists($extConfigFilePath))
        {
            return [];
        }
        $file = file_get_contents($extConfigFilePath);
        $json = json_decode($file, true);

        $encryption=$json['setting']['secret_key'];

        $ciphering = "AES-128-CTR";
  
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;


// Non-NULL Initialization Vector for decryption
$decryption_iv = '1234567891011121';
  
// Store the decryption key
$decryption_key = "Nova";
  
// Use openssl_decrypt() function to decrypt the data
$decryption=openssl_decrypt ($encryption, $ciphering, 
        $decryption_key, $options, $decryption_iv);



          
$url = 'https://discord.com/api/oauth2/token';
$redirect= site_url('extensions/nova_ext_discord_account_confirmation/Manage/redirect');
 $data = [
    'client_id'=> $json['setting']['api_key'],
    'client_secret'=> $decryption,
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

$this->user->update_user($id, ['discord_id'=>$apiresult->user->id]);

$this->session->set_flashdata('success', "Discord id saved successfully");

}else {
    $this->session->set_flashdata('error', "Something Went Wrong");
}

}else {


     $this->session->set_flashdata('error', "$result->error");
}
 
redirect(site_url('extensions/nova_ext_discord_account_confirmation/Manage/discord'));
}

}
