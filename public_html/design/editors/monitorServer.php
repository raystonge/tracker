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
include_once "tracker/user.php";
include_once "tracker/defaultUser.php";
include_once "tracker/organization.php";
$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;
?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listMonitorServer/">Monitor Servers</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
   		$monitorServer->name = GetTextFromSession("name");
    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/monitorServer.php">
  <table class="width100">
   

    <tr>
      <td>Monitor Server:
      </td>
      <td>
      <?php CreateTextField("name",$monitorServer->name,getFieldSize("monitorServer","name"),"Name for Monitor Server",$editFieldClass);?>
      </td>
      <td>
    </tr>

	  <tr>
      <td>&nbsp;
      <?php
      CreateHiddenField("cnt",$cnt);
      CreateHiddenField("submitTest",1);
      CreateHiddenField("monitorServerId",$monitorServer->monitorServerId);
      PrintFormKey();
      ?>
      </td>
      <td>
      <?php CreateSubmit("submit",$button);?>
      </td>
    </tr>
  </table>
</form>
</div>
