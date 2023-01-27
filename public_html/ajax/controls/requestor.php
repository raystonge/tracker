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
include_once "globals.php";
include_once "tracker/ticket.php";
include_once "tracker/defaultUser.php";
$ticketId = GetTextField("ticketId",0);
$organizationId = GetTextField("organization",0);
$ticket = new Ticket($ticketId);
$queueId = GetTextField("queue",0);

?>
			    <select name="searchRequestorId" id="searchRequestorId">
			      <option value="0">All</option>
			      <?php
			      $user = new User();
			      $param = "active=1";
			      $param = AddEscapedParam($param,"uto.organizationId",$organizationId);
			      $ok = $user->GetRequestors($param);
			      while($ok)
			      {
							$userInfo = new User($user->userId);
			      	$selected="";
			      	if ($user->userId == $searchRequestorId)
			      	{
			      		$selected = "selected='selected'";
			      	}
			      	?>
			      	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $userInfo->fullName;?></option>
			      	<?php
			      	$ok = $user->Next();
			      }
			      ?>
			    </select>
