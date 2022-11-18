<div class="adminArea">
<!--
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a> -> New Asset</h2>
-->	
<?php
include_once "tracker/asset.php";
include_once "tracker/assetToAsset.php";
$assetToAssetId = GetURI(2,0);
$assetToAsset = new AssetToAsset($assetToAssetId);
$asset = new Asset($assetToAsset->assetId1);
$assetId= $asset->assetId;
$asset1 = new Asset($assetToAsset->assetId1);
$asset2 = new Asset($assetToAsset->assetId2);
include $sitePath."/design/asset/assetInfoHeader.php";
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
     	include $sitePath."/design/asset/assignSerialNumber.php";	
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>
</div>