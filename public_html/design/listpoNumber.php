<?php
include_once "tracker/poNumber.php";
include_once "tracker/permission.php";
include_once "tracker/organization.php";
PageAccess("PO: List");
$poNumber = new poNumber();
$formKey = "";
if (isset($_POST['formKey']))
{
	$formKey = strip_tags($_POST['formKey']);
}
else
{
	$formKey = getFormKey();
}
?>

<div class="adminArea">
	<h2><a href="/listpoNumber/" class="breadCrumb">PO Numbers</a></h2>
	<?php
	if ($permission->hasPermission("poNumber: Create"))
    {
	?>
	<div class="options">
		<a id="newTicket" href="/poNumberNew/" class="addLink" <?php if ($showMouseOvers) {echo 'title="Create new PO Number"';}?>>New PO NUmber</a>
	</div>
	<?php
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
	<?php
	$sectionName = GetTextField("sectionName");
	$organizationId = GetTextField("organization",0);
	$reconciled = GetTextField("reconciled",-1);
	?>
	<form method="post" autocomplete="<?php echo $autoComplete;?>">
		<table>
			<tr>
				<td valign="top">PO Number/Description:
				</td>
				<td><input name="sectionName" type="text" <?php if ($showMouseOvers){echo 'title="Search by Section Name"';};?>
					value="<?php echo $sectionName;?>" /><br />
				</td>
				<td valign="top">
				<?php echo $orgOrDept;?>:
				</td>
				<td>
				<select name="organization">
				  <option value="0">All <?php echo $orgOrDept;?>s</option>
				<?php
        $myOrganizations = GetMyOrganizations();
        $organization = new Organization();
				$param = "organizationId in ($myOrganizations) and active=1";
				$ok = $organization->Get($param);
				while ($ok)
				{
					$selected = "";
					if ($organizationId == $organization->organizationId)
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
				<?php

				if ($permission->hasPermission("poNumber: Reconcile"))
				{

				?>
				Reconciled: <select name="reconciled">
				            <option value="-1">All</option>
				            <option <?php if ($reconciled == 1) echo "selected='selected'"; ?>value="1">Reconciled</option>
				            <option <?php if ($reconciled == 0) echo "selected='selected'"; ?>value="0">Unreconciled</option>
				            </select>
				<?php
				}
				else
				{
					PrintNBSP();
				}?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;
				<input type="hidden" name="formKey" value="<?php echo $formKey;?>"/>
				<input type="hidden" name="page" id="page" value="<?php echo $page;?>">
				</td>
				<td><input id="search" type="submit" name="Submit" value="Submit" /></td>
			</tr>
		</table>
	</form>

	<div id="results">
	</div>

</div>
