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
