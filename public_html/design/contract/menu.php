<?php
$contractClass = "menu-item menu-item-type-custom menu-item-object-custom";
$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom";
$assetClass = "menu-item menu-item-type-custom menu-item-object-custom";
$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom";
$historyClass = "menu-item menu-item-type-custom menu-item-object-custom";
if ($request_uri[1] == "contractEdit")
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
	                  if ($permission->hasPermission("Contract: View History"))
	                  {
	                  	?>
	                    <li id="menu-item-20" class="<?php echo $historyClass;?>"><a href='/contractHistory/<?php echo $contractId;?>/' title='History'><span>History</span></a></li>
	                    <?php
	                  }
	                  ?>
	                </ul>
