<?php
//
//  Tracker - Version 1.5.0
//
//  v1.5.0
//   - set formating for viewContract and contractView
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
include_once "tracker/asset.php";
$contractClass = "menu-item menu-item-type-custom menu-item-object-custom";
$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom";
$assetClass = "menu-item menu-item-type-custom menu-item-object-custom";
$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom";

$historyClass = "menu-item menu-item-type-custom menu-item-object-custom";
if ($request_uri[1] == "contractEdit" || $request_uri[1] == "contractView" || $request_uri[1] == "viewContract")
{
	$contractClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "contractAssets")
{
	$assetClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "contractAttachment")
{
	$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "contractHistory")
{
	$historyClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "contractInsurance")
{
	$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
include_once "tracker/attachment.php";
$attachment = new Attachment();
$param = "contractId=".$contract->contractId;
?>
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-20" class="<?php echo $contractClass;?>">
	                    <?php
	                    if ($permission->hasPermission("Contract: Edit"))
	                    {
	                    	?>
	                    	<a href='/contractEdit/<?php echo $contractId;?>/' title='Contract'><span>Contract</span></a>
	                    	<?php
	                    }
	                    else
	                    {
	                    	if ($permission->hasPermission("Contract: View"))
	                    	{
	                    		?>
	                    		<a href='/viewContract/<?php echo $contractId;?>/' title='Contract'><span>Contract</span></a>
	                    		<?php
	                    	}
	                    	else
	                    	{
	                    		echo $contract->name;
	                    	}
	                    }
	                    ?>
	                  </li>
	                  <?php
	                  if ($permission->hasPermission("Contract: View Attachments"))
	                  {
	                  	?>
	                  	<li id="menu-item-20" class="<?php echo $attachmentClass;?>"><a href='/contractAttachment/<?php echo $contractId;?>/' title='Attachments'><span>Attachments<?php if ($attachment->Count($param)){ echo " ($attachment->numRows)";}?></span></a></li>
	                  	<?php
	                  }
										if ($permission->hasPermission("Contract: View Assets"))
	                  {
											$param = "poNumberId = -1"; // since no asset can have this, if the contract,
											                            // if the contract is not a lease, this will not find assets
											if ($contract->isLease)
											{
												$param = AddEscapedParam("","poNumberId",$contract->poNumberId);
											}
											$asset = new Asset();
	                  	?>
	                  	<li id="menu-item-20" class="<?php echo $assetClass;?>"><a href='/contractAssets/<?php echo $contractId;?>/' title='Assets'><span>Assets<?php if ($asset->Count($param)){ echo " ($asset->numRows)";}?></span></a></li>
	                  	<?php
	                  }


	                  if ($permission->hasPermission("Contract: View History"))
	                  {
	                  	?>
	                    <li id="menu-item-20" class="<?php echo $historyClass;?>"><a href='/contractHistory/<?php echo $contractId;?>/' title='History'><span>History</span></a></li>
	                    <?php
	                  }
	                  ?>
	                </ul>
