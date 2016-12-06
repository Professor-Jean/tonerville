<?php

	function validateNumbers($min, $max, $num){
		$expression = "/^([0-9]{".$min.",".$max."})$/";
		return preg_match($expression, $num);
	}

	function validateText($min, $max, $text){
		$expression = "/^([\s\S]{".$min.",".$max."})$/";
		return preg_match($expression, $text);
	}

	function validateDate($date){
		$expression = "/^([0-9]{2}\/[0-9]{2}\/(([0-9]{2})|([0-9]{4})))$/";
		if(preg_match($expression, $date)){
			$array_date = explode("/", $date);
			return checkdate($array_date[1], $array_date[0], $array_date[2]);
		}
		return false;
	}

	function validateTime($time){
		return preg_match("/^((([0-1][0-9])||([2][0-3])):[0-5][0-9](:[0-5][0-9])?)$/", $time);
	}

	function validateURL($url){
		return preg_match("/^(http((s:\/\/[\s\S]{1,247})||(:\/\/[\s\S]{1,248})))$/", $url);
	}

	function validatePrice($min, $max, $price){
		$expression = "/^([0-9]{".$min.",".($max - 3)."}(\.[0-9]{0,2})?)$/";
		return preg_match($expression, $price);
	}

	function validatePhone($phone){
		return preg_match("/^([1-9][0-9]{9,10})$/", $phone);
	}

	function validateEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}