<?php
PageAccess("Asset: Create");
?>
<div class="adminArea">
	<h2><a href="/listpoNumber/" class="breadCrumb">PO Number</a> -> New PO Number</h2>
<?php
include_once "tracker/poNumber.php";
$poNumber = new poNumber();
include $sitePath."/design/poNumber/editor.php";
?>
</div>