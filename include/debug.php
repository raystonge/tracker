<?php
//
//  Tracker - Version 1.11.0
//
//  -v1.11.0
//    - added a debug level for adding text to debug string
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
if (!isset($debugtext))
	$debugtext = "";
if (!isset($debug))
	$debug = 1;
if (!isset($debugaddress))
	$debugaddress = "192.168.16.248|192.168.16.226|192.168.56.12|192.168.0.2|172.16.128.9|127.0.0.1|69.49.141.8|192.168.16.62|192.168.56.16|192.168.56.6|192.168.16.237| 192.168.56.23| 192.168.56.30 | 192.168.16.252";
	//$debugaddress ="";
$debugLevel = 5;

function DoDebug()
{
	global $debugaddress;
	global $debug;
	$remoteAddr = "";
	$debuguser = 0;
	if (isset($_SERVER['REMOTE_ADDR']))
	{
		$remoteAddr = $_SERVER['REMOTE_ADDR'];
	}
	$pos = false;
	if (strlen($remoteAddr))
	{
		$pos = strpos($debugaddress,$remoteAddr);
		if ($pos === false)
		{
			$debuguser = 0;
		}
		else
		{
		   $debuguser = 1;
		}
	}
	if (!$debuguser)
	{
		$debuguser = preg_match("/192\.168\.1\.([1-9]|[1-9][0-9]|1([0-9][0-9])|2([0-4][0-9]|5[0-4]))/",$remoteAddr);
	}
	return $debuguser;
}
function DebugPause($redirect)
{
	global $debug;

	$debuguser = DoDebug();
	$redirect = str_replace("//","/",$redirect);
	if (($debug == 1) && ($debuguser == 1))
	{
		echo "Redirecting to:".$redirect."<BR>";
		echo "<br><br><a href='".$redirect."'>Continue ...</a>";
		DebugOutput();
		echo "<br><br>Redirecting to:".$redirect."<BR>";
		echo "<br><br><a href='".$redirect."'>Continue ...</a>";
	  exit();
	}
	$redirectstr = "Location: ".$redirect;
	header($redirectstr);
	exit();
}
function DebugText($text,$level=10)
{
	global $debugtext;
	global $debug;
	global $debugtext;
  global $debugLevel;

  if ($level < $debugLevel)
  {
    return;
  }

	$debuguser = DoDebug();
	if (($debug == 1) && ($debuguser == 1))
	{
		$debugtext = $debugtext.$text."<BR>";
	}
}
function DebugOutput()
{
	global $debug;
	global $debugtext;

	$debuguser = DoDebug();
	if (($debug == 1) && ($debuguser == 1))
	{
		echo "<br><b>DEBUG INFO</b><BR>";
		//	echo "Template:".$template->includepage."<BR>";
		echo $debugtext;
		echo "<BR><b>SESSION VARIABLES</b><BR>";

		foreach ($_SESSION as $key=>$value)
	    {
	    	if (is_array($_SESSION[$key]))
	    	{
	    		echo "<pre>";
	    		echo $key."=";
	    		print_r ($_SESSION[$key]);
	    		echo "</pre>";
	    	}
	    	else
	    	{
	    		echo $key."=".$_SESSION[$key]."<br />";
	    	}
	    }
	    echo "<BR><b>POST</b><BR>";
	    foreach ($_POST as $key=>$value)
	    {
	    	if (is_array($_POST[$key]))
	    	{
	    		echo "<pre>";
	    		echo $key."=";
	    		print_r ($_POST[$key]);
	    		echo "</pre>";
	    	}
	    	else
	    	{
	    		echo $key."=".$_POST[$key]."<br />";
	    	}
	    }
	    echo "<BR><b>GET</b><BR>";
	    foreach ($_GET as $key=>$value)
	      echo $key."=".$_GET[$key]."<br />";
		echo "<BR><b>SERVER VARIABLES</b><BR>";
		$servervars = "'GATEWAY_INTERFACE','SERVER_ADDR','SERVER_NAME','SERVER_SOFTWARE','SERVER_PROTOCOL','REQUEST_METHOD','REQUEST_TIME','QUERY_STRING','DOCUMENT_ROOT','HTTP_ACCEPT','HTTP_ACCEPT_CHARSET','HTTP_ACCEPT_ENCODING','HTTP_ACCEPT_LANGUAGE','HTTP_CONNECTION','HTTP_HOST','HTTP_REFERER','HTTP_USER_AGENT','HTTPS','REMOTE_ADDR','REMOTE_HOST','REMOTE_PORT','SCRIPT_FILENAME','SERVER_ADMIN','SERVER_PORT','SERVER_SIGNATURE','PATH_TRANSLATED','SCRIPT_NAME','REQUEST_URI','PHP_AUTH_DIGEST','PHP_AUTH_USER','PHP_AUTH_PW','AUTH_TYPE'";
		$tok = strtok($servervars, ",");

		while ($tok !== false)
		{
			$tok = str_replace("'","",$tok);
			if (isset($_SERVER[$tok]))
				$val = $_SERVER[$tok];
			else
				$val = "";
			echo $tok.":".$val."<br />";
			$tok = strtok(",");
		}
		echo "<BR><b>ENV VARIABLES</b><BR>";
		foreach ($_ENV as $key=>$value)
	    {
	    	if (is_array($_ENV[$key]))
	    	{
	    		echo "<pre>";
	    		echo $key."=";
	    		print_r ($_ENV[$key]);
	    		echo "</pre>";
	    	}
	    	else
	    	{
	    		echo $key."=".$_ENV[$key]."<br />";
	    	}
	    }
	}
}
?>
