<?php
/*
 * Created on Mar 17, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/assetCredentials.php";
include_once "tracker/defaultUser.php";
include_once "tracker/permission.php";
$_SESSION['formErrors'] ="";
$validAccess = testFormKey();
DebugText("validAccess:".$validAccess);
if ($validAccess == 0)
{
	DebugText("problem with keys");
   DebugPause("/improperAccess/");
}
$assetCredentials = new AssetCredentials();
$assetCredentialsId = GetTextField("assetCredentialsId",0);
$assetId = GetTextField("assetId",0);
$userName = GetTextField("userName");
$password = GetTextField("password");
$numErrors = 0;

if (strlen($userName) == 0)
{
    $numErrors++;
    $errorMsg=$errorMsg."<li>Please Specify UserName</li>";
}
if (strlen($password) == 0)
{
    $numErrors++;
    $errorMsg=$errorMsg."<li>Please Specify Password</li>";
}
if ($numErrors == 0)
{
    $assetCredentials->assetCredentialsId = $assetCredentialsId;
    $assetCredentials->assetId = $assetId;
    $assetCredentials->userName = $userName;
    $assetCredentials->password = $password;
    $assetCredentials->Persist();
    DebugPause("/assetCredentials/".$assetId."/");
}
else 
{
    $html = "<ul>".$errorMsg."</ul>";
    $_SESSION['formErrors'] = $html;
    $_SESSION['userName'] = $userName;
    $_SESSION['password'] = $password;
    if ($assetCredentialsId == 0)
    {
        DebugPause("/newUserCredentials/".$assetId."/");
    }
    DebugPause("/editUserCredentials/".$assetId."/".$assetCredentialsId."/");
    
    
}
?>