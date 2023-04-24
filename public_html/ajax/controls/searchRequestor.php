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
$organizationId = GetTextField("organizationId",0);
$ticket = new Ticket($ticketId);
$queueId = GetTextField("queue",0);

?>
			    <select name="searchRequestorId" id="searchRequestorId">
			      <option value="0">All</option>
			      <?php
			      $user = new User();
			      $param = "active=1";
						if ($organizationId)
						{
							$param = AddEscapedParam($param,"uto.organizationId",$organizationId);
						}
						else {
							$param = $param." and organizationId in (".GetMyOrganizations().")";
						}

						if ($permission->hasPermission("Ticket: Create: User Ticket") && !$permission->hasPermission("Developer"))
						{
							$param = AddEscapedParam($param,"u.userId",$currentUser->userId);
						}

						$searchRequestorId = GetTextFromSession("searchTicketRequestorId",0,0);
			      $ok = $user->GetRequestors($param);
			      while($ok)
			      {
			      	$selected="";
			      	if ($user->userId == $searchRequestorId || $user->numRows == 1)
			      	{
			      		$selected = "selected='selected'";
			      	}
							$userInfo = new User($user->userId);
			      	?>
			      	<option value="<?php echo $user->userId;?>" <?php echo $selected;?>><?php echo $userInfo->fullName;?></option>
			      	<?php
			      	$ok = $user->Next();
			      }
			      ?>
			    </select>
<?php // DebugOutput(); ?>
