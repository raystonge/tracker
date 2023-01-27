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
include_once "tracker/organization.php";
include_once "tracker/assetType.php";
$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;
?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listSpecs/">Spec</a></h2>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
   		$spec->name = GetTextFromSession("name");
   		$spec->dataType = GetTextFromSession("dataType",0);
    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/spec.php">
  <table class="width100">
<!--
    <tr>
      <td>Asset Type:
      </td>
      <td>
        <select name="$assetTypeId">
					<?php
					$assetType = new AssetType();
					$assetType->SetOrderBy("organizationId,name");
					$ok = $assetType->Get("hasSpecs=1");
					while ($ok)
					{
						$selected="";
						if ($assetType->assetTypeId == $spec->assetTypeId)
						{
							$selected = "selected='selected'";
						}
						$organization = new Organization($assetType->organizationId);
						?>
						<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $organization->name." - ".$assetType->name;?></option>
						<?php
						$ok = $assetType->Next();
					}

					 ?>

				</select>

      </td>
      <td>
    </tr>
-->
		<tr>
			<td>
				Name
			</td>
			<td>
				<?php
				 CreateTextField("name",$spec->name);
				?>
			</td>
		</tr>
		<tr>
			<td>
				Data Type
			</td>
			<td>
				<select name="dataType">
					<option value="text" <?php if ($spec->dataType == "text"){echo "selected='selected'";}?>>Text</option>
					<option value="checkbox" <?php if ($spec->dataType == "text"){echo "selected='selected'";}?>>Checkbox</option>
				</select>
			</td>
		</tr>

    <tr>
      <td>&nbsp;
      <?php
      CreateHiddenField("cnt",$cnt);
      CreateHiddenField("submitTest",1);
      CreateHiddenField("specId",$spec->specId);
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
