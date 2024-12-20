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
					  include_once "tracker/monitor.php";
					  $query = "select m.* from monitor m inner join asset a on m.assetId=a.assetId";
					  $param = "active=1";
					  $state = 0;
					  if ($state >=0)
					  {
						  $param = AddEscapedParam($param,"m.state",$state);
					  }
					  
					  if (strlen($param))
					  {
						  $query = $query." where ".$param;
					  }
					  $monitor = new Monitor();
					  $ok = $monitor->doSelectQuery($query);
					  $serversDown = $ok;

					  
	                  if ($permission->hasPermission("Monitor"))
	                  {
						$dropdownClass = "dropdown-toggle";
						if ($serversDown)
						{
							$dropdownClass = "dropdown-serversDown";
						}
	                  	?>
                      <li id="menu-item-11" class="<?php echo $monitorClass;?>" ><a href="/monitor/" class="<?php echo $dropdownClass;?>">Monitor  </a>

                      </li>
                      <?php
	                  }
	                  ?>
