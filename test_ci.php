<?php
define("ENVIRONMENT", "development");
$system_path = "system";
$application_folder = "application";
$view_folder = "";
if (realpath($system_path) !== FALSE) {
	$system_path = realpath($system_path)."/";
}
$system_path = rtrim($system_path, "/")."/";
define("BASEPATH", str_replace("\\", "/", $system_path));
define("APPPATH", $application_folder."/");
define("VIEWPATH", $view_folder."/");
define("FCPATH", __DIR__."/");

require_once BASEPATH."core/CodeIgniter.php";

