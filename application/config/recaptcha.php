<?php 
defined('BASEPATH') or exit('No direct script access allowed');

$config['recaptcha_sitekey'] = isset($_ENV['RECAPTCHA_SITEKEY']) ? $_ENV['RECAPTCHA_SITEKEY'] : '';
$config['recaptcha_secretkey'] = isset($_ENV['RECAPTCHA_SECRETKEY']) ? $_ENV['RECAPTCHA_SECRETKEY'] : '';
$config['lang'] = "es";