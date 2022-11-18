<?php
include_once "tracker/organization.php";
$assetId = 0;
if (isset($request_uri[2]))
{
	$assetId = $request_uri[2];
}
include_once "tracker/asset.php";
$asset = new Asset($assetId);
?>
<form action="/process/moveAsset.php" method="post">
<table width="100%">
  <tr>
    <td> New <?php echo $orgOrDept;?> : </td>
    <td>
      <select id="organization" name="organization">
        <?php

        $param = "organizationId in (".GetMyOrganizations().") and active=1";
        $organization= new Organization();
        $ok = $organization->Get($param);
        while ($ok)
        {
          $selected = "";
          if ($asset->organizationId == $organization->organizationId)
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
  </tr>
  <tr>
    <td>Asset Type : </td>
    <td><div id="resultsAssetType"></div></td>
  </tr>
  <tr>
    <td>Building : </td>
    <td><div id="resultsBuilding"></div></td>
  </tr>
</table>
<?php
CreateHiddenField("assetId",$asset->assetId);
PrintFormKey();
CreateSubmit();
 ?>
</form>
