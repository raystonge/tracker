<div class="adminArea">
<!--
	<h2><a href="/listAssets/" class="breadCrumb">Assets</a> -> New Asset</h2>
-->
	
<?php
$poNumberId = 0;
if (isset($request_uri[2]))
{
	$poNumberId = $request_uri[2];
}
include_once "tracker/poNumber.php";
$poNumber = new poNumber($poNumberId);
$label = "";
if (strlen($poNumber->poNumber))
{
	$label = $poNumber->poNumber." - ".$poNumber->description;
}
else
echo $label;
?>
<div id='main_column' class="main-navigation navbar navbar-inverse">
	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/poNumber/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>	
<div class="clear"></div>

	<div id='tab-editor'>
     <?php
     include $sitePath."/design/poNumber/history.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>