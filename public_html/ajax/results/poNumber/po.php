<?php
/*
 * Created on Aug 16, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "globals.php";
include_once "tracker/organization.php";
include_once "tracker/contract.php";
include_once "tracker/poNumber.php";

?>
        <?php
        $contract = new Contract(GetTextField("contractId"),0);
        $organizationId = GetTextField("organization",0);
        DebugText("organizationId:".$organizationId);
        if ($permission->hasPermission("Contract: Edit: PO Number"))
        {
        	$pos = new Set(",");
        	$pos->Add(0);
        	$testContract = new Contract();
        	$param = "poNumberId > 0 and poNumberId <>".$contract->poNumberId;
        	$ok = $testContract->Get($param);
        	while ($ok)
        	{
        		$pos->Add($testContract->poNumberId);
        		$ok = $testContract->Next();
        	}
        	?>
        <select name="poNumberId" id="poNumberId">
          <option value="0">Select PO Number</option>
          <?php
          $po = new poNumber();
          $param = "poType='Contract' and poNumberId not in ($pos->data) and organizationId =".$organizationId;
          $ok = $po->Get($param);
          while ($ok)
          {
          	$selected = "";
          	if ($contract->poNumberId == $po->poNumberId)
          	{
          		$selected = "selected='selected'";
          	}
          	?>
          	<option value="<?php echo $po->poNumberId;?>" <?php echo $selected;?>><?php echo $po->poNumber." - ".$po->description;?></option>
          	<?php
          	$ok = $po->Next();
          }
          ?>
        </select>
        <?php
        }
        else
        {
        	if ($permission->hasPermission("Contract: View: PO Number"))
        	{
        		$po = new poNumber($contract->poNumberId);
        		echo "PO Number: ";
        		if ($po->poNumberId)
        		{
        			echo $po->poNumber." - ".$po->description;
        		}
        	}
       		CreateHiddenField("poNumberId",$contract->poNumberId);
        }
        //DebugOutput();
        ?>
