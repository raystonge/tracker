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
include_once "tracker/organization.php";
include_once "tracker/asset.php";
$asset= new Asset();
PageAccess("Asset: Create");
?>
<div class="adminArea">
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a> -> New Asset</h2>
<form action="/assetNew/" method="post">
        	<select name="organization" id="organization">
        	  <option value="0">Select <?php echo $orgOrDept;?></option>
        	<?php

        	$param = "organizationId in (".GetMyOrganizations().")";
        	$organization= new Organization();
        	$ok = $organization->Get($param);
        	while ($ok)
        	{
        		$selected = "";
        		if ($asset->organizationId == $organization->organizationId)
        		{
        			$selected = "selected='selected'";
        		}
        		?>
        		<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
        		<?php
        		$ok = $organization->Next();
        	}
        	?>
        	</select>
        	<br>
        	<br>
	<?php
	               PrintFormKey();
               CreateHiddenField("submitTest",1);
               CreateSubmit("Continue","Continue");
	?>
</form>
</div>
