<?php
/*
 * Created on Dec 7, 2012
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
$type = strtolower($type);
$htmlAction = "<div class='roptions'>";
/*
$htmlAction='<a href="/editAttachment/'.$attachment->attachmentId.'/" class="edit_attachment" ';
if ($showMouseOvers)
{
	$htmlAction=$htmlAction.' title="Edit"';
}
$htmlAction=$htmlAction.' alt="Edit"><img src="/images/icon_edit.png"></a>';
*/
if ($asset->assetConditionId != 8)
{
  $htmlAction=$htmlAction.'<a href="/'.$type.'DeleteAttachment/'.$attachment->attachmentId.'/" class="delete_attachment" ';
  if ($showMouseOvers)
  {
    $htmlAction = $htmlAction.' title="Delete"';
  }
  $htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"></a>';
}
$htmlAction=$htmlAction."</div>";
?>
