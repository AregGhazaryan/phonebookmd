<?php
$request = parse_url($_SERVER['REQUEST_URI']);
$poping = $request["path"];
$set = explode("/",$poping);
$result = array_pop($set);
// Define your custom path
define("ROOT_PATH", '');
define("REQUEST",  $result);
chmod("./Assets", 0777);
firstRun();
if (!firstRun()) {
	 if (REQUEST != "run") {
		 header("Location:".ROOT_PATH."/run");
	 }
}
if(@filesize('config.ini') !== 0){
  $ini_array = @parse_ini_file("config.ini");
  define("DB_HOST", @$ini_array['dbhost']);
  define("DB_USER", @$ini_array['dbuname']);
  define("DB_PASS", @$ini_array['dbpass']);
  define("DB_NAME", @$ini_array['dbname']);
}
