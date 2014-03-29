<?php 
namespace FabriceKabongo\Common\Util;
    
class Botscout
{
    private static $diag ;
    private static $returned_data;
    private static $APIKEY;
    private static $USEXML;
    private static $XMAIL;
    private static $XIP;
    private static $multi_test;
    private static $ch;
    private static $botdata;

    public static function configure($apikey,$diag=0,$usexml=0)
    {
        self::$APIKEY = $apikey;
        self::$diag = $diag;
        self::$USEXML = $usexml;
    }
    public static function isBot($XIP="",$XMAIL="",$XNAME="")
    {
    ////////////////////////
    
        // sample query strings - you'd dynamically construct this 
        // string and use it as in the example below - these examples use the optional API 'key' field 
        // for more information on using the API key, please visit http://botscout.com
        
        // in most cases the BEST test is to use the "MULTI" query and test for the IP and email
        //$multi_test = "http://botscout.com/test/?multi&mail=$XMAIL&ip=$XIP&key=$APIKEY";
        
        /* you can use these but they're much less efficient and (possibly) not as reliable
        $test_string = "http://botscout.com/test/?mail=$XMAIL&key=$APIKEY";	// test email - reliable
        $test_string = "http://botscout.com/test/?ip=$XIP&key=$APIKEY";		// test IP - reliable
        $test_string = "http://botscout.com/test/?name=$XNAME&key=$APIKEY";	// test name (unreliable!)
        $test_string = "http://botscout.com/test/?all=$XNAME&key=$APIKEY";	// test all (see docs)
    */
    
        // make the url compliant with urlencode()
        $XMAIL = urlencode($XMAIL);
    
        // for this example we'll use the MULTI test 
        $test_string = "http://botscout.com/test/?multi&key=e1ZrPzhL6b7uXgT&mail=".$XMAIL."&ip=".$XIP."&name=".$XNAME;
        
        // are using an API key? If so, append it.
        
        // are using XML responses? If so, append the XML format key.
        if(self::$USEXML == 1)
        {
        	$test_string .= "&format=xml";
        }
        
        ////////////////////////
    
        
        ////////////////////////
        // use file_get_contents() or cURL? 
        // we'll user file_get_contents() unless it's not available 
        
        if(function_exists('file_get_contents'))
        {
        	// Use file_get_contents
        	self::$returned_data = file_get_contents($test_string);
        }
        else
        {
        	self::$ch = curl_init($test_string);
        	curl_setopt($ch, CURLOPT_HEADER, 0);
        	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	self::$returned_data = curl_exec($ch);
        	curl_close($ch);
        }
        
        
        
        // take the returned value and parse it (standard API, not XML)
        self::$botdata = explode('|', self::$returned_data); 
        
        // sample 'MULTI' return string 
        // Y|MULTI|IP|4|MAIL|26|NAME|30
        
        // $botdata[0] - 'Y' if found in database, 'N' if not found, '!' if an error occurred 
        // $botdata[1] - type of test (will be 'MAIL', 'IP', 'NAME', or 'MULTI') 
        // $botdata[2] - descriptor field for item (IP)
        // $botdata[3] - how many times the IP was found in the database 
        // $botdata[4] - descriptor field for item (MAIL)
        // $botdata[5] - how many times the EMAIL was found in the database 
        // $botdata[6] - descriptor field for item (NAME)
        // $botdata[7] - how many times the NAME was found in the database 
        
        
        if(substr(self::$returned_data, 0,1) == '!')
        {
        	// if the first character is an exclamation mark, an error has occurred  
        	print "Error: ".self::$returned_data;
        	return false;
        }
        
        
        // this example tests the email address and IP to see if either of them appear 
        // in the database at all. Either one is a fairly good indicator of bot identity. 
        if(self::$botdata[3] > 0 || self::$botdata[5] > 0)
        { 
        
        	if(self::$diag==1)
        	{ 
        		print "Bot signature found."; 
        		print "Type of test was: ".self::$botdata[1]; 
        		print "The {".self::$botdata[2]."} was found {".self::$botdata[3]."} times, the {".self::$botdata[4]."} was found {".self::$botdata[5]."} times"; 
        	} 
        
        	// your 'rejection' code would go here.... 
        	// for example, print a fake error message and return true the process. 
        	return true;
        
        }
        return false;
    }
}
?> 