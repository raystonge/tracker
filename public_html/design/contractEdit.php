<?php
include_once "tracker/permission.php";
include_once "tracker/contract.php";
$button = "Create";
$contractId = 0;
$formKey = "";
PageAccess("Contract: Edit");

if (isset($request_uri[2]))
{
	if (strlen($request_uri[2]))
	{
		$contractId = $request_uri[2];
		DebugText("using param 2:".$contractId);
	}
}
$contract = new Contract($contractId);
$formKey = getFormKey();

if ($contract->contractId)
{
	$button = "Update";
}
$label = "";
if (strlen($contract->name))
{
	$label = $contract->name;
}
else
{
	$label = $contract->contractNumber;
}
echo $label." - ";

?>
<div id='main_column'>
	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/contract/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>	          
<div class="clear"></div>
	<div id='tab-editor'>
     <?php
     include $sitePath."/design/contract/editor.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>