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
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listAssetType/">Asset Types</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();

    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/asset/assetTypeDepreciationSchedule.php">
  <table class="width100">
    <?php
     for ($i=1; $i <= $assetType->depreciationSchedule; $i++)
     {
       ?>
       <tr>
         <td>
           Year <?php echo $i;?>
         </td>
         <td>
           <?php
           $fieldName = "year".$i;
           CreateTextField($fieldName,$assetTypeDepreciationSchedule->$fieldName);
           ?>
         </td>
       </tr>
       <?php
     }
     ?>
	  <tr>
      <td>&nbsp;
      <?php

      CreateHiddenField("submitTest",1);
      CreateHiddenField("assetTypeId",$assetType->assetTypeId);
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
