<?php
//
//  Tracker - Version 1.5.0
//
//  v1.5.0
//   - set nav for contracts
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
include_once "tracker/monitor.php";
include_once "tracker/assetType.php";
$assetType = new AssetType($asset->assetTypeId);
$assetClass = "menu-item menu-item-type-custom menu-item-object-custom";
$ticketClass = "menu-item menu-item-type-custom menu-item-object-custom";
$monitorClass = "menu-item menu-item-type-custom menu-item-object-custom";
$historyClass = "menu-item menu-item-type-custom menu-item-object-custom";
$contractClass = "menu-item menu-item-type-custom menu-item-object-custom";
$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom";
$softwareClass = "menu-item menu-item-type-custom menu-item-object-custom";
$accessoryClass = "menu-item menu-item-type-custom menu-item-object-custom";
$valueClass = "menu-item menu-item-type-custom menu-item-object-custom";
$accountClass = "menu-item menu-item-type-custom menu-item-object-custom";
$specClass = "menu-item menu-item-type-custom menu-item-object-custom";
$credentialsClass = "menu-item menu-item-type-custom menu-item-object-custom";
if ($request_uri[1] == "assetEdit")
{
	$assetClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetCredentials" || $request_uri[1] == "editUserCredentials" || $request_uri[1] == "newUserCredentials")
{
    $credentialsClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetTickets")
{
	$ticketClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetContract")
{
	$contractClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetSpecs")
{
	$specClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetAttachment" || $request_uri[1] == "assetDeleteAttachment")
{
	$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetHistory")
{
	$historyClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetMonitor" || $request_uri[1] == "assetMonitorList" || $request_uri[1] == "newMonitor")
{
	$monitorClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetValue")
{
	$valueClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}

if ($request_uri[1] == "accessory")
{
	$accessoryClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "assetAccount")
{
	$accountClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}

if ($request_uri[1] == "assetSoftwareDevice" || $request_uri[1] == "assetAssignSerialNumber")
{
	$softwareClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
include_once "tracker/attachment.php";
include_once "tracker/assetToTicket.php";
include_once "tracker/ticket.php";
include_once "tracker/specToAssetType.php";
include_once "tracker/assetToAsset.php";
include_once "tracker/contract.php";
$specToAssetType = new SpecToAssetType();
$param = AddEscapedParam("","assetTypeId",$asset->assetTypeId);
$specToAssetType->Get($param);
$assetToTicket = new AssetToTicket();
$attachment = new Attachment();
$param = "assetId=".$asset->assetId;

$count = 0;
$ok = $assetToTicket->Get($param);
while ($ok)
{
	$ticket = new Ticket($assetToTicket->ticketId);
	if ($ticket->statusId != 4)
	{
		$count++;
	}
	$ok = $assetToTicket->Next();
}
DebugText("Doing asset SubMenu");

?>
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-20" class="<?php echo $assetClass;?>">
	                    <a href='/assetEdit/<?php echo $assetId;?>/' title='Asset'><span>Asset</span></a>
	                  </li>
	                  <?php
	                  if ($permission->hasPermission("Asset: View Tickets") || $permission->hasPermission("Asset: Edit Tickets"))
	                  {
	                  	?>
	                    <li id="menu-item-20" class="<?php echo $ticketClass;?>"><a href='/assetTickets/<?php echo $assetId;?>/' title='Tickets'><span>Tickets <?php if ($count){ echo " ($count)";}?></span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Asset: View Attachments") || $permission->hasPermission("Asset: Edit Attachments"))
	                  {
	                  ?>
	                  <li id="menu-item-20" class="<?php echo $attachmentClass;?>"><a href='/assetAttachment/<?php echo $assetId;?>/' title='Attachments'><span>Attachments<?php if ($attachment->Count($param)){ echo " ($attachment->numRows)";}?></span></a></li>
	                  <?php
	                  }

	                  if ($permission->hasPermission("Asset: View Value") || $permission->hasPermission("Asset: Edit Value"))
	                  {
	                  ?>
	                  <li id="menu-item-20" class="<?php echo $valueClass;?>"><a href='/assetValue/<?php echo $assetId;?>/' title='Attachments'><span>Value</span></a></li>
	                  <?php
	                  }
	                  $assetType = new AssetType($asset->assetTypeId);
	                  $param = "assetId = ".$asset->assetId;
	                  $monitor = new Monitor();
	                  $showMonitor = 0;
	                  if ($assetType->monitor && $permission->hasPermission("Asset: Monitor"))
	                  {
	                  	if ($permission->hasPermission("Asset: Edit Monitor"))
	                  	{
	                  		$showMonitor = 1;
	                  	}
	                  	if ($permission->hasPermission("Asset: View Monitor"))
	                  	{
	                  		$showMonitor = 1;
	                  	}
	                  }
	                  if ($assetType->monitor && $showMonitor)
	                  {
						$assetMonitorURL = "assetMonitor";
						$param = AddEscapedParam("","assetId",$asset->assetId);
						if (!$monitor->Get($param))
						{
							$assetMonitorURL = "newMonitor";
						}
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $monitorClass;?>"><a href='/<?php echo $assetMonitorURL;?>/<?php echo $assetId;?>/' title='Monitors'><span>Monitors</span></a></li>
	                  <?php
	                  }
					  $param = AddEscapedParam("isLease=1","poNumberId",$asset->poNumberId);
					  $contract = new Contract();
					  $contract->Get($param);
	                  if ($assetType->hasContract && $permission->hasPermission("Asset: View Contract") && $contract->isLease)
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $contractClass;?>"><a href='/assetContract/<?php echo $assetId;?>/' title='Contract'><span>Contract</span></a></li>
	                  <?php
	                  }
	                  if ($assetType->name == "Software" && $permission->hasPermission("Asset: Software"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $softwareClass;?>"><a href='/assetSoftwareDevice/<?php echo $assetId;?>/' title='Devices with this software'><span>Devices</span></a></li>
	                  <?php
	                  }
	                  DebugText("do accessory test");
										DebugText("isAccessory:".$assetType->isAccessory);
										DebugText("hasAccessory:".$assetType->hasAccessory);
	                  if (($assetType->isAccessory || $assetType->hasAccessory) && ($permission->hasPermission("Asset: Edit Accessory") || $permission->hasPermission("Asset: Edit Accessory")))
	                  {
											$assetToAsset = new AssetToAsset();
											$param = AddEscapedParam("","assetId1",$asset->assetId);
											$param = AddOrEscapedParam($param,"assetId2",$asset->assetId);
											$assetToAsset->Count($param);
	                  ?>
	                  <li id="menu-item-20" class="<?php echo $accessoryClass;?>"><a href='/accessory/<?php echo $assetId;?>/' title='Assign Accessory'><span>Accessory <?php if ($assetToAsset->numRows) { echo "(".$assetToAsset->numRows.")"; } ?></span></a></li>
	                  <?php
	                  }
										DebugText("do spec test");
										DebugText("hasSpecs:".$assetType->hasSpecs);
	                  if (($assetType->hasSpecs) && ($permission->hasPermission("Asset: Edit Spec") || $permission->hasPermission("Asset: View Spec")))
	                  {
	                  ?>
	                  <li id="menu-item-20" class="<?php echo $specClass;?>"><a href='/assetSpecs/<?php echo $assetId;?>/' title='Assign Specs'><span>Specs</span></a></li>
	                  <?php
	                  }
	                  DebugText("do credentials test");
	                  if (($assetType->hasUserPassword) && $permission->hasPermission("Asset: Account Info"))
	                  {
	                  	?>
	                  	  <li id="menu-item-20" class="<?php echo $accountClass;?>"><a href='/assetAccount/<?php echo $assetId;?>/' title='Assign Accessory'><span>Account</span></a></li>
	                  	<?php
	                  }
	                  DebugText("do account test");
	                  if (($assetType->hasUserCredentials) && $permission->hasPermission("Asset: User Credentials"))
	                  {
	                      ?>
	                  	  <li id="menu-item-20" class="<?php echo $credentialsClass;?>"><a href='/assetCredentials/<?php echo $assetId;?>/' title='User Credentials'><span>User Credentials</span></a></li>
	                  	<?php
	                  }


	                  if ($permission->hasPermission("Asset: View History"))
	                  {
	                  ?>

	                  <li id="menu-item-20" class="<?php echo $historyClass;?>"><a href='/assetHistory/<?php echo $assetId;?>/' title='History'><span>History</span></a></li>
	                  <?php
	                  }
	                  ?>
	                </ul>
