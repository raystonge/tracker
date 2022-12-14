<?php
/*
 * Created on Jul 28, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/spec.php";
include_once "tracker/specToAssetType.php";
include_once "tracker/assetToSpec.php";
$formKey = getFormKey();
$linkName = "";
$link = "";
$assetId = GetURI(2,0);
$asset = new Asset($assetId);
if (FormErrors())
{
	DisplayFormErrors();
}
if (FormSuccess())
{
	DisplayFormSuccess();
}
?>

<form method="post" autocomplete="<?php echo $autoComplete;?>" enctype="multipart/form-data" action="/process/asset/specs.php">
<table>
	<?php
  $specToAssetType = new SpecToAssetType();
	$param = AddEscapedParam("","assetTypeId",$asset->assetTypeId);
	$ok = $specToAssetType->Get($param);
	while ($ok)
	{
		$spec = new Spec($specToAssetType->specId);
		$assetToSpec = new AssetToSpec();
		$param = AddEscapedParam("","assetId",$asset->assetId);
		$param = AddEscapedParam($param,"specId",$spec->specId);
		$assetToSpec->Get($param);
		?>
		<tr>
			<td>
				<?php echo $spec->name;?>
			</td>
			<td>
				<?php
				if ($spec->dataType == "text")
				{
					CreateTextField("specId".$spec->specId,$assetToSpec->specValue);
				}
				else
				{

					CreateCheckBox("specId".$spec->specId,1,"",$assetToSpec->specValue);
					//function CreateCheckBox($name,$val,$dspVal="",$checked=0,$title="",$class="",$js="")
				}
				?>
			</td>
		</tr>
		<?php
		$ok = $specToAssetType->Next();
	}
	 ?>

</table>
<?php
PrintFormKey();
CreateHiddenField("submitText",1);
CreateHiddenField("assetId",$asset->assetId);
if (!$asset->isEwasted())
{
  CreateSubmit("Submit","Submit");
}
?>
</form>
