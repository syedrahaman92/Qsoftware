<?php
//ini_set('memory_limit', '50M');
//echo $_GET['pic'];
if(isset($_GET['pic']))
{
if($_GET['pic']){
	$img = new img($_GET['pic']);	
	$img->resize($_GET['w'],$_GET['h']);
	$img->show();
	//$img->store('images/thunb.png');
}
}
class img {
	
	var $image = '';
	var $temp = '';
	var $arrOriginalDetails = '';
	
	function img($sourceFile){
		$this->arrOriginalDetails = getimagesize($sourceFile);
		
		if(file_exists($sourceFile)){
			if($this->arrOriginalDetails['mime']=='image/jpeg'){
				$this->image = ImageCreateFromJPEG($sourceFile);
			}
			else if($this->arrOriginalDetails['mime']=='image/png'){
				$this->image = imagecreatefrompng($sourceFile);
			}
			else if($this->arrOriginalDetails['mime']=='image/gif'){
				$this->image = imagecreatefromgif($sourceFile);
			}
		} else {
			$this->errorHandler();
		}
		return;
	}
	
	function resize($width = 120, $height = 120, $aspectradio = false){
		$o_wd = imagesx($this->image);
		$o_ht = imagesy($this->image);
		if(isset($aspectradio)&&$aspectradio) {
			/*$w = round($o_wd * $height / $o_ht);
			$h = round($o_ht * $width / $o_wd);
			if(($height-$h)<($width-$w)){
				$width =& $w;
			} else {
				$height =& $h;
			}
			$height =& $h;*/

			$w = $o_wd;
			$h = $o_ht;
			if($o_wd > $width || $o_ht > $height) {
				if($o_ht > $o_wd) {
					$h = $height;
					$w = round($o_wd * $height / $o_ht);
					if($w > $width) {
						$w = $width;
						$h = round($h * $width / round($o_wd * $height / $o_ht));
					}
				} else if($o_wd > $o_ht) {
					$w = $width;
					$h = round($o_ht * $width / $o_wd);
					if($h > $height) {
						$h = $height;
						$w = round($w * $height / round($o_ht * $width / $o_wd));
					}
				} else {
					$h = $height;
					$w = round($o_wd * $height / $o_ht);
					if($w > $width) {
						$w = $width;
						$h = round($h * $width / round($o_wd * $height / $o_ht));
					}
				}
			}

			$width =& $w;
			$height =& $h;
		}
		$this->temp = imageCreateTrueColor($width,$height);
		imageCopyResampled($this->temp, $this->image,
		0, 0, 0, 0, $width, $height, $o_wd, $o_ht);
		$this->sync();
		return;
	}
	
	function sync(){
		$this->image =& $this->temp;
		unset($this->temp);
		$this->temp = '';
		return;
	}
	
	function show(){
		$this->_sendHeader();
		if($this->arrOriginalDetails['mime']=='image/jpeg'){
			ImageJPEG($this->image);
			return;
		}
		else if($this->arrOriginalDetails['mime']=='image/png'){
			imagepng($this->image);
			return;
		}
		else if($this->arrOriginalDetails['mime']=='image/gif'){
			imagegif($this->image);
			return;
		}
	}
	
	function _sendHeader(){
		header('Content-Type: '.$this->arrOriginalDetails['mime']);
	}
	
	function errorHandler(){
		echo "error";
		exit();
	}
	
	function store($file){
		if($this->arrOriginalDetails['mime']=='image/jpeg'){
			ImageJPEG($this->image,$file);
			return;
		}
		else if($this->arrOriginalDetails['mime']=='image/png'){
			imagepng($this->image);
			return;
		}
		else if($this->arrOriginalDetails['mime']=='image/gif'){
			imagegif($this->image);
			return;
		}
	}
	
	function watermark($pngImage, $left = 0, $top = 0){
		ImageAlphaBlending($this->image, true);
		$layer = ImageCreateFromPNG($pngImage); 
		$logoW = ImageSX($layer); 
		$logoH = ImageSY($layer); 
		ImageCopy($this->image, $layer, $left, $top, 0, 0, $logoW, $logoH); 
	}
}
?>
