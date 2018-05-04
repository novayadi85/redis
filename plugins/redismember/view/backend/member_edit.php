<div class="wrap">
	<h1>Member Edit</h1>
	<div id="ajax-response"></div>
	<form class="validate" id="create_member" method="post" name="createuser">
		<input name="action" type="hidden" value="createuser"> 
		<table class="form-table">
			<tbody>
				<tr class="form-field form-required">
					<th scope="row"><label for="user_login">Username <span class="description">(required)</span></label></th>
					<td><input aria-required="true" id="user_login" maxlength="60" name="user_login" type="text" value="<?php echo $member->user_name; ?>"></td>
				</tr>
				<tr class="form-field form-required">
					<th scope="row"><label for="email">Email <span class="description">(required)</span></label></th>
					<td><input id="email" name="email" type="email" value="<?php echo $member->email; ?>"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="first_name">First Name</label></th>
					<td><input id="first_name" name="first_name" type="text" value="<?php echo $member->first_name; ?>"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="last_name">Last Name</label></th>
					<td><input id="last_name" name="last_name" type="text" value="<?php echo $member->last_name; ?>"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="url">Website</label></th>
					<td><input class="code" id="url" name="url" type="url" value="<?php echo $member->home_page; ?>"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="phone">Phone</label></th>
					<td><input class="code" id="phone" name="phone" type="phone" value="<?php echo $member->phone; ?>"></td>
				</tr>
				<tr class="form-field">
					<th scope="row"><label for="company">Company</label></th>
					<td><input class="code" id="company" name="company" type="text" value="<?php echo $member->company; ?>"></td>
				</tr>
				<tr class="form-field form-required user-pass1-wrap">
					<th scope="row"><label for="pass1-text">Password <span class="description hide-if-js">(required)</span></label></th>
					<td>
					<input class="code" id="password" name="password" type="password" value="<?php echo $member->password; ?>">	
					</td>
				</tr>

				<tr class="form-field">
					<th scope="row"><label for="role">Level</label></th>
					<td><select id="role" name="level">
						<option <?php if($member->membership_level == "1") echo "selected = selected"; ?> value="1">
							Basic
						</option>
						<option <?php if($member->membership_level == "2") echo "selected = selected"; ?> value="2">
							Bronze
						</option>
						<option <?php if($member->membership_level == "3") echo "selected = selected"; ?> value="3">
							Silver
						</option>
						<option <?php if($member->membership_level == "4") echo "selected = selected"; ?> value="4">
							Gold
						</option>
					</select></td>
				</tr>
			</tbody>
		</table>
		<p class="submit">
			<button onclick="return false;" class="button button-primary" id="create_member_update" name="createuser">
			Update Member
			</button>
		</p>
	</form>
</div>