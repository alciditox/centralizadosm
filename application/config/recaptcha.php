<?php 
defined('BASEPATH') or exit('No direct script access allowed');

$config['recaptcha_sitekey'] = getenv('RECAPTCHA_SITEKEY') ?: '';
$config['recaptcha_secretkey'] = getenv('RECAPTCHA_SECRETKEY') ?: '';
$config['lang'] = "es";