<?
/*
	This is PHP file that generates CAPTCHA image for the How to Create CAPTCHA Protection using PHP and AJAX Tutorial

	You may use this code in your own projects as long as this 
	copyright is left in place.  All code is provided AS-IS.
	This code is distributed in the hope that it will be useful,
 	but WITHOUT ANY WARRANTY; without even the implied warranty of
 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
	
	For the rest of the code visit http://www.WebCheatSheet.com
	
	Copyright 2006 WebCheatSheet.com	

*/

//Start the session so we can store what the security code actually is
session_start();

//Send a generated image to the browser 
create_image(); 
exit(); 

function createRandomString($str_len) {
	$chars = explode(' ', "A B C D E F G H J K M N P Q R S T U W X Y Z 2 3 4 5 6 7 8 9"); // no I, 1, 0, O, V
	shuffle($chars);
	$str = '';
	for ($i = 0; $i < $str_len; $i++) {
		$str .= array_pop($chars);
	}
	return $str;
}

function create_image() 
{ 
	$str_len = 5;
	$security_code = createRandomString($str_len);

	//Set the session to store the security code
	$_SESSION["security_code"] = $security_code;

	//Set the image width and height 
	$width = 200;
	$height = 70;

	//Create the image resource 
	$image = imagecreate($width, $height);  

	//We are making three colors, white, black and gray 
	$white = imagecolorallocate($image, 255, 255, 255); 
	$black = imagecolorallocate($image, 0, 0, 0); 
	$grey = imagecolorallocate($image, 127, 127, 127); 
	$red = imagecolorallocate($image, 255, 0, 0); 
	$green = imagecolorallocate($image, 0, 255, 0); 
	$blue = imagecolorallocate($image, 0, 0, 255); 
	$yellow = imagecolorallocate($image, 255, 255, 0); 
	$cyan = imagecolorallocate($image, 0, 255, 255); 
	$magenta = imagecolorallocate($image, 255, 0, 255); 

	$rand_array = array( 'white' => $white,
					'black' => $black,
					'grey' => $grey,
//					'red' => $red,
//					'green' => $green,
//					'blue' => $blue,
//					'yellow' => $yellow,
//					'cyan' => $cyan,
//					'magenta' => $magenta
					);
	
	//shuffle array for random assortment of colors
	shuffle($rand_array);
//	$fill = $rand_array[0];
	$text1 = imagecolorallocate($image, 20, 20, 20);
	$line1 = $arc1 = $text1;
//	$line1 = $rand_array[1];
//	$arc1 = $rand_array[2];
//	$arc2 = $rand_array[1];
//	$rectangle = $rand_array[2];

	//Make the background black 
//	imagefill($image, 0, 0, $fill);
	for($i=0; $i<$width; $i++){ //gradient
		$color = imagecolorallocate($image, $i*180/$width+75, $i*180/$width+75, $i*180/$width+75);
		imageline($image, $width - $i, 0, $width - $i, $height, $color);
	}

	//Throw in some lines to make it a little bit harder for any bots to break 
//	$rec_sw = rand(1,$width/3);
//	$rec_sh = rand(1,$height/3);
//	$rec_ew = rand($rec_sw,$width-1);
//	$rec_eh = rand($rec_sh,$height-1);
//	imagerectangle($image, $rec_sw,$rec_sh,$rec_ew,$rec_eh,$rectangle); 
	imageline($image, rand(0,$width/3), rand(0,$height), rand($width*.66,$width-1), rand(0,$height-1), $line1); 
	imageline($image, rand(0,$width/3), rand(0,$height), rand($width*.66,$width-1), rand(0,$height-1), $line1); 
	$arc_s = rand(0,370);
	$arc_e = rand($arc_s, 360);
	imagearc($image, rand($width*1/3,$width*2/3), rand($height/4,$height*3/4), rand($width/5,$width*2/3), rand($height/5,$height*2/3), $arc_s, $arc_e, $arc1); 
	$arc_s = rand(0,370);
	$arc_e = rand($arc_s, 360);
	imagearc($image, rand($width*1/3,$width*2/3), rand($height/4,$height*3/4), rand($width/5,$width*2/3), rand($height/5,$height*2/3), $arc_s, $arc_e, $arc1); 
 
	//Add randomly generated string in white to the image
	
	$font_path = 'f/';
	$fonts = scandir($font_path); // PHP 5 only
	unset($fonts[0], $fonts[1]); // remove . and ..
	$loaded_fonts = array();
	foreach($fonts as $f) {
		$loaded_fonts[] = imageloadfont($font_path.array_pop($fonts));
	}
	
	$text_x = rand(3,15);
	$text_y = rand(10,20);
	$neg_one = -1;
	for ($i = 0; $i < $str_len; $i++) {
		shuffle($loaded_fonts);
		$font = $loaded_fonts[0];
		if (rand(0,1)) {
			$neg_one *= -1;
		}
		imagestring($image, $font, $text_x+($i*32), $text_y-(rand(1,$str_len)*$neg_one), $security_code{$i}, $text1);
	}
//	imagettftext($image, 11, 350, rand(2,10), rand(2,5), $text1, $font, $security_code);

	//Tell the browser what kind of file is come in 
	header("Content-Type: image/jpeg"); 

	//Output the newly created image in jpeg format 
	imagejpeg($image); 
	
	//Free up resources
	imagedestroy($image); 
} 
?>