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
include_once "tracker/history.php";
include_once "tracker/user.php";
$history = new History();
?>
<table class="width100">
  <th>
  Date
  </th>
  <th>
  User
  </th>
  <th>
  Action
  </th>
  <?php
  $ok = $history->GetForTicket($ticket->ticketId);
  while ($ok)
  {
  	$user = new User($history->userId);
  	?>
  	<tr>
      <td>
      <?php echo $history->actionDate;?>
      </td>
      <td>
      <?php echo $user->fullName;?>
      </td>
      <td>
      <?php echo $history->action;?>
      </td>
    </tr>
  	<?php
  	$ok = $history->Next();
  }
  ?>
</table>
