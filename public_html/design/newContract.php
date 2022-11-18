<?php
PageAccess("Config: Contract: Create");
include_once "tracker/contract.php";
$button = "Create";
$contract = new Contract();
include $sitePath."/design/contract/editor.php";
?>