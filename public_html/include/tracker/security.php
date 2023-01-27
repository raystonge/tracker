<?php
//
//  Tracker - Version 1.0
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
?>
<?php
include_once "tracker/permission.php";
function PageAccess($permissionName, $permissionName1="")
{
	global $sitePath;
	$permission = new Permission();
	if (!$permission->hasPermission($permissionName) && strlen($permissionName1)==0)
	{
		include $sitePath."/design/noAccess.php";
		exit;
	}
	if (!$permission->hasPermission($permissionName) && !$permission->hasPermission($permissionName1))
	{
		include $sitePath."/design/noAccess.php";
		exit;
	}
}
function ProperAccessTest($keyName="formKey")
{
	//This function does not clear the session variable
	global $sitePath;
	DebugText("ProperAccessTest($keyName)");
	global $skipSecurityTest;
	if ($skipSecurityTest)
	{
		return(1);
	}
	$sessionKey = "";
	$formKey = "";
	if (isset($_SESSION[$keyName]))
	{
		$sessionKey = $_SESSION[$keyName];
	}
	if (isset($_POST[$keyName]))
	{
		$formKey = strip_tags($_POST[$keyName]);
	}
	if (isset($_GET[$keyName]))
	{
		$formKey = strip_tags($_GET[$keyName]);
	}
	if ((strlen($sessionKey) == 0) || (strlen($formKey) == 0))
	{
		DebugText("length is zero");
		DebugText("sessionKey:".$sessionKey.":".strlen($sessionKey));
		DebugText("formKey:".$formKey.":".strlen($formKey));
	include $sitePath."/design/improperAccess.php";
	exit;
		return (0);
	}
	if ($sessionKey == $formKey)
	{
		DebugText("keys are equal");
		return(1);
	}
	DebugText("keys are not equal");
	include $sitePath."/design/improperAccess.php";
	exit;
}
function ProperAccessValidate($keyName="formKey")
{
	//This function does clear the SESSION variable
	global $sitePath;
	DebugText("ProperAccessValidate($keyName)");
	global $skipSecurityTest;
	if ($skipSecurityTest)
	{
		DebugText("skipSecurityTest:true");
		return(1);
	}
	$sessionKey = "";
	$formKey = "";
	if (isset($_SESSION[$keyName]))
	{
		$sessionKey = $_SESSION[$keyName];
	}
	if (isset($_POST[$keyName]))
	{
		$formKey = strip_tags($_POST[$keyName]);
	}
	if (isset($_GET[$keyName]))
	{
		$formKey = strip_tags($_GET[$keyName]);
	}
	$_SESSION[$keyName] = "";
	if ((strlen($sessionKey) == 0) || (strlen($formKey) == 0))
	{
		DebugText("length is zero");
		DebugText("sessionKey:".$sessionKey.":".strlen($sessionKey));
		DebugText("formKey:".$formKey.":".strlen($formKey));
		include $sitePath."/design/improperAccess.php";
		exit;
		return (0);
	}
	if ($sessionKey == $formKey)
	{
		DebugText("keys are equal");
		return(1);
	}
	DebugText("keys are not equal");
	include $sitePath."/design/improperAccess.php";
	exit;
}

function PrintFormKey($key="formKey")
{
	?>
	<input type="hidden" name="<?php echo $key;?>" value="<?php echo getFormKey($key);?>"/>
	<?php
}
function PrintAJAXFormKey($key="ajaxFormKey")
{
	PrintFormKey($key);
}
function getFormKey($key="formKey")
{
	DebugText("getFormKey($key)");
	global $now;
	$val = "";
	if (isset($_SESSION[$key]))
	{
		if (strlen($_SESSION[$key]))
		{
			$val = $_SESSION[$key];
		}
		else
		{
			$val = md5($now);
		}
	}
	else
	{
		$val = md5($now);
	}
	$_SESSION[$key] = $val;
	return ($val);

}
function testFormKey($key="formKey")
{
	DebugText("testFormKey($key)");
	global $skipSecurityTest;
	if ($skipSecurityTest)
	{
		return(1);
	}

	$sessionKey = "";
	$formKey = "";
	if (isset($_SESSION[$key]))
	{
		$sessionKey = $_SESSION[$key];
	}
	if (isset($_POST[$key]))
	{
		$formKey = strip_tags($_POST[$key]);
	}
	if (isset($_GET[$key]))
	{
		$formKey = strip_tags($_GET[$key]);
	}
	$_SESSION[$key] = "";
	DebugText("sessionKey:".$sessionKey);
	DebugText("formKey:".$formKey);
	if ((strlen($sessionKey) == 0) || (strlen($formKey) == 0))
	{
		DebugText("keys are not equal");
		return (0);
	}
	if ($sessionKey == $formKey)
	{
		DebugText("keys are good");
		return(1);
	}
	DebugText("there is a problem with the keys");
	return(0);
}
function validateFormKey($key = "formKey")
{
	DebugText("validateFormKey($key)");
	global $skipSecurityTest;
	if ($skipSecurityTest)
	{
		return(1);
	}
	$sessionKey = "";
	$formKey = "";
	if (isset($_SESSION[$key]))
	{
		$sessionKey = $_SESSION[$key];
	}
	if (isset($_POST[$key]))
	{
		$formKey = strip_tags($_POST[$key]);
	}
	if (isset($_GET[$key]))
	{
		$formKey = strip_tags($_GET[$key]);
	}
	if ((strlen($sessionKey) == 0) || (strlen($formKey) == 0))
	{
		DebugText("length is zero");
		DebugText("sessionKey:".$sessionKey.":".strlen($sessionKey));
		DebugText("formKey:".$formKey.":".strlen($formKey));
		return (0);
	}
	if ($sessionKey == $formKey)
	{
		DebugText("keys are equal");
		return(1);
	}
	DebugText("keys are not equal");
	return(0);
}
function getAJAXFormKey($key="ajaxFormKey")
{
	DebugText("getAJAXFormKey($key)");
	return getFormKey($key);
}
function validateAJAXFormKey($key="ajaxFormKey")

{
	DebugText("validateAJAXFormKey($key)");
	return (validateFormKey($key));
}
function testAJAXFormKey($key="ajaxFormKey")
{
	DebugText("testAJAXFormKey($key)");
	return testFormKey($key);
}
?>
