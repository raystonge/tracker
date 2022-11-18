<?php

include_once "globals.php";
include_once "tracker/user.php";
include_once "tracker/defaultUser.php";
include_once "tracker/queue.php";
include_once "tracker/organization.php";
include_once "tracker/set.php";
$editingUserGroup = 0;
$errorMsg = "";
$numErrors = 0;
$cnt = 0;

?>
<div class="adminArea">
	<h2><a href="/config/" class="breadCrumb">Configuration</a> -> <a href="/listBuildings/">Buildings</a></h2>
    <?php
    if (FormErrors())
    {
   		$building->name = GetTextFromSession("buildingName");
   		$building->queueId = GetTextFromSession("buildingQueueId",0);
   		$building->domain = GetTextFromSession("buildingDomain");
   		$building->organizationId = GetTextFromSession("buildingOrganizationId");
   		DisplayFormErrors();
    }
    ?>

<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/building.php">
  <table class="width100">
    <tr>
      <td>Building:
      </td>
      <td>
       <input type="text" name="name" class="ui-corner-left ui-corner-right" value="<?php echo $building->name;?>"/>
      </td>
      <td>
    </tr>
    <tr>
      <td>Network Name:
      </td>
      <td>
       <input type="text" name="network" class="ui-corner-left ui-corner-right" value="<?php echo $building->domain;?>"/>
      </td>
      <td>
    </tr>
    <tr>
      <td><?php echo $orgOrDept;?> :
      </td>
      <td><select name="organizationId" id="organizationId">
            <option value="0">Select Default <?php echo $orgOrDept;?></option>
			<?php
			$param = "";
			$organization = new Organization();
			$ok = $organization->Get("");
            while ($ok)
            {
            	$selected="";
            	if ($building->organizationId ==$organization->organizationId)
            	{
            		$selected="selected='selected'";
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
      <td>
      Default Queue:
      </td>
      <td>
				<div id="queueResults"></div>
				<!--

 				<select name="queueId" id="queueId">
            <option value="0">Select Default Queue</option>
			<?php

			$param = "";
			if ($building->queueId)
			{
				$param = "buildingId <>".$building->buildingId;
			}
			$queues = new Set(",");
			$buildings = new Building();
			$ok = $buildings->Get($param);
			while ($ok)
			{
				$queues->Add($buildings->queueId);
				$ok = $buildings->Next();
			}
			$param = "";
			if ($queues->hasItems())
			{
				$param = "queueId not in ($queue->data)";
			}
			$queue = new Queue();
			$ok = $queue->Get("");
            while ($ok)
            {
            	$selected="";
            	if ($building->queueId ==$queue->queueId)
            	{
            		$selected="selected='selected'";
            	}
            	?>
            	<option value="<?php echo $queue->queueId;?>" <?php echo $selected;?>><?php echo $queue->name;?></option>
            	<?php
            	$ok = $queue->Next();
            }
            ?>
            </select>
					-->
      </td>
    </tr>
    <tr>
      <td>&nbsp;
      <input type="hidden" value="<?php echo $cnt;?>" name="cnt">
      <input type="hidden" value="1" name="submitTest">
      <input type="hidden" name="buildingId" value="<?php echo $building->buildingId;?>"/>
      <input type="hidden" name="ajaxFormKey" value="<?php echo getAJAXFormKey();?>" />
      </td>
      <td>
        <input type="submit" name="submit" value="<?php echo $button;?>"/>
      </td>
    </tr>
  </table>
</form>
</div>
