<?php 

class general {
	
	function pre($pass){
		echo pre;
		print_r($pass);
		echo '</pre>';
		}
	
	function selected($val_1,$val_2){
		return ($val_1 == $val_2) ? 'selected="selected"' : NULL;
		}
	
	function html_date($timestamp){
		// year - date - month
		// e.g. 2015-02-01
		$array = $this->timeArray($timestamp);
		return $array['Year'].'-'.$array['month'].'-'.$array['Date'];
		}
	
	function word_wrap($string,$chars){
		return strstr(wordwrap(strip_tags($string),$chars,'-break-',true),'-break-',true);
		}
	
	function number_to_letters($number){
		$number--;
		$letters = 'a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z';
		$letters_array = explode(',',$letters);
		if($number < 26){
			return $letters_array[$number];
			}else {
				return ($number+1);
				}
		}
	
	
	function remove_chars($str){
		$str = str_replace(' ','',$str);
		$str = strtolower($str);
		$chars = "a b c d e f g h i j k l m n o p q r s t u v w x y z ~ ! @ # $ % ^ & * ( ) _ + / \" ' \ : ; | { } [ ] ` ~ ? , ";
		$array = explode(" ",$chars);
		foreach($array as $char ){
			$str = str_replace($char,'',$str);
			}
			return $str;
		}
	
	function clean_string($string){
		$string = str_replace(' ','-',$string);
		$chars = ' 1 2 3 4 5 6 7 8 9 0 ` ! @ # $ % ^ & * ( ) _ + = , . / \' ; \ \ ] [ } { | " : ? > < ';
		$array = explode(' ',$chars);
		foreach($array as $char){
			$string = str_replace($char,NULL,$string);
			}
		return $string;
		}
	
	function date_to_timestamp($month=1,$date=1,$year=1){
		return checkdate($month,$date,$year) ? mktime(0,0,0,$month,$date,$year) : 0;
		}
	
	function timestamp_to_sql_time($timestamp){
		return strftime('%Y-%m-%d %H:%M:%S',$timestamp);
		}
	function sql_time_to_timestamp($time_string){
		if(!strpos($time_string,'.')){
			$string = $time_string;
			}else {
				$string = strstr($time_string,'.',false);
				}
		
		if(!strpos($string,'-') or !strpos($string,':'))return time();
		$array = explode(' ',$string);
		$date = $array[0];
		$time = $array[1];
		$date = explode('-',$date);
		$time = explode(':',$time);
		//$time_stamp = strtotime($time_string);
		$time_stamp = mktime($time[0],$time[1],$time[2],$date[2],$date[1],$date[0]);
		
		$time_stamp = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
		return $time_stamp;
		}
	
	function request($index,$return = false ){
		$return = (!$return) ? $return : 0;
		return isset($_REQUEST[$index]) ? $_REQUEST[$index] : $return;
		}
	
	function explodeImages($imageString){
		
		}
		
	function inplodeImages($imageArray){
		
		}
	function url_comma_equal($string){ /* var_1=value_1,var_2=value_2 */
		if(!strpos($string,',')) return $string;
		if(!strpos($string,'=')) return $string;
		$array_comma = explode(',',$string);
		$res = array();
		foreach($array_comma as $set){
			$a = explode('=',$set);
			$res[$a[0]] = $a[1];
			}
		
		
		return $res;
		
		
		
		}
	function cleanName($name){

		$name = strtolower($name);

		$name = str_replace('_',' ',$name);

		$name = str_replace('-',' ',$name);

		$name = str_replace('.jpg','',$name);

		$name = str_replace('.jpeg','',$name);

		$name = str_replace('.gif','',$name);

		$name = str_replace('.flv','',$name);

		$name = str_replace('.png','',$name);

		$name = str_replace('(',' ',$name);

		$name = str_replace(')',' ',$name);

		$name = str_replace('{',' ',$name);

		$name = str_replace('{',' ',$name);

		$name = str_replace('\\',' ',$name);

		$name = str_replace('|',' ',$name);

		$name = str_replace('!',' ',$name);

		$name = str_replace('@',' ',$name);

		$name = str_replace('#',' ',$name);

		$name = str_replace('%',' ',$name);

		$name = str_replace('^',' ',$name);

		$name = str_replace('`',' ',$name);

		$name = str_replace('+',' ',$name);
		return $name;

		}

	

