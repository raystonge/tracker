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
$_SESSION['requestURI'] = $_SERVER['REQUEST_URI'];
?>
<table class="width100">
  <tr>
    <td class="alignTop" width="60%">
    <br />

    </td>
    <td class="alignTop" width="40%">
      <form method="POST" action="/process/login.php" autocomplete="<?php echo $autoComplete;?>">
        <table class="width100">
          <?php
          if (isset($_SESSION['failedLogin']))
          {
          	$failedLogin = $_SESSION['failedLogin'];
          	if ($failedLogin)
          	{
          		?>
                <tr>
                  <td colspan="2">
                  Login Failed
                  </td>
                </tr>
          		<?php
          	}
          }
          ?>
          <tr>
            <td>
              Email
            </td>
            <td>
              <input type="text" name="email" id="email" />
            </td>
          </tr>
          <tr>
            <td>
              Password
            </td>
            <td>
              <input type="password" name="password" id="password" />
            </td>
          </tr>
          <tr>
            <td>
            <?php PrintFormKey();?>
              &nbsp;<input type="hidden" name="formaction" value="1"/>
            </td>
            <td>
              <input type="submit" value="Login" name"submit" />
            </td>
          </tr>
          <tr class="antiSpam">
            <td>
              Leave Blank
            </td>
            <td>
              <input type="text" name="validator">
            </td>
          </tr>
          <tr>
            <td>&nbsp;
            </td>
            <td>
              <a href="/forgot/">Forgot Password?</a>
            </td>
          </tr>
          </table>
      </form>
    </td>
  </tr>
</table>
<?php SetFocus("email");?>
