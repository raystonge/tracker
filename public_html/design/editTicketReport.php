<?php
/*
 * Created on Jan 29, 2014
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
include_once "tracker/module.php";
$moduleId = GetURI(2,0);
$module = new Module($moduleId);
?>
<div id='main_column'>
  <?php
  include $sitePath."/design/reports/ticketEditor.php";
  ?>
</div>