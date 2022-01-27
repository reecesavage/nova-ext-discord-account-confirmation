<?php 
$this->require_extension('jquery');




require_once dirname(__FILE__) . '/controllers/Installer.php';
$manager = ( new \nova_ext_discord_account_confirmation\Installer() )->install();
