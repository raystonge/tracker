<?php
/*
 * Created on Mar 4, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
$label = "";
if (strlen($asset->name))
{
	$label = AddParam($label,$asset->name);
}
else
{
	//$label = $asset->serialNumber;
	$label = AddParam($label,$asset->employeeName);
}
if (strlen($asset->serialNumber))
{
	$label = AddParam($label,"-".$asset->serialNumber);
}
$label = str_replace(" and ","",$label);
echo $label." - ";

?>
<?php
if ($permission->hasPermission("Ticket: Create") && !$asset->isEwasted())
{
	?>
	<a href="/process/asset/createTicket.php?assetId=<?php echo $asset->assetId;?>">Create Ticket for Asset</a>
	<?php
}
?>
