<?php 

$this->event->listen(['location', 'view', 'output', 'login', 'login_index'], function($event){



 $extConfigFilePath = dirname(__FILE__).'/../config.json';
         
        if ( file_exists( $extConfigFilePath ) ) { 
            $file = file_get_contents( $extConfigFilePath );
            $json = json_decode( $file, true );
    }

    if(!empty($json['setting']['bot_name']))
    {
  switch($this->uri->segment(4)){
    case 'view':
      break;
    default: 
              
                $event['output'] .= $this->extension['jquery']['generator']
                      ->select('.button-main')
                      ->after(
                        $this->extension['nova_ext_discord_account_confirmation']
                             ->view('_form', $this->skin, 'main', $event['data'])
                      );
      
 }
}
});
