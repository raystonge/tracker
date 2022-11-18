<?php
/*
 * Created on Jan 11, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
PageAccess("Asset: View Attachments");
include_once "tracker/assetType.php";
include_once "tracker/building.php";
?>
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
     include $sitePath."/design/asset/asset.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>