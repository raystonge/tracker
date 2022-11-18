<?php
include_once "tracker/insurancePayment.php";
include_once "tracker/insuranceRepair.php";
include_once "tracker/insuranceRepairComplete.php";
include_once "tracker/poNumber.php";
PageAccess("Ticket: View Warranty");

$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
$paymentMade = 0;
$repairMade = 0;
?>
    <?php
    if (FormErrors())
    {
    	DisplayFormErrors();
    	$ticket->poNumberId = GetTextFromSession("insurancepoNumberId",$ticket->poNumberId);
    	$ticket->repairCost = GetTextFromSession("insuranceRepairCost");
	 	  $ticket->insuranceRepairComplete = GetTextFromSession("insuranceRepairComplete",$today);
		  $ticket->insurancePayment = GetTextFromSession("insurancePayment",$today);
		  $paymentMade = GetTextFromSession("paymentMade",0);
		  $repairMade = GetTextFromSession("repairMade",0);
    }
    if (FormSuccess())
    {
    	DisplayFormSuccess();
    }
    ?>
<script type="text/javascript">
adminFilePath="";
function toggleInsurancePayment()
{
  var insurancePayment_Month_ID = document.getElementById('insurancePayment_Month_ID');
  var insurancePayment_ID = document.getElementById('insurancePayment_Day_ID');
  var insurancePayment_Year_ID = document.getElementById('insurancePayment_Year_ID');
  insurancePayment_Month_ID.disabled = !insurancePayment_Month_ID.disabled;
  insurancePayment_Day_ID.disabled = !insurancePayment_Day_ID.disabled;
  insurancePayment_Year_ID.disabled = !insurancePayment_Year_ID.disabled;

}
function disableInsurancePayment()
{
  var insurancePayment_Month_ID = document.getElementById('insurancePayment_Month_ID');
  var insurancePayment_Day_ID = document.getElementById('insurancePayment_Day_ID');
  var insurancePayment_Year_ID = document.getElementById('insurancePayment_Year_ID');
  insurancePayment_Month_ID.disabled = true;
  insurancePayment_Day_ID.disabled = true;
  insurancePayment_Year_ID.disabled = true;
}
function toggleInsuranceRepairComplete()
{
  var insuranceRepairComplete_Month_ID = document.getElementById('insuranceRepairComplete_Month_ID');
  var insuranceRepairComplete_ID = document.getElementById('insuranceRepairComplete_Day_ID');
  var insuranceRepairComplete_Year_ID = document.getElementById('insuranceRepairComplete_Year_ID');
  insuranceRepairComplete_Month_ID.disabled = !insuranceRepairComplete_Month_ID.disabled;
  insuranceRepairComplete_Day_ID.disabled = !insuranceRepairComplete_Day_ID.disabled;
  insuranceRepairComplete_Year_ID.disabled = !insuranceRepairComplete_Year_ID.disabled;

}
function disableInsuranceRepairComplete()
{
  var insuranceRepairComplete_Month_ID = document.getElementById('insuranceRepairComplete_Month_ID');
  var insuranceRepairComplete_Day_ID = document.getElementById('insuranceRepairComplete_Day_ID');
  var insuranceRepairComplete_Year_ID = document.getElementById('insuranceRepairComplete_Year_ID');
  insuranceRepairComplete_Month_ID.disabled = true;
  insuranceRepairComplete_Day_ID.disabled = true;
  insuranceRepairComplete_Year_ID.disabled = true;
}

