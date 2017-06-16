<?php
class SanitizeString
{
	static public function escape($connection,$str)
	{
		return mysqli_escape_string($connection, $str);
	}
	
	static public function cleanInput($input) 
	{
 
		$search = array(
			'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		  );
	 
		$output = preg_replace($search, '', $input);
		return $output;
	}
	
	static public function sanitize($connection,$input) 
	{
		if (is_array($input)) 
		{
			foreach($input as $var=>$val) 
			{
				$output[$var] = $this->sanitize($val);
			}
		}
		else 
		{
			if (get_magic_quotes_gpc()) 
			{
				$input = stripslashes($input);
			}
			
			//Strinping HTML and JavaScript Tags
			$input  = self::cleanInput($input);
			
			//Escapes special characters in a string for use in an SQL statement
			$output = self::escape($connection,$input);
		}
		return $output;
	}	
}	