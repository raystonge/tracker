<?php
//
//  Tracker - Version 1.0
//
//    Copyright 2012 RaywareSoftware - Raymond St. Onge
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
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
