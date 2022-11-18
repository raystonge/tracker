<?php
/*
 * Created on Nov 22, 2013
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
if (isset($_FILES['importFile']))
{
	$fname = $_FILES['importFile']['tmp_name'];
	$originalName = $_FILES['importFile']['name'];
	if (strlen($fname)==0)
	{
		exit;
	}
}
?>
Import done