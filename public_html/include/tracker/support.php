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
include_once "tracker/userToGroup.php";
include_once "tracker/userToOrganization.php";

function GetMyGroupsResetCache()
{
  global $currentUser;
  DebugText("GetMyGroupsResetCache()");
  $userToGroup = new UserToGroup();
  $myGroups = "";
  $ok = $userToGroup->Get("userId=$currentUser->userId");
  while ($ok)
  {
    if (strlen($myGroups))
	{
	  $myGroups = $myGroups.",".$userToGroup->userGroupId;
	}
	else
	{
	  $myGroups = $userToGroup->userGroupId;
	}
	$ok = $userToGroup->Next();
  }
  @setcookie("myGroups",$myGroups,time()+300);
  return($myGroups);
}

function GetMyGroups()
{
  global $currentUser;
  DebugText("GetMyGroups()");
  $userToGroup = new UserToGroup();
  if (isset($_COOKIE['myGroups']))
  {
    if ($_COOKIE['myGroups'] != "0")
    {
      DebugText("Using cached value:".$_COOKIE['myGroups']);
	    return ($_COOKIE['myGroups']);
	  }
  }
  $myGroups = "";
  $ok = $userToGroup->Get("userId=$currentUser->userId");
  while ($ok)
  {
    if (strlen($myGroups))
	  {
      $myGroups = $myGroups.",".$userToGroup->userGroupId;
	  }
	  else
	  {
      $myGroups = $userToGroup->userGroupId;
	  }
	  $ok = $userToGroup->Next();
  }
  DebugText("myGroups:".$myGroups);
  @setcookie("myGroups",$myGroups,time()+300);
  return($myGroups);
}

function isMemberOfGroup($userId,$groupName)
{
  DebugText("isMemberofGroup($userId,$groupName)");
  $userGroup = new UserGroup();
  $param = AddEscapedParam("", "name", $groupName);
  $userGroup->Get($param);
  $userToGroup = new UserToGroup();
  $param = AddEscapedParam("", "userId", $userId);
  $param = AddEscapedParam($param, "userGroupId", $userGroup->userGroupId);
  return ($userToGroup->Get($param));
}
function GetMyOrganizations()
{
  global $currentUser;
  DebugText("GetMyOrganizations()");
  $userToOrganization = new UserToOrganization();
  if (isset($_COOKIE['myOrganizations']))
  {
    if ($_COOKIE['myOrganizations'] != "0")
	  {
      DebugText("Using cached value:".$_COOKIE['myOrganizations']);
	    return ($_COOKIE['myOrganizations']);
	  }
  }
  $myOrganizations = "";
  $ok = $userToOrganization->Get("userId=$currentUser->userId");
  while ($ok)
  {
    if (strlen($myOrganizations))
	  {
	    $myOrganizations = $myOrganizations.",".$userToOrganization->organizationId;
	  }
	  else
	  {
	    $myOrganizations = $userToOrganization->organizationId;
	  }
	  $ok = $userToOrganization->Next();
  }
  DebugText("myOrganizations:".$myOrganizations);
  @setcookie("myOrganizations",$myOrganizations,time()+300);
  return($myOrganizations);
}

function CreateHistory($action,$property,$newVal,$oldVal)
{
  DebugText("newVal:".$newVal);
	DebugText("oldVal:".$oldVal);
	$historyVal="";
	if ($action == "Create")
	{
		if (!strlen($newVal))
		{
			$newVal = $oldVal;
		}
		$historyVal = "Setting ".$property." to ".$newVal;
	}
	else
	{
		if ($action == "Change")
		{
			DebugText("newVal:".$newVal);
			DebugText("oldVal:".$oldVal);
			if ($newVal != $oldVal)
			{
				//$historyVal = "Changed ".$property." to ".$oldVal." from ".$newVal;
				$historyVal = "Changed ".$property." from ".$newVal." to ".$oldVal;
			}
		}
		else
		{
			if ($action == "Remove")
			{
				$historyVal = "Removed ".$property." of ".$newVal;
			}
		}
	}
	return $historyVal;
}
function AddParam($param,$newParam)
{
  if (strlen($param))
  {
    $param = $param." and ".$newParam;
  }
  else
  {
    $param = $newParam;
  }
  return($param);
}

