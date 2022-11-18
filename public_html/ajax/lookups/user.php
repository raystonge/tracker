<?php
/*
 * Created on May 14, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/user.php";
include_once "JSON.php";
$name = "";
$json = new JSON();
if (isset($_GET['term']))
{
	$name = trim($_GET['term']);
}

$user = new User();

$param = AddEscapedLikeParam("","fullName","%".$name."%");
$param = AddEscapedParam($param,"uto.organizationId",GetTextFromSession("ticketEditOrg",0));
$ok = $user->GetRequestors($param);
while($ok)
{
	$userInfo = new User($user->userId);
	$json->AddValue("id",$user->userId);
	$json->AddValue("label",$userInfo->fullName);
	$json->CreateRecord();
	$ok = $user->Next();
}
echo $json->GetArray();
//DebugOutput();
?>
