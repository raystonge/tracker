<?php
//
//  Tracker - Version 1.9.0
//
//  v1.9.0
//   - add ability to edit users of service
//
//  v1.8.2
//   - fixing cross site security error on delete
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
$key = CreateLinkKey("deleteService");
$htmlAction='<a href="/editService/'.$service->serviceId.'/" class="edit_service" ';
if ($showMouseOvers)
{
	$htmlAction=$htmlAction.' title="Edit"';
}
$htmlAction=$htmlAction.' alt="Edit"><img src="/images/icon_edit.png"></a>';
$htmlAction=$htmlAction.'<a href="/serviceUser/'.$service->serviceId.'/" class="user_service" ';
if ($showMouseOvers)
{
	$htmlAction = $htmlAction.' title="Modify Users"';
}
$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icons/list_users.gif"></a>';

$htmlAction=$htmlAction.'<a href="/deleteService/'.$service->serviceId.'/" class="delete_service" ';
if ($showMouseOvers)
{
	$htmlAction = $htmlAction.' title="Delete"';
}
$htmlAction=$htmlAction.' alt="Delete"><img src="/images/icon_trash.png"></a>';
?>
