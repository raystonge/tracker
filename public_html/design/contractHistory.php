<div class="adminArea">
<!--
	<h2><a href="/listTickets/" class="breadCrumb">Tickets</a> -> New Ticket</h2>
-->
	
<?php
$contractId = 0;
if (isset($request_uri[2]))
{
	$contractId = $request_uri[2];
}

include_once "tracker/contract.php";
$contract = new Contract($contractId);
$label = "";
if (strlen($contract->name))
{
	$label = $contract->name;
}
else
{
	$label = $contract->serialNumber;
}
echo $label." - ";
?>

<div id='main_column' class="main-navigation navbar navbar-inverse">
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
     include $sitePath."/design/contract/history.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>