$(document).ready(function ()
{
	$('#insuranceRepair').change(function () {
		val = $(this).val();
		if (val == "No")
		{
			$('#repairCost').prop( "disabled", true );
			$('#paymentMade').prop( "disabled", true );
			$('#repairMade').prop( "disabled", true );
			$('#poNumberId').prop( "disabled", true );
		}
		else
		{
			$('#repairCost').prop( "disabled", false );
			$('#paymentMade').prop( "disabled", false );
			$('#repairMade').prop( "disabled", false );
			$('#poNumberId').prop( "disabled", false );
		}
	});
    $('#insuranceRepair').change();
});
</script>
<script type="text/javascript"  src="<?php echo $hostPath;?>/js/calendarDateInput.js"></script>
	<form method="post" autocomplete="<?php echo $autoComplete;?>"  action="/process/ticket/insurance.php">
		<table>
			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Ticket: Edit: PO Number"))
			  {
			  	?>
			  PO Number:
					<select id="poNumberId" name="poNumberId">
					  <option value="0">Select PO</option>
					<?php
					$poNumber = new poNumber();
					$ok = $poNumber->Get("poType='Ticket' or poType='AssetTicket'");
					while ($ok)
					{
						$selected = "";
						if ($poNumber->poNumberId == $ticket->poNumberId)
						{
							$selected = "selected='selected'";
						}
						DebugText("id:".$poNumber->poNumberId." ".$selected);
						?>
						<option value="<?php echo $poNumber->poNumberId;?>" <?php echo $selected;?>><?php echo $poNumber->poNumber;?></option>
						<?php
						$ok = $poNumber->Next();
					}
					?>
					</select>
					<?php
				}
				else
				{
					if ($permission->hasPermission("Ticket: View: PO Number"))
					{
						$poNumber = new poNumber($ticket->poNumberId);
						echo "PO Number: ".$poNumber->poNumber;
					}
					CreateHiddenField("poNumberId",$ticket->poNumberId);
				}
				?>
			  </td>
			  <td>&nbsp;
			  </td>
			</tr>

			<tr>
			  <td>
			  <?php
			  if ($permission->hasPermission("Ticket: Edit: Warranty Repair"))
			  {
			  	?>
			  Warranty Repair :
			  <select name="insuranceRepair" id="insuranceRepair">
			    <option value="">Select Warranty Repair</option>
			    <option value="Yes" <?php if ($ticket->insuranceRepair == "Yes"){ echo "selected='selected'";}?>>Yes</option>
			    <option value="No" <?php if ($ticket->insuranceRepair == "No"){ echo "selected='selected'";}?>>No</option>
              </select>
			  	<?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Ticket: View: Warranty Repair"))
			  	{
			  		echo "Warranty Repair: ".$ticket->insuranceRepair;
			  	}
			  }
			  ?>

			  </td>
			  <td>
			  <?php
			  if ($permission->hasPermission("Ticket: Edit: Repair Cost"))
			  {
			  	?>
			  Repair Cost : <?php CreateTextField("repairCost",$ticket->repairCost);?>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Ticket: View: Repair Cost"))
			  	{
			  		echo "Repair Cost : ".$ticket->repairCost;
			  	}
			  }
			  ?>
			  </td>
			</tr>
			<tr>
			  <td>
			  <?php
			  $checkedInsurancePayment = $paymentMade;
			  if ($permission->hasPermission("Ticket: Edit: Warranty Payment"))
			  {
			  	?>
			  Warranty Payment: <?php
			  if (strlen($ticket->insurancePayment))
			  {
			  	$checkedInsurancePayment = 1;
			  }
			  else
			  {
			  	$ticket->insurancePayment = $today;
			  }
			  CreateCheckBox("paymentMade",1,"Payment Made",$checkedInsurancePayment,"Payment has been made","","onclick=toggleInsurancePayment()");

			  ?>
			  <script>DateInput('insurancePayment', true, 'YYYY/MM/DD','<?php echo $ticket->insurancePayment;?>')</script>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Ticket: View: Warranty Payment"))
			  	{
			  		echo "Warranty Payment : ".$ticket->insurancePayment;
			  	}
			  }
			  ?>
			  </td>
			  <td>
			  <?php
			  $checkedInsuranceRepairComplete = $repairMade;
			  if ($permission->hasPermission("Ticket: Edit: Warranty Repair Complete"))
			  {
			  	?>
			  Warranty Repair Complete : <?php

			  if (strlen($ticket->insuranceRepairComplete))
			  {
			  	$checkedInsuranceRepairComplete = 1;
			  }
			  else
			  {
			  	$ticket->insuranceRepairComplete = $today;
			  }
			  DebugText("checked Insurance Repair Complete:".$checkedInsuranceRepairComplete);
			  CreateCheckBox("repairMade",1,"Repair Compete",$checkedInsuranceRepairComplete,"Repair has been made","","onclick=toggleInsuranceRepairComplete()");

			  ?>
			  <script>DateInput('insuranceRepairComplete', true, 'YYYY/MM/DD','<?php echo $ticket->insuranceRepairComplete;?>')</script>
			  <?php
			  }
			  else
			  {
			  	if ($permission->hasPermission("Ticket: View: Warranty Repair Complete"))
			  	{
			  		echo "Warranty Repair Complete :".$ticket->insuranceRepairComplete;
			  	}
			  }
			  ?>
			  </td>
			</tr>
		</table>
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
                <input type="hidden" name="submitTest" value="1"/>
                <input type="hidden" name="ticketId" value="<?php echo $ticket->ticketId;?>" />
                <?php
                if ($permission->hasPermission("Ticket: Edit: PO Number") ||
                    $permission->hasPermission("Ticket: Edit: Warranty Repair") ||
                    $permission->hasPermission("Ticket: Edit: Repair Cost") ||
                    $permission->hasPermission("Ticket: Edit: Warranty Payment") ||
                    $permission->hasPermission("Ticket: Edit: Warranty Repair Complete")
                )
                {
                	CreateSubmit("Submit");
                }
                ?>
    </form>
<?php
if ($checkedInsurancePayment==0)
{
	?>
	<script language="javascript">disableInsurancePayment();</script>
	<?php
}
if ($checkedInsuranceRepairComplete==0)
{
	?>
	<script language="javascript">disableInsuranceRepairComplete();</script>
	<?php
}
?>
