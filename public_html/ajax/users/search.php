<?php
/*
 * Created on Feb 6, 2013
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
$ok = $user->Get($param);
while($ok)
{
	$json->AddValue("id",$user->userId);
	$json->AddValue("label",$user->fullName);
	$json->CreateRecord();
	$ok = $user->Next();
}
echo $json->GetArray();
//DebugOutput();
?>