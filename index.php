<?php
include './Loader.php';
spl_autoload_register('Loader::_autoload');

$cap = new yilongpeng\Captcha();
// echo $cap->get_code();
$cap->output();
