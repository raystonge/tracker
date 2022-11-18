<table class="width100">
  <tr>
   <th>Name</th>
   <th>Contact Name</th>
   <th>Contract Date</th>
  </tr>
<?php
include_once "globals.php";
include_once "tracker/contract.php";
$contract =  new Contract();
$ok = $contract->Get("");
while ($ok)
{
	?>
	<tr class="mritem">
	  <td>
	  <?php
	  if ($permission->hasPermission("Contract: Edit"))
	  {
	  	?>
	    <a href="/contractEdit/<?php echo $contract->contractId;?>/"><?php echo $contract->name;?></a>
	    <?php
	  }
	  else
	  {
	  	if ($permission->hasPermission("Contract: View"))
	  	{
	  		?>
	  		<a href="/viewContract/<?php echo $contract->contractId;?>/"><?php echo $contract->name;?></a>
	  		<?php
	  	}
	  	else
	  	{
	  		echo $contract->name;
	  	}
	  }
	  ?>
	  </td>
	  <td>
	    <?php echo $contract->contactName;?>
	  </td>
	  <td>
	    <?php echo $contract->expireDate;?>
	  </td>
	</tr>
	<?php
	$ok = $contract->Next();
}
?>
</table>
