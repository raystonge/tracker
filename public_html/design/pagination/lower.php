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
 <div class='num_results_lower'>
  <?php
  DebugText("pages:".$pages);
  DebugText("numRows:".$numRows);
  DebugText("page:".$page);
  if ($pages > 1)
  {
  ?>
  <div class='num_results'>
    Results (<?php echo $numRows;?>)
  </div>
  <div class='pagination'>
      Page:
    <ul id="paginationResults">
      <?php
      //Pagination Numbers
      if ($pages > 25)
      {
      	$pages = 25;
      }
      for($i=1; $i<=$pages; $i++)
      {
          if($i == $page) $class = 'class="is_selected"';
          else $class = '';
          ?>
           <li id="<?php echo $i;?>" class="<?php echo $class;?>"><span><?php echo $i;?></span></li>
          <?php

      }
      ?>
    </ul>
  </div>
  <?php
  }
  ?>
</div>
</div>