	function getFileExt($file){
		$file = strtolower($file);

		$len = strlen($file);

		$ext = substr($file,($len-4),$len);

		$ext = str_replace('.','',$ext);

		return $ext;

		}

	

	function FileType($file){

		$video = array('webm','mpeg','flv','avi','mp4','vob','mpg','wmv');

		$audio = array('mp3','mp2','wav');

		$image = array('jpg','jpeg','gif','png','bmp');

		$pdf = array('pdf');

		$doc = array('doc','docx','docm','dotx','htm','mht','rtf','wps','xml','html','txt');

		$ext = $this->getFileExt($file);

		if(in_array($ext,$video)) { return 'video';}

		else if (in_array($ext,$audio)){return 'audio';}

		else if (in_array($ext,$image)){return 'image';}

		else if(in_array($ext,$pdf)){return 'pdf';}

		else if(in_array($ext,$doc)){return 'doc';}

		else {return 'file';}

		}

		

	public function Dir($dir = "."){
		$dirs = array();
		$i = 0;
		if(is_dir($dir)){
			if($dir_h = opendir($dir) )
				while($file = readdir($dir_h)){
					$dirs[$i] = $file;
					$i++;}
			}
		return $dirs;
		}

		
	function get_date($timestamp){
		$time_array = $this->timeArray($timestamp);
		$date = $time_array['Date'].' '.$time_array['Th'];
		$month = ' '.$time_array['Month'];
		$Year = ', '.$time_array['Year'];
		return $date.$month.$Year;
		}
	function get_time($timestamp){
		$time_array = $this->timeArray($timestamp);
		$hour = $time_array['hour'];
		$min = ':'.$time_array['Min'];
		$paam = ' '.$time_array['paam'];
		return $hour.$min.$paam;
		}
	
	function get_date_time($timestamp){
		
		}
	
	function timeArray($time){

		$H = strftime('%h',$time);
		
		$Hor = strftime('%H',$time);

		$Min = strftime('%M',$time);

		$Sec = strftime('%S',$time);

		$Dat = strftime('%d',$time);

		$Day = strftime('%a',$time);

		$Mot = strftime('%b',$time);
		
		$mot = strftime('%m',$time);
		
		$Yer = strftime('%Y',$time);
		
		$paam = strftime('%p',$time);
		
		$th = in_array($Dat,array(1,21,31)) ? '<sup>st</sup>' : NULL;

		$th = in_array($Dat,array(2,22)) ? '<sup>nd</sup>' : $th;

		$th = $th == NULL ? '<sup>th</sup>' : $th;

		return array(

		'paam' => $paam,
		'hour' => $Hor,
		'Hour' => $Hor,	
		'Min' => $Min,
		'Sec' => $Sec,
		'Date' => $Dat,
		'Month' => $Mot,
		'month' => $mot,
		'Year' => $Yer,
		'Day' => $Day,
		'Th' => $th);
		}

	

	function timeCalc($time){

		$now = time();

		$diff = $now - $time;

		$diff = $diff < 0 ? $diff *-1 : $diff;

		$sec = 60;

		$min = $sec * 60;

		$hr = $min * 60;

		$day = $hr * 24;

		$week = $day * 7;

		$year = $week * 52;

		

		$return = $diff <= $sec ? 'Sec' : NULL;

		$return = $diff <= $min && $diff > $sec ? 'Min' : $return;

		$return = $diff <= $hr && $diff > $min ? 'Hour' : $return;

		$return = $diff <= $day  && $diff > $hr ? 'Day' : $return;

		$return = $diff <= $week && $diff > $day ? 'Week' : $return;

		$return = $diff <= $year && $diff > $week ? 'Year' : $return;

		

		$secs  	= intval($diff);

		$mins 	= intval($diff/(60));

		$hrs 	= intval($diff/(60*60));

		$days 	= intval($diff/(60*60*24));

		$weeks 	= intval($diff/(60*60*24*7));

		$years 	= intval($diff/(60*60*24*7*52));

		$res 	= (array('Sec' =>$secs,'Min'=>$mins,'Hour'=>$hrs,'Day'=>$days,'Week'=>$weeks,'Year'=>$years));

		$value 	= $res[$return];

		$return .= ($value != 1) ? 's' : NULL;

		//$return = substr($return,0,1);
		

		return $value.' '.$return;

		}

