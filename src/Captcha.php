<?php
namespace Nezimi;

class Captcha
{

	/**
	 * @var an image resource or false 
	 */
	protected $img;

	/**
	 * @var string    
	 */
	protected $code;

	/**
	 * @var int    
	 */
	protected $width;

	/**
	 * @var int    
	 */
	protected $height;

	/**
	 * @var int    
	 */
	protected $length;

	/**
	 * @var int    
	 */
	protected $type;

	/**
	 * @var string  
	 */
	protected $font;

	/**
	 * 
	 * @var int 
	 */	
	public $max_angle = 30;

	/**
	 * @var array
	 */
	public $background;

	/**
	 * @var array
	 */
	public $foreground;

	/**
	 * @var string  
	 */
	public $line_times;

	/**
	 * @var int  
	 */
	public $space = 0;

	/**
	 * @var int  
	 */
	public $offset = 5;

	public function __construct($length = 4, $type = 1, $width = 80, $height = 30)
	{
		$this->font = dirname(__DIR__).'/font/georgia.ttf';
		$this->width = $width;
		$this->height = $height;
		$this->length = $length;
		$this->type = $type;
		$this->img = imagecreatetruecolor($this->width, $this->height);
	}

	public function build()
	{
		$this->draw_rectangle()->draw_line()->draw_pointer()->generate_code($this->type, $this->length)->write_code()->output();
		// $this->draw_rectangle()->draw_line()->draw_pointer()->generate_code(1, $this->length)->write_code();
	}

	public function draw_rectangle()
	{
		if( $this->background === NULL  ){
			$background = imagecolorallocate($this->img, $this->rand(125,255), $this->rand(125,255), $this->rand(125,255));
		} else {
			$background = imagecolorallocate($this->img, $this->background[0], $this->background[1], $this->background[2]);
		}
		imagefilledrectangle($this->img, 0, 0, $this->width, $this->width, $background);
		return $this;
	}

	public function draw_line()
	{
		$times = $this->get_line_times();
		for($i=0; $i<$times; $i++){	
			if( $this->rand(0,1) ){ //Horizontal
				$x1 = $this->rand(0, $this->width);
				$y1 = $this->rand(0, $this->height);
				$x2 = $this->rand($this->width/2, $this->width);
				$y2 = $this->rand(0, $this->height);
			} else {  // Vertical
				$x1 = $this->rand(0, $this->width);
				$y1 = $this->rand(0, $this->height);
				$x2 = $this->rand(0, $this->width);
				$y2 = $this->rand($this->height/2, $this->height);
			}
			$color = imagecolorallocate($this->img, $this->rand(0,255), $this->rand(0,255), $this->rand(0,255));
			imagesetthickness($this->img, $this->rand(1,2));
			imageline($this->img, $x1, $y1, $x2, $y2, $color);
		}
		return $this;
	}

	/**
	 * Generate a random number
	 */
	public function rand($min, $max)
	{
		return mt_rand($min, $max);	
	}

	public function get_line_times()
	{
		if( $this->line_times!== NULL ){
			$times = $this->line_times;
		} else {
			$square = $this->width*$this->height;
			$times = $this->rand($square/3000, $square/2000);
		}
		return $times;
	}

	public function draw_pointer()
	{
		for ($i=0; $i < $this->rand(5, 10); $i++) { 
			$x = $this->rand(0, $this->width);
			$y = $this->rand(0, $this->height);
			$color = imagecolorallocate($this->img, $this->rand(125,255), $this->rand(125,255), $this->rand(125,255));
			imagesetpixel($this->img, $x, $y, $color);
		}
		return $this;	
	}

	public function generate_code($type = 1)
	{
		if( $type == 1 ){  //0,9
			$chars = join('', range(0,9));
		} elseif( $type==2 ){ //a-z,A-Z
 			$chars = join('', array_merge(range('a','z'), range('A','Z')));
		} else {   //a-z,A-Z,0,9
 			$chars = join('', array_merge(range('a','z'), range('A','Z'), range(0,9)));
		}
		$chars = str_shuffle($chars);
		$this->code = substr($chars, 0, $this->length);
		return $this;
	}

	public function write_code()
	{
		if( $this->foreground === NULL  ){
			$color = imagecolorallocate($this->img, $this->rand(0,125), $this->rand(0,125), $this->rand(0,125));
		} else {
			$color = imagecolorallocate($this->img, $this->foreground[0], $this->foreground[1], $this->foreground[2]);
		}
		//gets start position
		$size = $this->width / $this->length - $this->rand(1,3)-2;
		$box = imagettfbbox($size, 0, $this->font, $this->code);
		$text_width = $box[2]-$box[0]+($this->length-1)*$this->space;
		$text_height = $box[1]-$box[7];

		$x = ($this->width-$text_width)/2;
		$y = ($this->height-$text_height)/2+$size;

		for ($i=0; $i < $this->length ; $i++) { 
			$text = substr($this->code, $i, 1);
			$box = imagettfbbox($size, 0, $this->font, $text);
			$w = $box[2] - $box[0];
			$angle = $this->rand(-$this->max_angle, $this->max_angle);
			$offset = $this->rand(-$this->offset, $this->offset);
		 	imagettftext($this->img, $size , $angle, $x, $y+$offset, $color, $this->font, $text);
		 	$x += $w+$this->space;
		 } 
		return $this;
	}

	public function get_code()
	{
		return $this->code;
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