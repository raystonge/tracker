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
   		$assetType->name = GetTextFromSession("name");
   		$assetType->monitor = GetTextFromSession("monitor",0);
   		if ($assetType->monitor != "0")
   		{
   			$assetType->monitorType = $assetType->monitor;
   			$assetType->monitor = 1;
   		}
   		$assetType->hasMacAddress = GetTextFromSession("hasMacAddress",0);
   		$assetType->requireMacAddress = GetTextFromSession("requireMacAddress",0);
   		$assetType->hasContract = GetTextFromSession("hasContract",0);
   		$assetType->organizationId = GetTextFromSession("organizationId",0);
   		$assetType->hasAccessory = GetTextFromSession("hasAccessory",0);
   		$assetType->isAccessory = GetTextFromSession("isAccessory",0);
	 	  $assetType->hasUserPassword = GetTextFromSession("hasUserPassword",0);
		  $assetType->hasConstantMonitorDown = GetTextFromSession("hasConstantMonitorDown",0);
	  	$assetType->hasUserCredentials = GetTextFromSession("hasUserCredentials",0);
			$assetType->hasSpecs = GetTextFromSession("hasSpecs",0);
			$assetType->enforceCost = GetTextFromSession("enforceCost",0);
      $assetType->personalProperty = GetTextFromSession("personalProperty",0);
      $assetType->depreciationSchedule = GetTextFromSession("depreciationSchedule",0);
      $assetType->noSerialNumber = GetTextFromSession("noSerialNumber",0);
    }
    ?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/assetType.php">
  <table class="width100">
    <tr>
      <td><?php echo $orgOrDept;?>:
      </td>
      <td>
      			<select name="organization">

				<?php
				$organization = new Organization();
        $myOrganizations = GetMyOrganizations();
				$param = "organizationId in ($myOrganizations)";
				$ok = $organization->Get($param);
				while ($ok)
				{
					$selected = "";
					if ($assetType->organizationId == $organization->organizationId)
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
</td>
      <td>
    </tr>

    <tr>
      <td>Asset Type:
      </td>
      <td>
      <?php CreateTextField("name",$assetType->name,getFieldSize("assetType","name"),"Name for Asset Type",$editFieldClass);?>
      </td>
      <td>
    </tr>
    <tr>
      <td>
      Monitor:
      </td>
      <td>
        <select name="monitor">
          <option value="0">No Monitor</option>
          <option value="ping" <?php if ($assetType->monitorType == "ping") { echo "selected='selected'";}?>>Ping IP</option>
          <option value="URL" <?php if ($assetType->monitorType == "URL") { echo "selected='selected'";}?>>URL</option>
          <option value="pingAddress" <?php if ($assetType->monitorType == "pingAddress") { echo "selected='selected'";}?>>Ping Address</option>
        </select>

        <?php
        //CreateCheckBox("monitor",1,"",$assetType->monitor,"Can asset type be monitored","checkbox");
        ?>
      </td>
    </tr>
    <tr>
      <td>
      Contant Monitor:
      </td>
      <td>
        <select name="constantMonitor">
          <option value="0">No Constant Monitor</option>
          <option value="1" <?php if ($assetType->hasConstantMonitorDown) { echo "selected='selected'";}?>>Constant Monitor</option>
        </select>

        <?php
        //CreateCheckBox("monitor",1,"",$assetType->monitor,"Can asset type be monitored","checkbox");
        ?>
      </td>
    </tr>

    <tr>
      <td>
      Has Mac Address:
      </td>
      <td>
        <?php
        CreateCheckBox("hasMacAddress",1,"",$assetType->hasMacAddress,"Does the asset have a MAC address","checkbox");
        ?>
      </td>
    </tr>
    <tr>
      <td>
      Require Mac Address:
      </td>
      <td>
        <?php
        CreateCheckBox("requireMacAddress",1,"",$assetType->requireMacAddress,"Is a MAC address required for this asset type","checkbox");
        ?>
      </td>
    </tr>
    <tr>
      <td>
      Has Contract:
      </td>
      <td>
        <?php
        CreateCheckBox("contract",1,"",$assetType->hasContract,"Does the asset have a support contract","checkbox");
        ?>
      </td>
    </tr>
   <tr>
      <td>
      Has Accessories:
      </td>
      <td>
        <?php
        CreateCheckBox("hasAccessory",1,"",$assetType->hasAccessory,"Can this assest have accessories","checkbox");
        ?>
      </td>
    </tr>
   <tr>
      <td>
      Is Accessory:
      </td>
      <td>
        <?php
        CreateCheckBox("isAccessory",1,"",$assetType->isAccessory,"Is this access type an accessory","checkbox");
        ?>
      </td>
    </tr>
		<tr>
      <td>
      Has Admin account:
      </td>
      <td>
        <?php
        CreateCheckBox("hasUserPassword",1,"",$assetType->hasUserPassword,"Does the asset have an admin account","checkbox");
        ?>
      </td>
    </tr>
    </tr>
		<tr>
      <td>
      Has User Credentials:
      </td>
      <td>
        <?php
        CreateCheckBox("hasUserCredentials",1,"",$assetType->hasUserCredentials,"Does the asset have an User Accounts","checkbox");
        ?>
      </td>
    </tr>
		<tr>
      <td>
      Has Specs:
      </td>
      <td>
        <?php
        CreateCheckBox("hasSpecs",1,"",$assetType->hasSpecs,"Does the asset have specs","checkbox");
        ?>
      </td>
    </tr>
    <tr>
      <td>
      No Serial Number :
      </td>
      <td>
        <?php
        CreateCheckBox("noSerialNumber",1,"",$assetType->noSerialNumber,"Check if the asset does not require a serial number","checkbox");
        ?>
      </td>
    </tr>
		<tr>
      <td>
      Enforce Cost:
      </td>
      <td>
        <?php
        CreateCheckBox("enforceCost",1,"",$assetType->enforceCost,"Enforce the cost of the Asset","checkbox");
        ?>
      </td>
    </tr>
    <tr>
      <td>
      Personal Property :
      </td>
      <td>
        <?php
        CreateCheckBox("personalProperty",1,"",$assetType->personalProperty,"Check if the asset should be on the personal property report","checkbox");
        ?>
      </td>
    </tr>
    <tr>
      <td>
      Depreciation Schedule :
      </td>
      <td>
        <?php DebugText("depreciationSchedule:".$assetType->depreciationSchedule);?>
        <select id="depreciationSchedule" name="depreciationSchedule">
          <option value="0" <?php if ($assetType->depreciationSchedule == 0) { echo "selected='selected'";} ?>>Select Schedule</option>
          <option value="1" <?php if ($assetType->depreciationSchedule == 1) { echo "selected='selected'";} ?>>1 Year</option>
          <option value="2" <?php if ($assetType->depreciationSchedule == 2) { echo "selected='selected'";} ?>>2 Year</option>
          <option value="3" <?php if ($assetType->depreciationSchedule == 3) { echo "selected='selected'";} ?>>3 Year</option>
          <option value="4" <?php if ($assetType->depreciationSchedule == 4) { echo "selected='selected'";} ?>>4 Year</option>
          <option value="5" <?php if ($assetType->depreciationSchedule == 5) { echo "selected='selected'";} ?>>5 Year</option>
          <option value="6" <?php if ($assetType->depreciationSchedule == 6) { echo "selected='selected'";} ?>>6 Year</option>
          <option value="7" <?php if ($assetType->depreciationSchedule == 7) { echo "selected='selected'";} ?>>7 Year</option>
          <option value="8" <?php if ($assetType->depreciationSchedule == 8) { echo "selected='selected'";} ?>>8 Year</option>
          <option value="9" <?php if ($assetType->depreciationSchedule == 9) { echo "selected='selected'";} ?>>9 Year</option>
          <option value="10" <?php if ($assetType->depreciationSchedule == 10) { echo "selected='selected'";} ?>>10 Year</option>

        </select>
      </td>
    </tr>
    <?php
    if ($assetType->depreciationSchedule)
    {
     ?>
    <tr>
      <td>
        &nbsp;
      </td>
      <td>
        <a href="/editDeprectionSchedule/<?php echo $assetType->assetTypeId;?>/">Edit Deprecition Schedule</a>
      </td>
    </tr>
    <?php
     }
     ?>
	  <tr>
      <td>&nbsp;
      <?php
      CreateHiddenField("cnt",$cnt);
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