	public function getAgeGroup($age){

			if($age >= 0 && $age <1) {return 'Infant';}

			if($age >= 1 && $age <3) {return 'Toddler';}

			if($age >= 3 && $age <13) {return 'Kid';}

			if($age >= 13 && $age <19) {return 'Teen';}

			if($age >= 19 && $age <25) {return 'Young Adult';}

			if($age >= 25 && $age <40) {return ' Adult';}

			if($age >= 40 && $age <60) {return 'Middle Aged';}

			if($age > 60) {return 'Sinior Citizen';}	

			}

	

	public function getAge($timeStamp){

		return (strftime("%Y",time())) - (strftime("%Y",$timeStamp));

		}	

	public function getAgeGroupAge($timeStamp){

		$age = $this->getAge($timeStamp);

		return $this->getAgeGroup($age);

		}

	public function pageActive($name,$page){
		if($name == $page){return ' active ';}
		}
	
	public function active_parent_get($index,$pages,$default=false){
		if(isset($_GET[$index])){
			$page = $_GET[$index];
			$array = explode(',',$pages);
			return in_array($page,$array) ? ' active ' : NULL;
			 }
		else if (!isset($_GET[$index]) and ($default == true)) {
			return ' active ';
			}
		else {return NULL;}
		}

	public function active_get($index,$page,$default=false){
		if(isset($_GET[$index]) and $_GET[$index] == $page){
			return ' active ';
			 }
		else if (!isset($_GET[$index]) and ($default == true)) {
			return ' active ';
			}
		else {return NULL;}
		}

	public function alt_exif_imagetype($file){

			$len = strlen($file);

			$ext = substr($file,($len-4),$len);

			if($ext == '.gif') { return 1;}

			if($ext == '.jpg') { return 2;}

			if($ext == '.png') { return 3;}

			if($ext == 'jpeg') { return 2;}

			}

	

	

	

	

	function copy_folder($src,$dst,$sessionName = 'coping',$totalFile = 0){

		$sum = 0;

		if(!is_dir($src)){ return false;}

		@mkdir($dst);

		$dir = opendir($src); 

		@mkdir($dst); 

		while(false !== ($file = readdir($dir))){

			if(($file != '.') && ($file != '..') && ($file != 'id.ini')){

				if( is_dir($src . '/' . $file) ) {

					$this->copy_folder($src .'/'. $file,$dst . '/'. $file);

					}

					else {

						$_SESSION[$sessionName]['total'] = $sum;

						$_SESSION[$sessionName]['remain'] = ($totalFile > 0) ? $totalFile - $sum : 'Unknown';

						copy($src . '/' . $file,$dst . '/' . $file);

						$sum++;

						}

			}

		} 

		closedir($dir);

		return true; 

		}

	function foldersize($dir){

		 $count_size = 0;

		 $count = 0;

		 $dir_array = scandir($dir);

		 foreach($dir_array as $key=>$filename){

		  if($filename!=".." && $filename!="."){

		   if(is_dir($dir."/".$filename)){

			$new_foldersize = $this->foldersize($dir."/".$filename);

			$count_size = $count_size + $new_foldersize[0];

			$count = $count + $new_foldersize[1];

		   }else if(is_file($dir."/".$filename)){

			$count_size = $count_size + filesize($dir."/".$filename);

			$count++;

		   }

		  }

		

		 }

		

		 return $count_size;

		}	

	

	function extractZip($file,$dest){

		$zip = new ZipArchive;		

		if ($zip->open($file) === TRUE) {

			$start = time();

			$zip->extractTo($dest);

			$zip->close();

			$end = time();

			$time = $end - $start;

			file_put_contents($dest.'/finish.txt','true');

			return $time;

			} else {

				return false;

				}

		}

