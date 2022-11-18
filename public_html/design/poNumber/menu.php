<?php
$poNumberClass = "menu-item menu-item-type-custom menu-item-object-custom";
$attachmentClass = "menu-item menu-item-type-custom menu-item-object-custom";
$assetClass = "menu-item menu-item-type-custom menu-item-object-custom";
$insuranceClass = "menu-item menu-item-type-custom menu-item-object-custom";
$historyClass = "menu-item menu-item-type-custom menu-item-object-custom";
if ($request_uri[1] == "poNumberEdit")
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
include_once "tracker/attachment.php";
include_once "tracker/asset.php";
$asset = new Asset();
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
	                  if ($permission->hasPermission("poNumber: View History"))
	                  {
	                  	?>
	                  <li id="menu-item-20" class="<?php echo $historyClass;?>"><a href='/poNumberHistory/<?php echo $poNumberId;?>/' title='History'><span>History</span></a></li>
	                  <?php
	                  }
	                  ?>
	                </ul>
