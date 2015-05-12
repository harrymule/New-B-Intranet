<?php
class Upload_Public {
	
	function delete_file($file_name){
		if(!$file_name){return false;}
		$size = 0;
		$file = PUBLIC_FOLDER.$file_name;
		$check = file_exists($file) ? true : false;
		$size += ($check) ? filesize($file) : 0 ;
		($check) ? unlink($file) : NULL;
		
		$file = PUBLIC_FOLDER.'sq_'.$file_name;
		$check = file_exists($file) ? true : false;
		$size += ($check) ? filesize($file) : 0 ;
		($check) ? unlink($file) : NULL;
		
		$file = PUBLIC_FOLDER.'1_'.$file_name;
		$check = file_exists($file) ? true : false;
		$size += ($check) ? filesize($file) : 0 ;
		($check) ? unlink($file) : NULL;
		
		$file = PUBLIC_FOLDER.'2_'.$file_name;
		$check = file_exists($file) ? true : false;
		$size += ($check) ? filesize($file) : 0 ;
		($check) ? unlink($file) : NULL;
		
		$file = PUBLIC_FOLDER.'3_'.$file_name;
		$check = file_exists($file) ? true : false;
		$size += ($check) ? filesize($file) : 0 ;
		($check) ? unlink($file) : NULL;
		
		$file = PUBLIC_FOLDER.'4_'.$file_name;
		$check = file_exists($file) ? true : false;
		$size += ($check) ? filesize($file) : 0 ;
		($check) ? unlink($file) : NULL;
		
		}
	
	function upload_image($fileIndex){
		if(!isset($_FILES[$fileIndex]) or empty($fileIndex))return false;	
		if(!in_array($_FILES[$fileIndex]['type'],array('image/jpeg','image/jpg','image/gif','image/png'))){return false;}
		$rundomNumber = rand(1000,1000000000); 
		$uploadName = $rundomNumber.$this->get_extension($_FILES[$fileIndex]['name']);	
		$tmp = $_FILES[$fileIndex]['tmp_name'];
		$type = $_FILES[$fileIndex]['type'];
		$size = $_FILES[$fileIndex]['size'];
		$dir = PUBLIC_FOLDER;
		if(!is_dir($dir)) { mkdir($dir);}
			basename(move_uploaded_file($tmp,$dir.$uploadName));
			$file['file'] = $uploadName;
			$file['dir'] = $dir;
			global $general;
			$name =  $this->toJpeg($file['dir'],$file['file']);
			$newName = rename($dir.$name,$dir.$rundomNumber.'.jpg');
			$file['type'] = $general->FileType($newName);
			$file['file'] = $rundomNumber.'.jpg';
			$this->resizeUploadedImages($file);
			$dir = $file['dir'];
			$o_file = $file['file'];
			$save = $file['dir'].'sq_'.$file['file'];
			$this->squere_crop($dir,$o_file,$save);
			return $file['file'];
		}
	function get_extension($file){
		$file = substr($file,strlen($file)-5,5);
		$file = strstr($file,'.');
		return $file;
		}
	function multiFiles($fileIndex){
		$string = NULL;
		$max = count($_FILES[$fileIndex]['name']);
		$file = array();
		$i=0;
		foreach($_FILES[$fileIndex]['name'] as $sysFile){
			if(!in_array($_FILES[$fileIndex]['type'][$i],array('image/jpeg','image/jpg','image/gif','image/png'))){return false;}
			$rundomNumber = rand(1000,1000000000); 
			$uploadName = $rundomNumber.$this->get_extension($_FILES[$fileIndex]['name'][$i]);	
			
			$tmp = $_FILES[$fileIndex]['tmp_name'][$i];
			$type = $_FILES[$fileIndex]['type'][$i];
			$size = $_FILES[$fileIndex]['size'][$i];
			$dir = PUBLIC_FOLDER;
			if(!is_dir($dir)) { mkdir($dir);}
				basename(move_uploaded_file($tmp,$dir.$uploadName));
				$file['file'] = $uploadName;
				$file['dir'] = $dir;
				global $general;
				$name =  $this->toJpeg($file['dir'],$file['file']);
				$newName = rename($dir.$name,$dir.$rundomNumber.'.jpg');
				$file['type'] = $general->FileType($newName);
				$file['file'] = $rundomNumber.'.jpg';
				
				$this->resizeUploadedImages($file);
				$dir = $file['dir'];
				$o_file = $file['file'];
				$save = $file['dir'].'sq_'.$file['file'];
				$this->squere_crop($dir,$o_file,$save);
				$string .= '|'. $file['file'];
				
			$i++;}
			$string = substr($string,1,strlen($string));
		return  $string;
		}
	
	
	function alt_exif_imagetype($file){
		$len = strlen($file);
		$ext = substr($file,($len-4),$len);
		if($ext == '.gif') { return 1;}
		if($ext == '.jpg') { return 2;}
		if($ext == '.png') { return 3;}
		if($ext == 'jpeg') { return 2;}
		}
	
