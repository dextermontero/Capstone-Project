<?php
$conn = new mysqli('mysql5047.site4now.net','a7d59c_embat','Embat@143','db_a7d59c_embat');
if(mysqli_connect_error()){
	die("Database Connection Lost : ". mysqli_connect_error());
}
$this_file = str_replace('\\', '/', __File__) ;
$doc_root = 'H:/root/home/kaizbenoya-002/www/Embat842022';
//$doc_root = __DIR__;

$web_root =  str_replace (array($doc_root, "include/config.php") , '' , $this_file);
$server_root = str_replace ('config.php' ,'', $this_file);

define ('web_root' , $web_root);
define('server_root' , $server_root);
?>