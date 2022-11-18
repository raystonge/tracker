<?php
$ticketClass = "menu-item menu-item-type-custom menu-item-object-custom";
$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom";
$assetClass = "menu-item menu-item-type-custom menu-item-object-custom";
$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom";
$historyClass = "menu-item menu-item-type-custom menu-item-object-custom";
$scheduleClass = "menu-item menu-item-type-custom menu-item-object-custom";

if ($request_uri[1] == "ticketEdit")
{
	$ticketClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "ticketAssets")
{
	$assetClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "ticketAttachment")
{
	$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "ticketHistory")
{
	$historyClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "ticketInsurance")
{
	$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
if ($request_uri[1] == "ticketSchedule")
{
	$scheduleClass = "menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active";
}
include_once "tracker/attachment.php";
include_once "tracker/assetToTicket.php";
$assetToTicket = new AssetToTicket();
$attachment = new Attachment();
$param = "ticketId=".$ticket->ticketId;

?>
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-20" class="<?php echo $ticketClass;?>">
	                    <a href='/ticketEdit/<?php echo $ticketId;?>/' title='Ticket'><span>Ticket</span></a>
	                  </li>
	                  <?php
	                  if ($permission->hasPermission("Ticket: View Assets"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $assetClass;?>"><a href='/ticketAssets/<?php echo $ticketId;?>/' title='Assets'><span>Assets<?php if ($assetToTicket->Count($param)){ echo " ($assetToTicket->numRows)";}?></span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Ticket: View Attachments"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $attachmentClass;?>"><a href='/ticketAttachment/<?php echo $ticketId;?>/' title='Attachments'><span>Attachments<?php if ($attachment->Count($param)){ echo " ($attachment->numRows)";}?></span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Ticket: View Warranty") && $useInsurance)
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $insuranceClass;?>"><a href='/ticketInsurance/<?php echo $ticketId;?>/' title='Warranty'><span>Warranty</span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Ticket: Schedule"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $scheduleClass;?>"><a href='/ticketSchedule/<?php echo $ticketId;?>/' title='Time Worked'><span>Time Worked</span></a></li>
	                  <?php
	                  }
	                  if ($permission->hasPermission("Ticket: View History"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $historyClass;?>"><a href='/ticketHistory/<?php echo $ticketId;?>/' title='History'><span>History</span></a></li>
	                  <?php
	                  }
	                  ?>
	                </ul>
