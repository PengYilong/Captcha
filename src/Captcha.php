<?php
namespace yilongpeng;

class Captcha
{

	/**
	 * @var an image resource or flase 
	 */
	public $img;

	/**
	 * 
	 * @var string 
	 */
	public $background = '#EDF7FF';


	public function __construct($width = 80, $height = 30)
	{
		$font = './font/elephant.ttf';
		$this->img = imagecreatetruecolor($width, $height);
		//sets background color of the image
		$white = imagecolorallocate($this->img, 255, 255, 255);
		$black = imagecolorallocate($this->img, 0, 0, 0);
		$code = $this->get_code();
		imagefilledrectangle($this->img, 1, 1, $width-2, $height-2, $white);
		for ($i=0; $i < 4 ; $i++) { 
			$size = mt_rand(14, 18);
			$angle = mt_rand(-15, 15);
			$x = 5+$i*$size;
			$y = mt_rand(20, 26);
			$color = imagecolorallocate($this->img, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
			$text = substr($code, $i,1);
		 	imagettftext($this->img, $size , $angle, $x, $y, $color, $font, $text);
		 } 
	}

	public function get_code($type = 1, $length = 4)
	{
		if( $type == 1 ){  //0,9
			$chars = join('', range(0,9));
		} elseif( $type==2 ){ //a-z,A-Z
 			$chars = join('', array_merge(range('a','z'), range('A','Z')));
		} else {   //a-z,A-Z,0,9
 			$chars = join('', array_merge(range('a','z'), range('A','Z'), range(0,9)));
		}
		$chars = str_shuffle($chars);
		return substr($chars, 0, $length);
	}


	public function output()
	{
		if( is_resource($this->img) ){
			header('Content-type:image/jpeg');
			imagepng($this->img);
			imagedestroy($this->img);	
		} else {
			return false;
		}
	}

    /**
     * gets errors
     * @return mixed 
     */
    public function get_error()
    {
        if( empty($this->error) ){
            $this->error = 'unknown error';
        }
        return $this->error;
    }	
}