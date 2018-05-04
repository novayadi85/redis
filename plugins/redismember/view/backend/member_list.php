<div class="wrap">
<h1>Member List
<a class="page-title-action" href="admin.php?page=member-add">Add New</a>
</h1>
<div class="filter" style="float:right;">
	<form action="<?php print $link; ?>" method="GET" >
		<p><input type="text" value="<?php echo (empty($_GET['fsearch'])) ? "" : $_GET['fsearch']; ?>" name="fsearch" /><input type="submit" name="" id="search-submit" class="button" value="Search by Email"></p>
		<input type="hidden" name="page" value="<?php echo empty($_GET['page']) ? "" : $_GET['page']; ?>" />
		<input type="hidden" name="onpage" value="<?php echo empty($_GET['onpage']) ? "" : $_GET['onpage']; ?>" />
	</form>
</div>
<div class="tablenav top">
	<div class="alignleft actions bulkactions">
		<label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
		<select name="action" id="bulk-action-selector-top">
			<option value="-1">Bulk Actions</option>
			<option value="delete">Delete</option>
		</select>
		<input id="doaction" class="button action" value="Apply" type="submit">
	</div>
</div>
<?php $hasils = array(); ?>
<table class="wp-list-table widefat fixed striped users" cellspacing="0">
	<thead>
		<tr>
			<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
			<th>Name</th>
			<th>Email</th>
			<th>Status</th>
			<th>Phone</th>
			<th>Company</th>
			<th class="last">Action</th>
		</tr> 
	</thead>	
		
	<tbody id="the-list" data-wp-lists="list:member">
		<?php 
		$members = all_members() ; 
		foreach($members as $member):?>
		<tr>
			<th scope="row" class="check-column"><label class="screen-reader-text" for="member_<?php echo $member->member_id?>">Select suspend</label><input name="members[]" id="user_<?php echo $member->member_id ; ?>" class="administrator" value="1" type="checkbox"></th>
			<td><?php echo $member->last_name . " " .$member->first_name; ?></td>
			<td><?php echo $member->email; ?></td>
			<td><?php echo member_status($member->membership_level); ?></td>
			<td><?php echo $member->phone;?></td>
			<td><?php echo $member->company;?></td>
			<td><span class="edit"><a href="admin.php?page=member-add&member_id=<?php echo $member->member_id; ?>">Edit</a></span></td>
		</tr>
		<?php endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>
			<th>Name</th>
			<th>Email</th>
			<th>Status</th>
			<th>Phone</th>
			<th>Company</th>
			<th class="last">Action</th>
		</tr> 
	</tfoot>
</table>
<div class="tablenav bottom">
	<div class="tablenav-pages one-page"><span class="displaying-num"><? echo count($members); ?> item(s)</span></div>
</div>
</div>