<div class="wrap">
<h1>Member List
<a class="page-title-action" href="http://localhost/rediscover/wp-admin/user-new.php">Add New</a>
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
		<tr>
			<th scope="row" class="check-column"><label class="screen-reader-text" for="user_1">Select suspend</label><input name="users[]" id="user_1" class="administrator" value="1" type="checkbox"></th>
			<td>Test</td>
			<td>Test</td>
			<td>Test</td>
			<td>Test</td>
			<td>Test</td>
			<td>Test</td>
		</tr>
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
	<div class="tablenav-pages one-page"><span class="displaying-num">1 item</span></div>
</div>
</div>