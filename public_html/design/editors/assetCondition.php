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
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listAssetCondition/">Asset Condition</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
   		$assetCondition->name = GetTextFromSession("name");
   		$assetCondition->showAll = GetTextFromSession("showAll",0);
    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/assetCondition.php">
  <table class="width100">

    <tr>
      <td>Asset Condition:
      </td>
      <td>
      <?php CreateTextField("name",$assetCondition->name,getFieldSize("assetType","name"),"Name for Asset Type",$editFieldClass);?>
      </td>
      <td>
    </tr>
		      <!--
    <tr>
      <td>
      Monitor:
      </td>
      <td>

        <select name="monitor">
          <option value="0">No Monitor</option>
          <option value="ping" <?php if ($assetCondition->monitorType == "ping") { echo "selected='selected'";}?>>Ping IP</option>
          <option value="URL" <?php if ($assetCondition->monitorType == "URL") { echo "selected='selected'";}?>>URL</option>
          <option value="pingAddress" <?php if ($assetCondition->monitorType == "pingAddress") { echo "selected='selected'";}?>>Ping Address</option>
        </select>

        <?php
      //  CreateCheckBox("monitor",1,"",$assetCondition->monitor,"Can asset type be monitored","checkbox");
        ?>
      </td>
    </tr>
		-->
		<tr>
			<td>
				Show All
			</td>
			<td>
				<?php
				 CreateCheckBox("showAll",1,"",$assetCondition->showAll,"Are assets shown when selecting Show All","checkbox");
				?>
			</td>
		</tr>

    <tr>
      <td>&nbsp;
      <?php
      CreateHiddenField("cnt",$cnt);
      CreateHiddenField("submitTest",1);
      CreateHiddenField("assetConditionId",$assetCondition->assetConditionId);
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
