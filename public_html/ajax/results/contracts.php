<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
?>
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
