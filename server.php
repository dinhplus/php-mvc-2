<?php
define('WEBROOT', str_replace("server.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT', str_replace("server.php", "", $_SERVER["SCRIPT_FILENAME"]));
require_once("./request.php");
require_once("Config/Core.php");
// require_once("./Dispatcher.php");

?>