<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once MODPATH . 'core/controllers/nova_login.php';
require_once __DIR__ . '/../includes/System.php';

class __extensions__nova_ext_discord_account_confirmation__Discord extends Nova_login
{
    public function __construct()
    {
        parent::__construct();

        $this->ci = & get_instance();
         $this->system = new \nova_ext_discord_account_confirmation\System();

        $this->_regions['nav_sub'] = Menu::build('adminsub', 'manageext');
        //$this->_regions['nav_sub'] = Menu::build('sub', 'sim');
        

        
    }



public function login()
{


     $extConfigFilePath = dirname(__FILE__) . '/../config.json';

        if (!file_exists($extConfigFilePath))
        {
            return [];
        }
        $file = file_get_contents($extConfigFilePath);
        $data['jsons'] = json_decode($file, true);

       $redirect= site_url('extensions/nova_ext_discord_account_confirmation/Discord/redirect');
       $client_id= $data['jsons']['setting']['api_key'];
       $url= "https://discord.com/api/oauth2/authorize?response_type=code&client_id=$client_id&scope=identify%20guilds.join&state=15773059ghq9183habn&redirect_uri=$redirect&prompt=consent";
        redirect($url);
}


public function redirect()
{   

    


    // redirect(site_url('/login/index'));



        $code= $_REQUEST['code'];
         $redirect= site_url('extensions/nova_ext_discord_account_confirmation/Discord/redirect');
       $apiResult= $this->system->redirectUrl($code,$redirect);
       if(isset($apiResult['discord_id']))
        {
        
        $discord_id = $apiResult['discord_id'];

       
        $this->db->from('users');
        $this->db->where('discord_id', $discord_id);
        $query = $this->db->get();
        if ($query->num_rows() == 0)
        {
             $retval = 2;
            redirect('login/index/error/'.$retval, 'refresh');
        }

       $person= $query->row();
            $login = Auth::login($person->email, $person->password, true);
            if ($login > 0)
        {
            $this->session->set_flashdata('email', $email);
            
            redirect('login/index/error/'.$login, 'refresh');
        }
     $data['header'] = lang('head_login_success');
        $data['message'] = sprintf(
            lang('login_message'),
            anchor('admin/index', lang('labels_controlpanel'))
        );
        
        $this->_regions['content'] = Location::view('login_success', $this->skin, 'login', $data);
        $this->_regions['title'].= ucfirst(lang('head_login_success'));
        $this->_regions['_redirect'] = Template::add_redirect('admin/index');
        
        Template::assign($this->_regions);
        
        Template::render();
}else {

}
      
}

}
