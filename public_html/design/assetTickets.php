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
$assetType = new AssetType($asset->assetTypeId);
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
<?php
if (FormErrors())
{

		DisplayFormErrors();
}
if (FormSuccess())
{
	DisplayFormSuccess();
}
?>
<?php
if ($asset->assetConditionId != 8)
{
 ?>
<form method="post" action="/process/asset/addTicket.php">
	<table>
		<tr>
			<td>
				Add Ticket :
			</td>
			<td>
				<?php CreateTextField("ticketId");
				?>
			</td>
		</tr>
	</table>
	<?php
	CreateHiddenField("assetId",$assetId);
	PrintFormKey();
	CreateSubmit();
	 ?>
</form>
<?php
}
 ?>
	<div id='tab-editor'>
     <?php
     include $sitePath."/design/asset/tickets.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>
