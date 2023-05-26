<?php
//
//  Tracker - Version 1.9.0
//
//  -v1.9.0
//   - fixed issue where number of tickets on PO were not showing
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
$poNumberClass = "menu-item menu-item-type-custom menu-item-object-custom";
$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom";
$assetClass = "menu-item menu-item-type-custom menu-item-object-custom";
$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom";
$ticketClass = "menu-item menu-item-type-custom menu-item-object-custom";
$historyClass = "menu-item menu-item-type-custom menu-item-object-custom";
if ($request_uri[1] == "poNumberEdit" || $request_uri[1] == "poNumberView")
{
	$poNumberClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "poNumberAssets")
{
	$assetClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "poNumberAttachment")
{
	$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "poNumberHistory")
{
	$historyClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "poNumberInsurance")
{
	$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "poNumberTickets")
{
	$ticketClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}

include_once "tracker/attachment.php";
include_once "tracker/asset.php";
include_once "tracker/ticket.php";
include_once "tracker/ticketPO.php";
$asset = new Asset();
$ticket = new Ticket();
$ticketPO = new TicketPO();
$attachment = new Attachment();
$param = "poNumberId=".$poNumber->poNumberId;
?>
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-20" class="<?php echo $poNumberClass;?>">
	                    <?php
	                    if ($permission->hasPermission("poNumber: Edit"))
	                    {
	                    	?>
	                    	<a href='/poNumberEdit/<?php echo $poNumberId;?>/' title='poNumber'><span>PO Number</span></a>
	                    	<?php
	                    }
	                    else
	                    {
	                    	if ($permission->hasPermission("poNumber: View"))
	                    	{
	                    		?>
	                    		<a href='/poNumberView/<?php echo $poNumberId;?>/' title='poNumber'><span>PO Number</span></a>
	                    		<?php
	                    	}
	                    	else
	                    	{
	                    		?>
	                    		<span>PO Number</span>
	                    		<?php
	                    	}
	                    }
	                    ?>
	                  </li>
	                  <?php
	                  if ($permission->hasPermission("poNumber: View Attachments"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $attachmentClass;?>"><a href='/poNumberAttachment/<?php echo $poNumberId;?>/' title='Attachments'><span>Attachments<?php if ($attachment->Count($param)){ echo " ($attachment->numRows)";}?></span></a></li>
	                  <?php
	                  }
	                  ?>
	                  <?php
	                  if ($permission->hasPermission("Asset: View"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $assetClass;?>"><a href='/poNumberAssets/<?php echo $poNumberId;?>/' title='Assets'><span>Assets<?php if ($asset->Count($param)){ echo " ($asset->numRows)";}?></span></a></li>
	                  <?php
	                  }
	                  ?>
										<?php
	                  if ($permission->hasPermission("Ticket: View"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $ticketClass;?>"><a href='/poNumberTickets/<?php echo $poNumberId;?>/' title='Tickets'><span>Tickets<?php if ($ticketPO->Count($param)){ echo " ($ticketPO->numRows)";}?></span></a></li>
	                  <?php
	                  }
	                  ?>
	                  <?php
	                  if ($permission->hasPermission("poNumber: View History"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $historyClass;?>"><a href='/poNumberHistory/<?php echo $poNumberId;?>/' title='History'><span>History</span></a></li>
	                  <?php
	                  }
	                  ?>
	                </ul>
