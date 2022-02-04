<?php 
$this->require_extension('jquery');


require_once dirname(__FILE__).'/events/location_login_index.php';

require_once dirname(__FILE__) . '/controllers/Installer.php';
$manager = ( new \nova_ext_discord_account_confirmation\Installer() )->install();
