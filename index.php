<?php
include './Loader.php';
spl_autoload_register('Loader::_autoload');
use Nezimi\Captcha;

$cap = new Captcha(4, 2, 200, 62);
// $cap->foreground = [0, 0, 0];
// $cap->background = [0,0,0];
// $cap->line_times = 1;
$cap->build();
// echo $cap->get_code();