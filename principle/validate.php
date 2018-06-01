<?php
/*
普通验证码的制作
resource imagecreatetruecolor ( int $width , int $height ) imagecreatetruecolor(宽，高) 新建一个真彩色图像
imagecolorallocate(resource image,int red,int green,int blue) 为一幅图像分配颜色，第一次写是图像的背景颜色
imagestring(resource image,字体,int x ,int y,内容，颜色) 绘图函数	 字体系统默认的是1，6
deches(十进制数)
画线函数
imageline(resource image,int x1,int y1,int x2,int y2,int color)
imageline(resource image,起始坐标,终点坐标,int color)
画点函数
imagesetpixel(resource image,点坐标,int color)
调用字体写函数
imagettftext(resource image,float size,float angle,intx,int y,int color,string fontfile,string text)
imagettftext(resource image,字体大小,字体坐标int color,string fontfile,string text)
iconv(‘原始编码’,’转换后的编码//IGNOE’.’需要转换的字符’)
*/

header("Content-type:image/jpeg");//告诉浏览器是哪种格式
session_start();
$rand="";
for($i=0;$i<4;$i++){
  $rand.=dechex(rand(5,15));
}
$_SESSION["check_pic"]=$rand;
//新建一个真彩色图像 
$img=imagecreatetruecolor(100,30);
//设置颜色
$bg=imagecolorallocate($img,0,0,0);	//第一次用分配调色板的时候就是背景颜色,000黑色
$color1=imagecolorallocate($img,255,255,255);
$color2=imagecolorallocate($img,rand(0,255),rand(0,255),rand(0,255));
imageline($img,0,0,100,30,$color2);//画线函数
imagesetpixel($img,90,25,$color1); //画点函数
imagestring($img,rand(5,6),rand(0,60),rand(1,10),$rand,$color1);//绘图函数,用于英文验证码 
//imagettftext($img,12,0,rand(0,40),rand(0,30),$color2,"simsun.ttc","新年快乐");	//载入字体，用于中文验证码
//输出图像
imagejpeg($img);//将编码转换为图片格式
?>