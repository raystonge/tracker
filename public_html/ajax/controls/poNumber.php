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
<?php
include_once "globals.php";
include_once "tracker/asset.php";
include_once "tracker/ticket.php";
include_once "tracker/contract.php";
include_once "tracker/poNumber.php";
$organizationId = GetTextField("organizationId",GetTextField("searchOrganizationId",0));
$ticketId = GetTextField("ticketId",0);
$assetId = GetTextField("assetId",0);
$contractId = GetTextField("contractId",0);
$ticket = new Ticket($ticketId);
$asset = new Asset($assetId);
$contract = new Contract($contractId);
$type = GetTextField("type","");
$id = 0;
$poNumberId = 0;
if ($ticketId)
{
	$id = $ticketId;
}
else
{
	if ($assetId)
	{
		$id = $assetId;
	}
}
?>
			  <?php
			  if ($permission->hasPermission("$type: Edit: PO Number"))
			  {
			  	if (!GetTextField("hideLabel",0))
			  	{
			  	?>

			  PO Number:
			  <?php
			  	}
			  	?>
			  <select name="poNumberId" id="poNumberId" <?php if ($showMouseOvers){echo "title='PO associated with purchase'";}?>>
			    <option value="0">Select PO (optional)</option>
			    <?php
			    $po = new poNumber();
			    $param = AddEscapedParam("", "poType", $type);
					if ($type == "contract")
					{
						$param1 = AddEscapedParam("","poType","asset");
						$param = $param." or ".$param1;
					}
			    if ($organizationId)
			    {
			        $param = AddEscapedParam($param, "organizationId", $organizationId);
			    }
			    $ok = $po->Get($param);
			    while ($ok)
			    {
			    	$selected = "";
			    	if (($po->poNumberId == $asset->poNumberId) || ($po->poNumberId == $contract->poNumberId))
			    	{
			    		$selected = "selected='selected'";
			    	}
			    	?>
					<option value="<?php echo $po->poNumberId;?>" <?php echo $selected;?> ><?php echo $po->poNumber." - ".$po->description;?></option>
			    	<?php
			    	$ok = $po->Next();
			    }
			    ?>
			    </select>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("$type: View: PO Number"))
			  	{
			  		$po = new poNumber($asset->poNumberId);
			  		echo "PO Number: ".$po->poNumber." - ".$po->description;
			  	}
			  	CreateHiddenField("poNumberId",$poNumberId);
			  }
			// DebugOutput();
			  ?>
