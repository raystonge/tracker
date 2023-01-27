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
<div class="adminArea">
<?php
$ticketId = 0;
if (isset($request_uri[2]))
{
	$ticketId = $request_uri[2];
}

include_once "tracker/ticket.php";
include_once "tracker/timeWorked.php";
$timeWorked = 0;
$ticket = new Ticket($ticketId);
include $sitePath."/design/ticket/ticketInfoHeader.php";
?>
<script src="https://cdn.tiny.cloud/1/udklcg4ghf32p6fo376bvfap162ddwbu1oq6jhb0tgs9qoi0/tinymce/<?php echo $tinyMCE;?>/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
tinymce.init({
//  selector: '#myeditablediv',
//  inline: true
	selector: 'textarea',
	height: 250,
	statusbar: false,
	toolbar: 'undo redo  bold italic alignleft aligncenter alignright bullist numlist outdent indent code',
	plugins: 'code',
	menubar: false
});
</script>
<div id='main_column'>

	    <nav id="navigation" role="navigation">
	      <div class="main-navigation navbar navbar-inverse">
	        <div class="navbar-inner">
	          <div class="container">
	            <div class="nav-collapse collapse">
	              <div class="menu-main-container">
	              <?php include $sitePath."/design/ticket/menu.php";?>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </nav>

<div class="clear"></div>

	<div id='tab-editor'>
     <?php
     include $sitePath."/design/ticket/schedule.php";
     ?>
	</div>
  </div>
</div>
<div class="clear"></div>
</div>