	function create_subdomain($subDomain) {

		if(LOCAL){return 'Cannot Create Sub Domain In Localhost, Google For More Information';}

		$cPanelUser = HOST_USER_NAME;

		$cPanelPass = HOST_USER_PASS;

		$rootDomain = HOST_ROOT_DIR;

		$buildRequest = "/frontend/x3/subdomain/doadddomain.html?rootdomain=" . $rootDomain . "&domain=" . $subDomain;

		$buildRequest = "/frontend/x3/subdomain/doadddomain.html?rootdomain=" . $rootDomain . "&domain=" . $subDomain . "&dir=public_html/users/" . $subDomain;

		if(!fsockopen('localhost',2082)) {

			return "Socket error";

			exit();

		}else {

			$openSocket = fsockopen('localhost',2082);

			}

		$authString = $cPanelUser . ":" . $cPanelPass;

		$authPass = base64_encode($authString);

		$buildHeaders  = "GET " . $buildRequest ."\r\n";

		$buildHeaders .= "HTTP/1.0\r\n";

		$buildHeaders .= "Host:localhost\r\n";

		$buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";

		$buildHeaders .= "\r\n";

		

		fputs($openSocket, $buildHeaders);

		while(!feof($openSocket)) {

		fgets($openSocket,128);

		}

		fclose($openSocket);

	

		$newDomain = "http://" . $subDomain . "." . $rootDomain . "/";

	

		return "Created subdomain $newDomain";

	}

	function delete_subdomain($subDomain,$cPanelUser,$cPanelPass,$rootDomain){

		$buildRequest = "/frontend/x3/subdomain/dodeldomain.html?domain=" . $subDomain . "_" . $rootDomain;

	

		$openSocket = fsockopen('localhost',2082);

		if(!$openSocket) {

			return "Socket error";

			exit();

		}	

		$authString = $cPanelUser . ":" . $cPanelPass;

		$authPass = base64_encode($authString);

		$buildHeaders  = "GET " . $buildRequest ."\r\n";

		$buildHeaders .= "HTTP/1.0\r\n";

		$buildHeaders .= "Host:localhost\r\n";

		$buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";

		$buildHeaders .= "\r\n";

	

		fputs($openSocket, $buildHeaders);

		while(!feof($openSocket)) {

			fgets($openSocket,128);

			}

		fclose($openSocket);

		

		$passToShell = "rm -rf /home/" . $cPanelUser . "/public_html/subdomains/" . $subDomain;

		system($passToShell);

	}

	function gen_random_key(){
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$shuffled_1 = str_shuffle($chars);
		$shuffled_2 = str_shuffle($chars);
		$key = str_shuffle($shuffled_1.$shuffled_2);
		$key = substr($key,rand(0,10),rand(20,39));
		return $key;
		}


	function check404($mylink){
		$handler = curl_init($mylink);
		curl_setopt($handler,  CURLOPT_RETURNTRANSFER, TRUE);
		$re = curl_exec($handler);
		$httpcdd = curl_getinfo($handler, CURLINFO_HTTP_CODE);
		if ($httpcdd == '404'){return false;}else { return true;}
		}
	
	function val_str($string){
		$string = str_replace(' ' , '',$string);
		return strlen($string) == 0 ? false : true;
		}
	
	function val_number($number){
		return true;
		}
	function val_password($password){return true;}
	function val_email($email){
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
			return $sanitized_email;
			}else {return false;}
		}
	function val_url($url){
		$sanitized_url = filter_var($url, FILTER_SANITIZE_URL);
		if (filter_var($sanitized_url, FILTER_VALIDATE_URL)) {
			return $sanitized_url;
			}else {return false;}
		}
	
	function val_float($float){
		if (filter_var($float, FILTER_VALIDATE_FLOAT)) {
			return $float;
			}else {return false;}
		}
	function val_int($int){
		if (filter_var($int, FILTER_VALIDATE_INT)) {
			return $int;
			}else {return false;}
		}
	
	function val_phone($phone){
		$v_phone = NULL;
		$numbers = '0123456789';
		$numbers = str_split($numbers);
		$phone = str_split($phone);
		foreach($phone as $char){
			if(in_array($char,$numbers)){
				$v_phone .= $char;
				}
			}
		return $v_phone;
		}
	
	function val_username($username){
		$email = $username.'@host.com';
		$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
			return str_replace('@host.com','',$sanitized_email);
			}else {return false;}
		}
function formatSizeUnits($bytes,$round = 2)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, $round) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, $round) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, $round) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
}
		
	}

$general = new general();
