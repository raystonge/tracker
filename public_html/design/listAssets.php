<?php
include_once "tracker/assetType.php";
include_once "tracker/assetCondition.php";
include_once "tracker/user.php";
include_once "tracker/permission.php";
include_once "tracker/building.php";
include_once "tracker/poNumber.php";
include_once "tracker/organization.php";
PageAccess("Asset: List");
$permission = new Permission();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
$page = 1;
DebugText("Compute page we are on");
if (isset($request_uri[1]))
{
	DebugText("first:".$request_uri[1]);
  if (strlen($request_uri[1]))
  {
  	if (is_numeric($request_uri[1]))
    {
    	$page = $request_uri[1];
    	DebugText("uri1:".$request_uri[1]);
    }
  }
}

if (isset($request_uri[2]))
{
  if (strlen($request_uri[2]))
  {
  	$page = $request_uri[2];
  	DebugText("uri2:".$request_uri[2]);
  }
}
if (!is_numeric($page))
{
	DebugText("page:".$page);
	DebugText("default page used");
  $page = 1;
}
?>


<div class="adminArea">
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a></h2>
	<?php
	if ($permission->hasPermission("Asset: Create"))
    {
	?>
	<!--
	<div class="options">
		<a id="newTicket" href="/assetNew/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new Asset"';}?>>New Asset</a>
	</div>
	-->
	<?php
    }
    $searchAssetTypeId = GetTextFromSession("searchAssetType",0);
    $searchConditionId = GetTextFromSession("searchConditionId",0);
    $searchSerialNumber = GetTextFromSession("searchSerialNumber");
    $searchMacAddress = GetTextFromSession("searchMacAddress");
    $searchAssetTag = GetTextFromSession("searchAssetTag");
    $searchBuildingId = GetTextFromSession("searchBuildingId",0);
    $searchName = GetTextFromSession("searchName");
    $searchEmployeeName = GetTextFromSession("searchEmployeeName");
    $searchpoNumberId = GetTextFromSession("searchpoNumberId");
    $searchOrganizationId = GetTextFromSession("searchOrganizationId",0);
    $searchMake = GetTextFromSession("searchMake");

    $searchAssetTypeId = GetTextField("searchAssetType",$searchAssetTypeId);
    $searchConditionId = GetTextField("searchConditionId",$searchConditionId);
    $searchSerialNumber = GetTextField("searchSerialNumber",$searchSerialNumber);
    $searchMacAddress = GetTextField("searchMacAddress",$searchMacAddress);
    $searchAssetTag = GetTextField("searchAssetTag",$searchAssetTag);
    $searchBuildingId = GetTextField("searchBuildingId",$searchBuildingId);
    $searchName = GetTextField("searchName",$searchName);
    $searchEmployeeName = GetTextField("searchEmployeeName",$searchEmployeeName);
    $searchpoNumberId = GetTextField("searchpoNumberId",$searchpoNumberId);
    $searchOrganizationId = GetTextField("searchOrganizationId",$searchOrganizationId);
    $searchMake = GetTextField("searchMake".$searchMake);

    $numPerPage = GetTextFromSession("searchNumPerPage",$maxAssetsPerPage);
    $numPerPage = GetTextField("searchNumPerPage",$maxAssetsPerPage);

	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
		<table>
		    <tr>
		      <td>
		      <?php echo $orgOrDept;?>:
		      </td>
		      <td>
		        <?php CreateHiddenField("hideLabel",1);?>
		        <select id="searchOrganizationId" name="searchOrganizationId">
		          <option value="0">All <?php echo $orgOrDept;?></option>
		          <?php
		          $param = "organizationId in (".GetMyOrganizations().") and active=1";
		          $organization= new Organization();
		          $ok = $organization->Get($param);
		          while ($ok)
		          {
		          	$selected = "";
		          	if ($searchOrganizationId == $organization->organizationId)
		          	{
		          		$selected = "selected='selected'";
		          	}
		          	?>
		          	<option value="<?php echo $organization->organizationId;?>" <?php echo $selected;?>><?php echo $organization->name;?></option>
		          	<?php
		          	$ok = $organization->Next();
		          }
		          ?>
		        </select>
		      </td>
		      <td>
		      &nbsp;
		      </td>
		      <td>
		      &nbsp;
		      </td>
		      <td>
		      &nbsp;
		      </td>
		      <td>
		      &nbsp;
		      </td>
		    </tr>
			<tr>
				<td valign="top">Asset Type:
				</td>
				<td>
				<div id="assetTypeResults"></div>
				<!--

				  <select name="searchAssetType" id="searchAssetType">
				    <option value="0">All</option>
				    <?php
				    $assetType = new AssetType();
		            $param = "organizationId in (".GetMyOrganizations().")";
				    $ok = $assetType->Get($param);
				    while ($ok)
				    {
				    	$selected = "";
				    	if ($assetType->assetTypeId==$searchAssetTypeId)
				    	{
				    		$selected = "selected='selected'";
				    	}
				    	?>
				    	<option value="<?php echo $assetType->assetTypeId;?>" <?php echo $selected;?>><?php echo $assetType->name;?></option>
				    	<?php
				    	$ok = $assetType->Next();

				    }
				    ?>
				  </select>
				  -->
				</td>
				<td>
				Condition:
				</td>
				<td>
				  <select name="searchConditionId" id="searchConditionId">
				   <option value="0">All</option>
				    <?php
				    $assetCondition = new AssetCondition();
				    $ok = $assetCondition->Get("");
				    while ($ok)
				    {
				    	$selected = "";
				    	if ($assetCondition->assetConditionId==$searchConditionId)
				    	{
				    		$selected = "selected='selected'";
				    	}
				    	?>
				    	<option value="<?php echo $assetCondition->assetConditionId;?>" <?php echo $selected;?>><?php echo $assetCondition->name;?></option>
				    	<?php
				    	$ok = $assetCondition->Next();

				    }
				    ?>

				</select>
				</td>
				<td>
				&nbsp;
				</td>
				<td>
				&nbsp;
				</td>

			</tr>
			<tr>
			  <td>Serial Number:
			  </td>
			  <td>
			    <input type="text" name="searchSerialNumber" id="searchSerialNumber" value="<?php echo $searchSerialNumber;?>" />
			  </td>
			  <td>Mac Address:
			  </td>
			  <td>
			    <input type="text" name="searchMacAddress" id="searchMacAddress" value="<?php echo $searchMacAddress;?>" />
			  </td>
				<td>
				Make:
				</td>
				<td>
				<?php CreateTextField("searchMake",$searchMake,0,"Asset Make");?>
				</td>
			</tr>
			<tr>
			  <td>Asset Tag:
			  </td>
			  <td>
			    <input type="text" name="searchAssetTag" id="searchAssetTag" value="<?php echo $searchAssetTag;?>" />
			  </td>
			  <td>Building :
			  </td>
			  <td>
			  <div id="buildingResults"></div>
			  </td>
				<td>
				PO Number:
				</td>
				<td>
				<div id="poNumberResults"></div>
				</td>
			</tr>
			<tr>
			  <td>
			  Name:
			  </td>
			  <td><input type="text" name="searchName" value="<?php echo $searchName;?>"/>
			  </td>
				<td>
				Employee Name
				</td>
				<td>
				<?php
				CreateTextField("searchEmployeeName",$searchEmployeeName,getFieldSize("users","fullName"));
				?>
				</td>
			  <td>Items to Display:</td>
			  <td>
			    <select name="searchNumPerPage">
			      <option value="25" <?php if ($numPerPage == 25) { echo "selected='selected'";}?> >25</option>
			      <option value="50" <?php if ($numPerPage == 50) { echo "selected='selected'";}?> >50</option>
			      <option value="75" <?php if ($numPerPage == 75) { echo "selected='selected'";}?> >75</option>
			      <option value="-1" <?php if ($numPerPage == -1) { echo "selected='selected'";}?> >All</option>
			    </select>
			  </td>
			</tr>
			<tr>
				<td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
				<?php CreateHiddenField("type","asset");?>
				</td>
				<td><input id="search" type="button" name="Submit" value="Submit" />
				&nbsp;
				&nbsp;
				<?php CreateResetButton();?>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
				&nbsp;
				</td>
				<td>
				&nbsp;
				</td>
			</tr>
		</table>
	</form>
	<div id="results">
	</div>

</div>
