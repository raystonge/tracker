<div class="adminArea">
<!--
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a> -> New Asset</h2>
-->	
<?php
$assetId = 0;
if (isset($request_uri[2]))
{
	$assetId = $request_uri[2];
}
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
$asset = new Asset($assetId);
$label = "";
if (strlen($asset->name))
{
	$label = $asset->name;
}
else
{
	$label = $asset->serialNumber;
}
echo $label." - ";
?>
<a href="/process/asset/createTicket.php?assetId=<?php echo $asset->assetId;?>">Create Ticket for Asset</a>
<div id='main_column'>

	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	                <ul id="menu-main" class="nav">
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-20 active">
	                    <a href='/editTicket/<?php echo $assetId;?>/' title='Ticket'><span>Asset</span></a>
	                  </li>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/ticketsAsset/<?php echo $assetId;?>/' title='Tickets'><span>Tickets</span></a></li>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/attachmentAsset/<?php echo $assetId;?>/' title='Attachments'><span>Attachments</span></a></li>
	                  <?php
	                  $assetType = new AssetType($asset->assetTypeId);
	                  if ($assetType->monitor)
	                  {
	                  	?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/monitorAsset/<?php echo $assetId;?>/' title='Monitor'><span>Monitor</span></a></li>
	                  <?php
	                  }
	                  ?>
	                  <li id="menu-item-20" class="menu-item menu-item-type-custom menu-item-object-custom"><a href='/historyAsset/<?php echo $assetId;?>/' title='History'><span>History</span></a></li>
	                </ul>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>	          
 
<div class="clear"></div>

	<div id='tab-editor'>
     <?php
     include $sitePath."/design/asset/editor.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>
</div>