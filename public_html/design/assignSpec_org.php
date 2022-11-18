<div class="adminArea">
<!--
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a> -> New Asset</h2>
-->
<?php
include_once "tracker/spec.php";
include_once "tracker/assetType.php";
include_once "tracker/specToAssetType.php";

$assetTypeId = 0;
if (isset($request_uri[2]))
{
	$assetTypeId = $request_uri[2];
}
$assetType = new AssetType($assetTypeId);
?>
<form method="post" autocomplete="<?php echo $autoComplete;?>" action="/process/assetType.php">
	<?php CreateHiddenField("assetTypeId",$assetTypeId);?>
	<table width="600px">
	 <tr>
		 <th>
		 Available Modules
		 </th>
		 <th>
		 My Modules
		 </th>
	 </tr>
	 <tr>
		 <td>
			 <div class='pane' id='availableModules'>


       </div>
		 </td>
		 <td>
			 <div class='pane' id='myModules'>

		 </div>
		 </td>
	 </tr>
 </table>
</form>
</div>
