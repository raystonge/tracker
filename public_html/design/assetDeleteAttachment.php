<?php
/*
 * Created on Jan 23, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<div class="adminArea">
<?php
include_once "tracker/attachment.php";
include_once "tracker/asset.php";

$attachmentId = 0;
if (isset($request_uri[2]))
{
	$attachmentId = $request_uri[2];
}
$attachment = new Attachment($attachmentId);
$asset = new Asset($attachment->assetId);
$assetId = $asset->assetId;
$url = "/assetAttachment/".$asset->assetId."/";
include_once "tracker/assetType.php";
$assetType = new AssetType($asset->assetTypeId);
include $sitePath."/design/asset/assetInfoHeader.php";
?>
<a href="/process/asset/createTicket.php?assetId=<?php echo $asset->assetId;?>">Create Ticket for Asset</a>

<div id='main_column'>
	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/asset/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>	          
 
<div class="clear"></div>

	<div id='tab-editor'>
	<?php
	include $sitePath."/design/common/attachmentDelete.php";
	?>
	</div>
</div>