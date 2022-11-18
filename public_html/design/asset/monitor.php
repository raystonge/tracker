<?php
/*
 * Created on Mar 19, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/monitor.php";
include_once "tracker/building.php";
include_once "tracker/monitorToUser.php";
include_once "tracker/assetType.php";
$button = "Create";
$param = "assetId = ".$asset->assetId;
$assetType = new AssetType($asset->assetTypeId);
$monitor = new Monitor($monitorId);

if ($monitor->monitorId)
{
	$button = "Update";
}
else 
{
    $monitor->name = GetTextField("name");
    $monitor->monitorType = GetTextField("monitorType");
}
DebugText("monitorType:".$monitor->monitorType);
$building = new Building($asset->buildingId);
    if (FormErrors())
    {
        $monitor->name = GetTextFromSession("assetMonitorName");
    	$monitor->fqdn = GetTextFromSession("assetMonitorFQDN");
    	$monitor->ipAddress = GetTextFromSession("assetMonitorIPAddress");
    	$monitor->monitorURL = GetTextFromSession("assetMonitorMonitorURL");
    	$monitor->pingAddress = GetTextFromSession("asssetMonitorPingAddress");
    	$monitor->smsNotice = GetTextField("assetSMSNotice",0);
    	$monitor->whine = GetTextField("assetWhine",0);
    	$monitor->monitorType = GetTextField("assetMonitorType");
    	DisplayFormErrors();
    }
    if (FormSuccess())
    {
    	DisplayFormSuccess();
    }
    ?>
<table>
  <tr>
    <td>
    Building: <?php echo $building->name;?>
    </td>
    <td>Location: <?php echo $asset->buildingLocation;?>
    </td>
    <td><div id="assetState"></div>
    </td>
  </tr>
<?php

if (!strlen($monitor->fqdn))
{
  $monitor->fqdn = $asset->name.".".$building->domain;
}
?>
</table>
<form method="post" action="/process/asset/monitor.php">
<table>
  <tr>
    <td colspan="2">
        <?php
    if ($permission->hasPermission("Asset: Edit: Name"))
    {
    	?>
      Name: <?php CreateTextField("name",$monitor->name);?>
      <?php
    }
    else
    {
    	if ($permission->hasPermission("Asset: View: Name"))
    	{
    		echo "Name: ".$monitor->name;
    	}
    }
    ?>
    </td>
  </tr>
    <tr>
    <td  colspan="2">
        <?php
        CreateHiddenField("monitorType",$monitor->monitorType);
    if ($permission->hasPermission("Asset: Edit: Monitor Type") || $permission->hasPermission("Asset: View: Monitor Type"))
    {
    	echo "Type:".$monitor->monitorType;
    }
    ?>
    </td>
  </tr>
  <tr>
    <td colspan="2">
    <?php
    if ($permission->hasPermission("Asset: Edit: FQDN"))
    {
    	?>
      FQDN: <?php CreateTextField("fqdn",$monitor->fqdn);?>
      <?php
    }
    else
    {
    	if ($permission->hasPermission("Asset: View: FQDN"))
    	{
    		echo "FQDN: ".$monitor->fqdn;
    	}
    }
    ?>
    </td>
   </tr>
   <tr>
    <td  colspan="2">
      <?php
      DebugText("monitorType:".$assetType->monitorType);
      if ($permission->hasPermission("Asset: Edit: IP Address") && $monitor->monitorType == "ping")
      {
      	?>
      IP Address: <?php CreateTextField("ipAddress",$monitor->ipAddress);?>
      <?php
      }
      else
      {
          if ($permission->hasPermission("Asset: View: IP Address") && $monitor->monitorType == "ping")
      	{
      		echo "IP Address: ".$monitor->ipAddress;
      	}
      }
      ?>
    </td>
  </tr>
  <?php
  if ($permission->hasPermission("Asset: Edit: Monitor URL") && $monitor->monitorType == "URL")
  {
  	?>
  	<tr>
  	  <td colspan="2">
  	  Monitor URL: <?php CreateTextField("monitorURL",$monitor->monitorURL);?>
  	  </td>
  	</tr>
  	<?php
  }
  else
  {
      if ($permission->hasPermission("Asset: View: Monitor URL") && $monitor->monitorType == "URL")
  	{
  		?>
  	<tr>
  	  <td colspan="2">
  	  Monitor URL: <?php echo $monitor->monitorURL;?>
  	  </td>
  	</tr>
  		<?php
  	}
  }
  ?>
  <?php
  if ($permission->hasPermission("Asset: Edit: Ping Address") && $monitor->monitorType == "pingAddress")
  {
  	?>
  	<tr>
  	  <td colspan="2">
  	  Ping Address: <?php CreateTextField("pingAddress",$monitor->pingAddress);?>
  	  </td>
  	</tr>
  	<?php
  }
  else
  {
      if ($permission->hasPermission("Asset: View: Ping Address") && $monitor->monitorType == "pingAddress")
  	{
  		?>
  	<tr>
  	  <td colspan="2">
  	  Ping Address : <?php echo $monitor->pingAddress;?>
  	  </td>
  	</tr>
  		<?php
  	}
  }
  ?>
  <tr>
    <td valign="top">
    <?php if ($permission->hasPermission("Asset: Edit: Notify"))
    {
    	?>
    Notify:
      <select name="notify[]" ]size="5" id="notify" multiple="multiple">
        <?php
        $user = new User();
        $monitorToUser = new MonitorToUser();
        $ok = $user->Get("active=1");
        while ($ok)
        {
        	$selected = "";
        	$param = AddParam("","monitorId=".$monitor->monitorId);
        	$param = AddParam($param,"userId=".$user->userId);
        	if ($monitorToUser->Get($param))
        	{
        		$selected = "selected='selected'";
        	}
        	?>
        	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $user->fullName;?></option>
        	<?php
        	$ok = $user->Next();
        }
        ?>
      </select>
      <?php
    }
    else
    {
    	if ($permission->hasPermission("Asset: View: Notify"))
    	{
    		echo "Notify: ";
    		$user = new User();
    		$monitorToUser = new MonitorToUser();
    		$ok = $user->Get("active=1");
    		while ($ok)
    		{
    			$selected = "";
    			$param = AddParam("","monitorId=".$monitor->monitorId);
    			$param = AddParam($param,"userId=".$user->userId);
    			if ($monitorToUser->Get($param))
    			{
    				echo $user->fullName."<BR>";
    			}
    			$ok = $user->Next();
    		}
    	}
    }
    ?>
    </td>
    <td valign="middle">
     <?php
     if ($permission->hasPermission("Asset: Edit: Monitor Active"))
     {
     	$checked = "";
     	if ($monitor->active)
     	{
     		$checked = "checked='checked'";
     	}
     	CreateCheckBox("active",1,"Active",$monitor->active);
     	PrintBR();
     }
     else
     {
     	if ($permission->hasPermission("Asset: View: Monitor Active"))
     	{
     		if ($monitor->active)
     		{
     			echo "Active: Yes";
     		}
     		else
     		{
     			echo "Active: No";
     		}
     		PrintBR();
     	}
     }
     ?>
     <?php
     if ($permission->hasPermission("Asset: Edit: Monitor SMS Notify"))
     {
     	$checked = "";
     	if ($monitor->smsNotice)
     	{
     		$checked = "checked='checked'";
     	}
     	CreateCheckBox("smsNotify",1,"SMS Notifiy",$monitor->smsNotice);
     }
     else
     {
     	if ($permission->hasPermission("Asset: View: Monitor SMS Notify"))
     	{
     		if ($monitor->smsNotice)
     		{
     			echo "SMS Notify: Yes";
     		}
     		else
     		{
     			echo "SMS Notify: No";
     		}
     	}
     }
     ?>

    </td>
  </tr>

   <tr>
    <td colspan="2">
    <?php
    if ($permission->hasPermission("Asset: Edit: Whine"))
    {
        CreateCheckBox("whine",1,"Whine",$monitor->whine,"Whine");

    	?>

      <?php
    }
    else
    {
    	if ($permission->hasPermission("Asset: View: Whine"))
    	{
    		echo "Whine: ".$monitor->whine;
    	}
    }
    ?>
    </td>
   </tr>
   <tr>
    <td>
    &nbsp;
    </td>
    <td>
     <input type="hidden" name="assetId" value="<?php echo $asset->assetId;?>"/>
     <input type="hidden" name="monitorId" value="<?php echo $monitor->monitorId;?>"/>
     <input type="hidden" name="formKey" value="<?php echo getFormKey();?>"/>
     <input type="hidden" name="ajaxFormKey" value="<?php echo getAJAXFormKey();?>"/>
     <?php
     if ($permission->hasPermission("Asset: Edit: FQDN") ||
         $permission->hasPermission("Asset: Edit: IP Address") ||
         $permission->hasPermission("Asset: Edit: Notify") ||
         $permission->hasPermission("Asset: Edit: Monitor Active")
     )
     {
     	?>
     <input type="submit" name="submit" value="<?php echo $button;?>"/>
     <?php
     }
     ?>
    </td>
  </tr>
</table>
</form>
