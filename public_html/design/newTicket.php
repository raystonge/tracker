<?php
/*
 * Created on Dec 4, 2015
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/organization.php";
?>
<?php
PageAccess("Ticket: Create","Ticket: Create: User Ticket");
?>
<div class="adminArea">
	<h2><a href="/listTickets/" class="breadCrumb">Tickets</a> -> New Ticket</h2>
<form action="/ticketNew/" method="post">
        	<select name="organization" id="organization">
        	  <option value="0">Select <?php echo $orgOrDept;?></option>
        	<?php

        	$param = "organizationId in (".GetMyOrganizations().")";
        	$organization= new Organization();
					$param = "active=1";
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
        	<br>
        	<br>
	<?php
	               PrintFormKey();
               CreateHiddenField("submitTest",1);
               CreateSubmit("Continue","Continue");
	?>
</form>
</div>
