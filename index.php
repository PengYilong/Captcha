<?php
include './Loader.php';
spl_autoload_register('Loader::_autoload');

$cap = new yilongpeng\Captcha(4, 1);
// $cap->foreground = [0, 0, 0];
// $cap->background = [0,0,0];
// $cap->line_times = 1;
$cap->build();
// echo $cap->get_code();