function AddEscapedFullLikeParam($param,$newParam,$value)
{
  global $link_cms;
  if (strlen($param))
  {
    $param = $param." and ".$newParam." like '%".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  else
  {
    $param = $newParam." like '%".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  return($param);
}
function AddEscapedLikeParam($param,$newParam,$value)
{
  global $link_cms;
  if (strlen($param))
  {
    $param = $param." and ".$newParam." like '".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  else
  {
    $param = $newParam." like '".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  return($param);
}

function AddEscapedLikeParamIfNotBlank($param,$newParam,$value)
{
  global $link_cms;
  if (!strlen(trim($value)))
  {
  	return $param;
  }

  if (strlen($param))
  {
    $param = $param." and ".$newParam." like '".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  else
  {
    $param = $newParam." like '".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  return($param);
}

function AddEscapedParam($param,$newParam,$value)
{
  global $link_cms;
  if (strlen($param))
  {
    $param = $param." and ".$newParam."='".mysqli_real_escape_string($link_cms,$value)."'";
  }
  else
  {
    $param = $newParam."='".mysqli_real_escape_string($link_cms,$value)."'";
  }
  return($param);
}
function AddEscapedParamWithTest($param,$newParam,$test,$value)
{
  global $link_cms;
  if (strlen($param))
  {
    $param = $param." and ".$newParam.$test."'".mysqli_real_escape_string($link_cms,$value)."'";
  }
  else
  {
    $param = $newParam.$test."'".mysqli_real_escape_string($link_cms,$value)."'";
  }
  return($param);
}

function AddEscapedParamIfNotBlank($param,$newParam,$value)
{
  global $link_cms;
  if (!strlen(trim($value)))
  {
  	return $param;
  }
  if (strlen($param))
  {
    $param = $param." and ".$newParam."='".mysqli_real_escape_string($link_cms,$value)."'";
  }
  else
  {
    $param = $newParam."='".mysqli_real_escape_string($link_cms,$value)."'";
  }
  return($param);
}
function AddOrEscapedParam($param,$newParam,$value)
{
  global $link_cms;
  DebugText("incoming param:".$param);
  if (strlen($param))
  {
    $param = $param." or ".$newParam."='".mysqli_real_escape_string($link_cms,$value)."'";
  }
  else
  {
    $param = $newParam."='".mysqli_real_escape_string($link_cms,$value)."'";
  }
  DebugText("resulting param:".$param);
  return($param);
}
function AddOrFullLikeEscapedParam($param,$newParam,$value)
{
  global $link_cms;
  DebugText("AddOrFullLikeEscapedParam($param,$newParam,$value)");
  DebugText("incoming param:".$param);
  if (strlen($param))
  {
    $param = $param." or ".$newParam." like '%".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  else
  {
    $param = $newParam." like '%".mysqli_real_escape_string($link_cms,$value)."%'";
  }
  DebugText("resulting param:".$param);
  return($param);
}
function AddOrParam($param,$newParam)
{
  if (strlen($param))
  {
    $param = $param." or ".$newParam;
  }
  else
  {
    $param = $newParam;
  }
  return($param);
}


function isAlpha($c)
{
  $c = strtolower($c);
  if (($c >='a') && ($c <='z'))
  {
    return(1);
  }
  return(0);
}
function isNumeric($c)
{
	return(is_numeric($c));
}
function isAlphaNumeric($c,$allowSpace)
{
  $val = 0;
  $val = isNumeric($c) || isAlpha($c);
  if ($allowSpace && ($c == ' '))
  {
    $val = 1;
  }
  return($val);
}
function add_date($givendate,$day=0,$mth=0,$yr=0)
{
	$cd = strtotime($givendate);
	$newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
	date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
	date('d',$cd)+$day, date('Y',$cd)+$yr));
	return $newdate;
}
function AddField($line,$field)
{
	if (strlen($line))
	{
		$line = $line . ',"'.$field.'"';
	} else
	{
		$line = '"'.$field.'"';
	}
	return ($line);
}
function AddLine($text,$line)
{
	if (strlen($text))
	{
		$text = $text . $line."\n\r";
	} else
	{
		$text = $line."\n\r";
	}
	return ($text);
}
function canEnterOrder()
{
	global $sessionUserId;
	global $adRepCanEnterAds;
	global $designerCanEnterAds;
	global $designerCanEnterAds;

	$userId = $_SESSION[$sessionUserId];
	$user = new User($userId);
	$canEnter = 0;
	if ($user->IsAdmin() || $user->IsSiteAdmin() || $user->IsDeveloper() || $user->IsProduction())
	{
		$canEnter = 1;
	}
	if ($user->IsAdrep())
	{
		$canEnter = $canEnter || $adRepCanEnterAds;
	}
	if ($user->IsDesigner())
	{
		$canEnter = $canEnter || $designerCanEnterAds;
	}
  return $canEnter;

}
function trimText($text,$maxLen = 30)
{
	//$maxLen = 30;
	DebugText("trimText:".$text);
	$len = strlen($text);
	DebugText("len:".$len);
	if ($len > $maxLen)
	{
		$text = substr($text,0,$maxLen)."...";
	}
	DebugText("text:".$text);
	return $text;
}
function fixFlag($val)
{
  if ($val >= 0)
  {
    return $val;
  }
  if (!strlen($val))
  {
    return 0;
  }
  if ($val >= 1)
  {
    return 1;
  }
  return 0;

}
function DisplayText($text,$maxLen = 30)
{
	echo trimText($text,$maxLen);
}
function validIPAddress($ipAddress)
{
  $valid = false;
  $regexp = '/^((1?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(1?\d{1,2}|2[0-4]\d|25[0-5])$/';

  if (preg_match($regexp, $ipAddress))
  {
    $valid = true;
  }
  return $valid;
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL)
        && preg_match('/@.+\./', $email);
}
function GetURLVar($key,$default="")
{
	$val = $default;
	if (isset($_GET[$key]))
	{
		$val = trim($_GET[$key]);
	}
	return $val;
}
function GetURI($index,$default="")
{
	global $request_uri;

	$val = $default;
	if (isset($request_uri[$index]))
	{
		if (strlen($request_uri[$index]))
		{
			$val = $request_uri[$index];
		}
	}
	DebugText("GetURI($index,$default):$val");
	return $val;
}

function GetTextField($fieldName,$default="")
{
	$val = $default;
	if (isset($_POST[$fieldName]))
	{
		$val = trim(strip_tags($_POST[$fieldName]));
	}
	DebugText("GetTextField($fieldName,$default):$val");
	return $val;

}
function GetDateField($fieldName,$default="")
{
	$val = $default;
	if (isset($_POST[$fieldName]))
	{
		$val = trim(strip_tags($_POST[$fieldName]));
	}
	$val = str_replace("/","-",$val);
	DebugText("GetDateField($fieldName,$default):$val");
	return $val;

}

function GetDropDownField($fieldName,$default=0)
{
	$val = $default;
	if (isset($_POST[$fieldName]))
	{
		$val = trim(strip_tags($_POST[$fieldName]));
	}
	DebugText("GetDropDownField($fieldName,$default):$val");
	return $val;
}
function GetTextFromSession($key,$default="",$clear=1)
{
	$val = $default;
	if (isset($_SESSION[$key]))
	{
		DebugText("SESSION[$key]:".$_SESSION[$key]);
		$val = $_SESSION[$key];
	}
	if ($clear)
	{
		unset($_SESSION[$key]);
	}
	DebugText("GetTextFromSession($key,$default,$clear):$val");
	return $val;
}
function UpgradeAvailable()
{
	global $sitePath;
	global $siteRootPath;
	$permission = new Permission();
  $control = new Control();
  $param = "sectionValue='SysConfigs' and keyValue='SysVersion'";
  $control->Get($param);
  $currentVersion = $control->valueInt;
  $fileList = array();
  $arrayIndex = 0;
	 $dir = $siteRootPath."/sysUpdates";
	 if ($dh = opendir($dir))
	 {
	 	while (($file = readdir($dh)) !== false)
	 	{
	 		if (!is_dir($file))
	 		{
	 			$file = str_replace(".txt","",$file);
	 			if ($file > $currentVersion &&  is_numeric($file))
  		    {
  		    	$fileList[$arrayIndex++] = $file;
  		    }
      }
   	}
   	closedir($dh);
    if ($permission->hasPermission("Config: Upgrade"))
    {
     	if (sizeof($fileList))
     	{
     		?>
     		<fieldset class="upgradeAvailable">
     		 System Verion <?php echo $fileList[$arrayIndex-1];?> is available. <a href="/upgrade/">Upgrade Now</a>
     		</fieldset>
     		<br>
     		<?php
     	}
	  }
	}
  return(sizeof($fileList));
}
function PrintNBSP()
{
	echo "&nbsp;";
}
function PrintBR()
{
	echo "<br>";
}
function CreateTextAreaField($name,$val="",$fieldSize=0,$title="",$rows=4,$cols=50,$class="ui-corner-left ui-corner-right")
{
	global $showMouseOvers;
	DebugText("CreateTextAreaField($name,$val,$fieldSize,$title)");
	$maxLength = "";
	if ($fieldSize)
	{
		$maxLength = "maxLength='$fieldSize'";
	}
	$displayTitle = "";
	if ($showMouseOvers && strlen($title))
	{
	  $displayTitle = "title='$title'";
	}
	if (strlen($class))
	{
		$class = "class='$class'";

	}

	?>
  <textarea id="<?php echo $name;?>" name="<?php echo $name;?>" rows="<?php echo $rows;?>" cols="<?php echo $cols;?>" <?php echo $class;?>><?php echo $val;?></textarea>
	<?php
}
function CreateTextField($name,$val="",$fieldSize=0,$title="",$class="ui-corner-left ui-corner-right")
{
	global $showMouseOvers;
	DebugText("CreateTextField($name,$val,$fieldSize,$title)");
	$maxLength = "";
	if ($fieldSize)
	{
		$maxLength = "maxLength='$fieldSize'";
	}
	$displayTitle = "";
	if ($showMouseOvers && strlen($title))
	{
	  $displayTitle = "title='$title'";
	}
	if (strlen($class))
	{
		$class = "class='$class'";

	}

	?>
	<input type="text" <?php echo $displayTitle;?> name="<?php echo $name;?>" id="<?php echo $name;?>" <?php echo $class;?> value="<?php echo $val;?>" <?php echo $maxLength;?>/>
	<?php
}
function CreatePasswordField($name,$val="",$fieldSize=0,$title="",$class="ui-corner-left ui-corner-right")
{
	global $showMouseOvers;
	DebugText("CreatePasswordld($name,$val,$fieldSize,$title)");
	$maxLength = "";
	if ($fieldSize)
	{
		$maxLength = "maxLength='$fieldSize'";
	}
	$displayTitle = "";
	if ($showMouseOvers && strlen($title))
	{
	  $displayTitle = "title='$title'";
	}
	if (strlen($class))
	{
		$class = "class='$class'";

	}

	?>
	<input type="password" <?php echo $displayTitle;?> name="<?php echo $name;?>" id="<?php echo $name;?>" <?php echo $class;?> value="<?php echo $val;?>" <?php echo $maxLength;?>/>
	<?php
}

function CreateHiddenField($name,$val="")
{
	DebugText("CreateTextField($name,$val)");
	?>
	<input type="hidden" name="<?php echo $name;?>" id="<?php echo $name;?>" class="ui-corner-left ui-corner-right" value="<?php echo $val;?>"/>
	<?php

}
function CreateSubmit($name="submit",$val="Submit",$class = "")
{
	DebugText("CreateSubmit($name,$val)");
	if (strlen($class))
	{
		$class="class='$class'";
	}
	?>
	<input type="submit" name="<?php echo $name;?>" id="<?php echo $name;?>"  value="<?php echo $val;?>" <?php echo $class;?>/>
	<?php

}
function CreateResetButton($name="reset",$val="Reset",$class = "")
{
	DebugText("CreateSubmit($name,$val)");
	if (strlen($class))
	{
		$class="class='$class'";
	}
	?>
	<input type="button" name="<?php echo $name;?>" id="<?php echo $name;?>"  value="<?php echo $val;?>" <?php echo $class;?>/>
	<?php

}

function CreateButton($name,$val="Submit")
{
	DebugText("CreateButton($name,$val)");
	?>
	<input type="button" name="<?php echo $name;?>" id="<?php echo $name;?>"  value="<?php echo $val;?>"/>
	<?php

}

function CreateYesNo()
{
?>
	<input type="button" name="yes" id="yes"  value="Yes"/>
	&nbsp;
	<input type="button" name="no" id="no"  value="No"/>
<?php
}

function CreateFileField($name,$title="")
{
	global $showMouseOvers;
	DebugText("CreateFileField($name,$title)");

	$displayTitle = "";
	if ($showMouseOvers && strlen($title))
	{
	  $displayTitle = "title='$title'";
	}
	?>
	<input type="file" <?php echo $displayTitle;?> name="<?php echo $name;?>" id="<?php echo $name;?>" class="ui-corner-left ui-corner-right" />
	<?php
}
function CreateCheckBox($name,$val,$dspVal="",$checked=0,$title="",$class="",$js="")
{
	global $showMouseOvers;
	DebugText("CreateCheckBox($name,$val,$dspVal,$checked,$title,$class)");
	$displayTitle = "";
	if ($showMouseOvers && strlen($title))
	{
	  $displayTitle = "title='$title'";
	}
	if (strlen($class))
	{
		$class = "class='$class'";
	}
	$dspChecked = "";
	if ($checked)
	{
		$dspChecked = "checked='checked'";
	}
	DebugText("js:".$js);
	?>
	<input type="checkbox" <?php echo $dspChecked;?> <?php echo $displayTitle;?> name="<?php echo $name;?>" id="<?php echo $name;?>" <?php echo $class;?> value="<?php echo $val;?>" <?php echo $js;?>>&nbsp;<?php echo $dspVal;?>
	<?php
}
function CreateDateField($name,$val = "")
{
	global $today;
	if (strlen($val)==0)
	{
		$val = $today;
	}
	?>
	<script>DateInput('<?php echo $name;?>', true, 'YYYY/MM/DD','<?php echo $val;?>')</script>
	<?php
}

function CreateLink($href,$linkValue,$id="",$title="",$class="")
{
	global $showMouseOvers;

	if (strlen($class))
	{
		$class = "class='$class'";
	}
	if ($showMouseOvers && strlen($title))
	{
		$title = "title='$title'";
	}
	else
	{
		$title = "";
	}
	if (strlen($id))
	{
		$id = "id='$id'";
	}
	?>
	<a href="<?php echo $href;?>"<?php echo $id; echo $class; echo $title;?>><?php echo $linkValue;?></a>
	<?php
}
function CreateLinkNewWindow($href,$linkValue,$id="",$title="",$class="")
{
	global $showMouseOvers;

	if (strlen($class))
	{
		$class = "class='$class'";
	}
	if ($showMouseOvers && strlen($title))
	{
		$title = "title='$title'";
	}
	else
	{
		$title = "";
	}
	if (strlen($id))
	{
		$id = "id='$id'";
	}
	?>
	<a target="_blank" href="<?php echo $href;?>"<?php echo $id; echo $class; echo $title;?>><?php echo $linkValue;?></a>
	<?php
}

function CreateSelect($name,$values,$selectedVal="",$defaultVal="",$defaultText="",$class="")
{
  DebugText("CreateSelect($name,'vals',$selectedVal,$defaultVal,$defaultText,$class)");
  ?>
  <select name="<?php echo $name;?>" id="<?php echo $name;?>">
  </select>
  <?php
}
function FormErrors()
{
	$errors = 0;
	if (isset($_SESSION['formErrors']))
	{
		if (strlen(trim($_SESSION['formErrors'])))
		{
			DebugText("formErrors:".$_SESSION['formErrors']);
			$errors = 1;
		}
	}
	return ($errors);
}

function DisplayFormErrors()
{
	if (FormErrors())
	{
		if ($_SESSION['formErrors'] == "Success")
		{
         ?>
         <div class="feedback success">
          <?php
            echo $_SESSION['formErrors'];
            $_SESSION['formErrors'] = "";
          ?>
         </div>
         <?php
		}
		else
		{
          ?>
          <div class="feedback error">
          <?php
            echo $_SESSION['formErrors'];
            $_SESSION['formErrors'] = "";
          ?>
          </div>
          <?php
		}
	}
}
function FormSuccess()
{
	DebugText("FormSuccess()");
	$errors = 0;
	if (isset($_SESSION['formSuccess']))
	{
		DebugText("form");
		if (strlen(trim($_SESSION['formSuccess'])))
		{
			$errors = 1;
		}
	}
	return ($errors);
}

function DisplayFormSuccess()
{
	if (FormSuccess())
	{
		if ($_SESSION['formSuccess'] == "Success")
		{
         ?>
         <div class="feedback success">
          <?php
            echo $_SESSION['formSuccess'];
            $_SESSION['formSuccess'] = "";
          ?>
         </div>
         <?php
		}
	}
}
function SetFocus($id)
{
	DebugText("SetFocus($id");
	?>
	<script language="javascript">
	$(document).ready(function () {
		$("#<?php echo $id;?>").focus();
	});
	</script>
	<?php
}
function OpenBlockTicket($ticketId)
{
	global $sitePath;
	global $now;
	$blockTicket = new Ticket($ticketId);

	if ($blockTicket->statusId == 4)
	{
		$blockTicket->statusId = 5;
		$blockTicket->Update();
		$history = new History();
		$history->ticketId = $blockTicket->ticketId;
		$history->userId = $_SESSION['userId'];
		$history->actionDate = $now;
		$history->action = "Ticket: ".$ticket->ticketId." is not closed";
		$history->Insert();
		$ticketCC = new TicketCC();
		$param = "ticketId=".$blockTicket->ticketId;
		$ok = $ticketCC->Get($param);
		$ccAddresses = new Set(",");
		while ($ok)
		{
			$ccAddresses->Add($ccUser->email);
			$ok = $ticketCC->Next();
		}
		$owner =  new User($blockTicket->ownerId);
		$to = $owner->email;
		$message = "Ticket: ".$ticket->ticketId." has been set to a non-closed status causing ticket ".$blockTicket->ticketId." to be re-opened";
		$link = $sitePath."/ticketEdit/".$blockTicket->ticketId."/";
		$historyArray = "";
		$message = "A dependent ticket has been re-opened";
		$link = "";
		$historyArray = "";
		$requestorEmail = "";
		$requestor = new User($blockTicket->requestorId);
		if ($userToGroup->IsMember($requestor->userId, "eMail Recipents"))
		{
		    $requestorEmail= $requestor->email;
		}
		TicketNotice($to,$ccAddresses->data,$blockTicket->subject,$message,$link,$historyArray);
		$ticketDependencies = new TicketDependencies();
		$param = "dependsId=".$blockTicket->ticketId." and status =4";
		$ok = $ticketDependencies->Get($param);
		while ($ok)
		{
			OpenBlockTicket($ticketDependencies->blockId);
		}
	}
}
function getAppVersion()
{
  DebugText("getAppVerison");
  global $siteRootPath;
  $version = GetTextFromSession("appVersion");
  if (!strlen($version))
  {
    DebugText($siteRootPath."/tmp/version.txt");
    $version = file_get_contents($siteRootPath."/tmp/version.txt");
  }
  $_SESSION['appVersion'] = $version;
  DebugText("version:".$version);
  return ($version);
}

function getAppBuld()
{
  global $sitePath;
  global $siteRootPath;
  DebugText("getAppBuld");

  $build = GetTextFromSession("appBuild","");

  if (strlen($build))
  {
    DebugText("found build:".$build);
    return $build;
  }

  $control = new Control();
  $param = "sectionValue='SysConfigs' and keyValue='SysVersion'";
  $control->Get($param);
  $currentVersion = $control->valueInt;
  $fileList = array();
  $arrayIndex = 0;
  $dir = $siteRootPath."/sysUpdates";
  DebugText("currentVersion:".$currentVersion);
  if ($dh = opendir($dir))
  {
    while (($file = readdir($dh)) !== false)
    {
      if (!is_dir($file))
      {
        $file = str_replace(".txt","",$file);
        if (is_numeric($file))
          {
            $fileList[$arrayIndex++] = $file;
          }
        }
    }
    closedir($dh);
    if (sizeof($fileList))
    {
      $build = 0;
      for ($i = 0; $i < sizeof($fileList);$i++)
      {
        if ($fileList[$i] > $build)
        {
          $build = $fileList[$i];
        }
      }
      DebugText("build:".$build);
      $_SESSION['appBuild'] = $build;
    }
  }
  return $build;
}
function CreateDatePicker($name,$value)
{
  $date = DatePickerFormatter($value);
  ?>
  <script>
    $( function() {
      $( "#<?php echo $name;?>" ).datepicker({
         showButtonPanel: true
      });
    } );
   </script>
   <input type="text" id="<?php echo $name;?>" name="<?php echo $name;?>" value="<?php echo $date; ?>">
  <?php
}
function DatePickerFormatter($date)
{
  if (!strlen($date))
  {
    return $date;
  }
  $date = str_replace("/","-",$date);
 list ($year,$month,$day) = explode("-",$date);
 $newDate = $month."/".$day."/".$year;
 return $newDate;
}
function DatePickerUnFormatter($date)
{
  if (!strlen($date))
  {
    return $date;
  }
  $date = str_replace("/","-",$date);
  list ($month,$day,$year) = explode("-",$date);
  $newDate = $year."-".$month."-".$day;
  return $newDate;
}
?>
