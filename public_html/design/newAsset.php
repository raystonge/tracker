<?php
/*
 * Created on Dec 4, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/organization.php";
include_once "tracker/asset.php";
$asset= new Asset();
?>
<?php
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
