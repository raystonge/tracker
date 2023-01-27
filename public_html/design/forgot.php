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
<script language="javascript" src="/js/validate_form.js"></script>
<script language="javascript" src="/js/ajax.js"></script>

<script language="javascript">
function validateForm(theForm)
{
  if (!validRequired(theForm.email,"Email"))
  {
    return false;
  }
  if (!validEmail(theForm.email,"Email",1))
  {
    return false;
  }
  return true;
}
</script>

    <h2 id="post-">Forgot Password</h2>
    <div class="postwrap fix">
	  <div class="post-8 page type-page hentry" id="post-8">
		<div class="copy fix">
		  <div class="textcontent">
			<p>If you have forgotten your password, please enter your email address and we will send you a link to reset your password.</p>
            <div class="wpcf7" id="f1-p8-o1">
			  <form action="/forgotsent/" method="post" class="form" onsubmit="return validateForm(this);">
                <p>Your Email (required)<br>
                  <span class="form-control-wrap your-email"><input name="email" type="text" class="text validates-as-email validates-as-required" id="email" size="60" >
                  </span>
			    </p>
				  <input value="Send" name="submit" class="submitButton" type="submit">
				  <img class="ajax-loader" style="visibility: hidden;" alt="ajax loader" src="/images/ajax-loader.gif">
				</p>
                <div class="response-output display-none"></div>
				<input type="hidden" value="0" name="validEmail" />
			  </form>
			</div>
          </div>
		  <div class="tags">
					&nbsp;
		  </div>
		</div>
	  </div><!--post -->
    </div>
	<div class="clear"></div>
