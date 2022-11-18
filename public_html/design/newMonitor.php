<?php
PageAccess("Asset: Monitor");
include_once "tracker/assetType.php";
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

$monitorId = 0;
if (isset($request_uri[3]))
{
    $monitorId = $request_uri[3];
}
include_once "tracker/asset.php";
include_once "tracker/assetType.php";
$asset = new Asset($assetId);
$assetType = new AssetType($asset->assetTypeId);
include $sitePath."/design/asset/assetInfoHeader.php";
?>
<script language="javascript" src="/ajax/assetMonitor.js"></script>
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
<form action="/monitorNew/" method="post">
  Name:
  <?php
   CreateTextField("name","",0,"Monitor Name");
   ?>
   <br> Monitor Type:
   <select id="monitorType" name="monitorType">
     <option value="ping">Ping</option>
     <option value="URL">URL</option>
   </select>
        	<br>
        	<br>
	<?php
	               PrintFormKey();
	               CreateHiddenField("assetId",$assetId);
               CreateHiddenField("submitTest",1);
               CreateSubmit("Continue","Continue");
	?>
</form>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>