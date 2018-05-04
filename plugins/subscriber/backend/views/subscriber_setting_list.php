<h1>Setting List</h1>
	<?php if($_GET['action']=='filter'){
		/* echo '<pre>';
		print_r($_POST);
		echo '</pre>'; */
	}else if($_GET['action']=='edit'){ 
		include('bvactct_setting.php');
	}else if($_GET['action']=='save'){ 
		include('save_setting.php');
	}elseif($_GET['action'] == 'delete'){
		if(!empty($_GET['myId'])){
			global $wpdb;
			$table = $wpdb->prefix."ipro";
			mysql_query('DELETE FROM ' . $table . ' WHERE ipro_id = "' . $_GET['myId'] . '"');
			$redirect = get_admin_url() . 'admin.php?page=' . $this->hook;
			print '<script type="text/javascript">document.location="' . $redirect . '";</script>';		
		}elseif(!empty($_GET['catId'])){
			global $wpdb;
			$table = $wpdb->prefix.'ipro_category';
			mysql_query('DELETE FROM ' . $table . ' WHERE category_id = "' . $_GET['catId'] . '"');
			$redirect = get_admin_url() . 'admin.php?page=' . $this->hook . '/ipro-category';
			print '<script type="text/javascript">document.location="' . $redirect . '";</script>';		
		}else{
			print 'Cant not process your request!';
		}
	
	}elseif($_GET['action'] == 'addImg'){
		include('addImg.php');
	
	 }else{ 
	 ?>
	<table class="wp-list-table widefat plugins" cellspacing="0">
	<thead>
		<tr>
			<th>Id</th>
			<th class="last">Title</th>
			<th class="last">Add Image</th>
			<th class="last">Action</th>
		</tr> 
	</thead>	
		<?php global $wpdb;?>

		<?php $table = $wpdb->prefix."ipro";?>
		<?php 
					$hasils = $wpdb->get_results("SELECT * FROM  $table WHERE ipro_type = 'commercial' ORDER BY ipro_id");
				
		?>
	<tbody>
		<?php	foreach ( $hasils as $hasil ) { ?>
				<tr>
					<td><?php echo $hasil->ipro_id; ?></td>
					<td><?php echo $hasil->ipro_title; ?></td>
					<td><a href="admin.php?page=ipro&action=addImg&myId=<?php echo $hasil->ipro_id; ?>">Go To Gallery</a></td>
					<td><a href="admin.php?page=ipro&action=edit&myId=<?php echo $hasil->ipro_id; ?>">Edit</a> | <a href="admin.php?page=ipro&action=delete&myId=<?php echo $hasil->ipro_id; ?>">Delete</a></td>
				</tr>
		<?php	} ?>
	</tbody>
		
	</table>
	<?php } ?>