	function resizeUploadedImages($files){
		$image = $files['dir'].$files['file'];
		list($w,$h) = getimagesize($image);
		$nw = 1300;
		$nh = ($nw * $h)/$w;
		$type = $this->alt_exif_imagetype($image);
		$area = $w*$h;
		$n_area = $nh * $nh;
		$src = imagecreatefromjpeg($image);
		for($j=1; $j<5; $j++){
			$thumb = imagecreatetruecolor($nw*($j/5),$nh*($j/5));
			imagecopyresampled($thumb,$src,0,0,0,0,$nw*($j/5),$nh*($j/5),$w,$h);
			$save = $files['dir'].$j.'_'.$files['file'];
			imagejpeg($thumb,$save,100);
			}
				 /* -- VIDEO CODE HERE-- */
	}
		
	function renameImage($image){
		$image =  strtolower($image);
		$image = str_replace('.jpeg','.jpg',$image);
		$image = str_replace('.png','.jpg',$image);
		$image = str_replace('.gif','.jpg',$image);
		
		return $image;
		}
	
	function png2jpg($dir,$file){
		$filePath = $dir . $file;
		$image = imagecreatefrompng($filePath);
		$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
		imagedestroy($image);
		$quality = 100; // 0 = worst / smaller file, 100 = better / bigger file 
		$file = $this->renameImage($file);
		$filePath = $dir.$file;
		imagejpeg($bg, $filePath, $quality);
		imagedestroy($bg);
		return $file;
		}
		
	function gif2jpg($dir,$file){
		$filePath = $dir.$file;	
		$image = imagecreatefromgif($filePath);
		$file = $this->renameImage($file);
		$filePath = $dir.$file;
		imagejpeg($image,$filePath,100);
		file_put_contents('error.txt',$filePath);
		imagedestroy($image);
		return $file;
		}
	
	function jpeg2jpg($dir,$file){
		$filepath = $dir.$file;
		$image = imagecreatefromjpeg($filepath);
		unlink($filepath);
		$file = $this->renameImage($file);
		$filePath = $dir.$file;
		imagejpeg($image,$filePath,100);
		imagedestroy($image);
		return $file;
		}
	
	function toJpeg($dir,$file){
		$newName = $file;
		$filePath = $dir.$file;
		$type = $this->alt_exif_imagetype($filePath);
		switch($type){
			case 1 : {$newName =  $this->gif2jpg($dir,$file);break;}
			case 2 : {$newName =   $this->jpeg2jpg($dir,$file);break;}
			case 3 : {$newName =   $this->png2jpg($dir,$file);break;}
			default : {$newName = $file;}
			}
		return $newName;
		}
	
	function squere_crop($path,$src,$save){
		// get the image source
		$path = $path;
		$img = $src;
		$img_src = imagecreatefromjpeg($path.$img);
		$img_width = imagesx($img_src);
		$img_height = imagesy($img_src);
		$square_size = 300;
		// check width, height, or square
		if ($img_width == $img_height) {
			// square
			$tmp_width = $square_size;
			$tmp_height = $square_size;
		} else if ($img_height < $img_width) {
			// wide
			$tmp_height = $square_size;
			$tmp_width = intval(($img_width / $img_height) * $square_size);
			if ($tmp_width % 2 != 0) {
				$tmp_width++;
			}
		} else if ($img_height > $img_width) {
			$tmp_width = $square_size;
			$tmp_height = intval(($img_height / $img_width) * $square_size);
			if ($tmp_height % 2 != 0) {
				$tmp_height++;
			}
		}
		
		$img_new = imagecreatetruecolor($tmp_width, $tmp_height);
		imagecopyresampled($img_new, $img_src, 0, 0, 0, 0,
				$tmp_width, $tmp_height, $img_width, $img_height);
		
		// create temporary thumbnail and locate on the server
		$thumb = "thumb_".$img;
		imagejpeg($img_new, $path.$thumb,100);
		$tmp_imge = $path.$thumb;
		
		// get tmp_image
		$img_thumb_square = imagecreatefromjpeg($path.$thumb);
		$thumb_width = imagesx($img_thumb_square);
		$thumb_height = imagesy($img_thumb_square);
		
		if ($thumb_height < $thumb_width) {
			// wide
			$x_src = ($thumb_width - $square_size) / 2;
			$y_src = 0;
			$img_final = imagecreatetruecolor($square_size, $square_size);
			imagecopy($img_final, $img_thumb_square, 0, 0,
					$x_src, $y_src, $square_size, $square_size);
			imagejpeg($img_final, $path.$thumb);
		} else if ($thumb_height > $thumb_width) {
			// landscape
			$x_src = 0;
			$y_src = ($thumb_height - $square_size) / 2;
			$img_final = imagecreatetruecolor($square_size, $square_size);
			imagecopy($img_final, $img_thumb_square, 0, 0,
					$x_src, $y_src, $square_size, $square_size);
			imagejpeg($img_final, $path.$thumb);
		} else {
			$img_final = imagecreatetruecolor($square_size, $square_size);
			imagecopy($img_final, $img_thumb_square, 0, 0,
					0, 0, $square_size, $square_size);
		}
		imagejpeg($img_final,$save,100);
		unlink($tmp_imge);
		return $save;
		}
	}
