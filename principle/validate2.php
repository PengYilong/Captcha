<?php
header("Content-type:image/jpeg");
session_start();
  $validate="";
   for($i=0;$i<4;$i++){
	   $validate.=rand(0,9);
   }
$_SESSION['validate']=$validate;
//新建一个真彩色图像 
$img=imagecreatetruecolor(100,30);
//设置颜色
$bg=imagecolorallocate($img,0,0,0);	//第一次用分配调色板的时候就是背景颜色,000黑色
$color1=imagecolorallocate($img,255,255,255);
//$color2=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
//imageline($img,0,0,100,30,$color2);//画线函数
//imagesetpixel($img,90,25,$color1); //画点函数
imagestring($img,rand(5,6),rand(0,60),rand(1,10),$validate,$color1);//绘图函数,用于英文验证码 
//imagettftext($img,12,0,rand(0,40),rand(0,30),$color2,"simsun.ttc","新年快乐");	//载入字体，用于中文验证码
//输出图像
imagejpeg($img);//将编码转换为图片格式
?>
