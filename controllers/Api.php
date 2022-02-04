<?php 


error_reporting(E_ERROR | E_PARSE);
define('INSTALL_ROOT', str_replace('\\', '/', realpath(dirname(__FILE__))).'/nova/');

$system_path = INSTALL_ROOT.'ci';
define('BASEPATH', str_replace("\\", "/", $system_path));
require_once __DIR__ . '/../../../config/database.php';

$prefix=$db['default']['dbprefix'];
$database=$db['default']['database'];
$username=$db['default']['username'];
$password= $db['default']['password'];
$data['status']='NOK';

 $extConfigFilePath = dirname(__FILE__) . '/../config.json';
        if (!file_exists($extConfigFilePath))
        {
           $data['error']='Config json not exist';
           echo json_encode($data);exit;
        }
        $file = file_get_contents($extConfigFilePath);
        $jsons = json_decode($file, true);

      
    if($jsons['setting']['apiToken']==$_GET['api_token'])
      {
        $conn = new mysqli("localhost",$username,$password,$database);

      if ($conn ->connect_errno)
         {
           $data['error']="Failed to connect to MySQL: " . $conn ->connect_error;
           echo json_encode($data);exit;
        }
        $sql="Select * from {$prefix}users where status='active'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $i=0;
            $data['status']='OK';
            while($row = $result->fetch_assoc()) {
                 $data['details'][$i]['name']= $row['name'];
                 $data['details'][$i]['discord_id']= $row['discord_id'];
                  $i++;
              }

        }else {
          $data['error']="No user Found";
        }
       }else {
        $data['error']="Token Missmatch";
    }


echo json_encode($data);exit;

?>
