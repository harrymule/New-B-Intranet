<?php 

class Communication {
	
	function Email($to,$CC = false,$subject,$msg,$email,$name = NULL,$phone = NULL){
		$time = strftime('x',time());
		$headers = "MIME-Version: 1.0" . "\r\n";
		
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= "From: <{$email}>" . "\r\n"; 
		$headers .= $CC ? "CC: {$CC}" : NULL;
		$txt = $msg;
		$mail = mail($to,$subject,$txt,$headers);
		return $mail;	
		}
	
	
	}



