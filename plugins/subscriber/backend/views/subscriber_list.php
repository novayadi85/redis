<h1>Subscriber List</h1>
	<?php global $wpdb;?>
	<?php $fsearch = !empty($_GET['fsearch']) ? "WHERE email LIKE '%" . $_GET['fsearch'] . "%'" : ""; ?> 
	<?php 
		$table = $wpdb->prefix."subscriber";
		$alldata = $wpdb->get_results("SELECT * FROM  $table $fsearch ORDER BY subscriber_id ASC ");
	
	//$b = 1;
	$pages = empty($_GET['onpage']) ? 1 : $_GET['onpage'];
	$onPage = $pages - 1;
	$limit = 20;
	$link = "admin.php?page=subscriber&?selected=" . $_GET['selected'];
	$q_count = count($alldata);
	$c = 1; 
	
	$splitPage = 1;
	$splitLim = 10;
	$hasils = $wpdb->get_results("SELECT * FROM  $table $fsearch ORDER BY subscriber_id ASC LIMIT ". $onPage. " , $limit");
	//$pages = ($pages-1 < 1 ) ? 1 : $pages;
	$s = $limit*($pages-20)+1; 
	$startpoint = ($pages * $limit) - $limit;
	$ceil = ceil($q_count/$limit);
	//echo $ceil; die;
	if($ceil>$splitLim){
		 $splitPage = ceil($ceil/$splitLim);
	}

	$thisPageLink = $link; 
	$split = ceil($pages/$splitLim);
	$splitp = $split;
	$splitn = $split;

	$currentSplit = (($split-1)*$splitLim)+1;
	$loopSplit = $currentSplit+$splitLim;
	if($loopSplit> $ceil){
		$loopSplit = $ceil+1;
	}
	if($pages%$limit == 0){
		$splitn = $split+1;
	}else if($pages%$limit == 1){
		$splitp = $split-1;
	} ?>
	<?php if($_GET['action']=='filter'){
		/* echo '<pre>';
		print_r($_POST);
		echo '</pre>'; */
	}else if($_GET['action']=='detail'){ 
		include('subscriber_detail.php');
	}elseif($_GET['action'] == 'delete'){
		if(!empty($_GET['myId'])){
			mysql_query('DELETE FROM ' . $table . ' WHERE subscriber_id = "' . $_GET['myId'] . '"');
			$redirect = get_admin_url() . 'admin.php?page=' . $this->hook;
			print '<script type="text/javascript">document.location="' . $redirect . '";</script>';		
		}else{
			print 'Cant not process your request!';
		}
	
	}else{ 
	 ?>
		<div class="filter" style="float:right;">
			<form action="<?php print $link; ?>" method="GET" >
				<p><input type="text" value="<?php echo (empty($_GET['fsearch'])) ? "" : $_GET['fsearch']; ?>" name="fsearch" /><input type="submit" name="" id="search-submit" class="button" value="Search by Email"></p>
				<input type="hidden" name="page" value="<?php echo empty($_GET['page']) ? "" : $_GET['page']; ?>" />
				<input type="hidden" name="onpage" value="<?php echo empty($_GET['onpage']) ? "" : $_GET['onpage']; ?>" />
			</form>
		</div>
		<div class="pager top" style="float:left; padding:15px 0 0;">
			<?php if($q_count > $limit): ?>
				<?php if($split != 1) { ?>
					<a href="<?php echo $thisPageLink; ?>&onpage=<?php echo $currentSplit-$splitLim; ?>" class="none">&lt;&lt; </a>
				<?php } ?>
					<?php if($pages !=1 ): ?>
						<a href="<?php echo $thisPageLink; ?>&onpage=<?php echo ($pages-1 < 0) ? 0 : $pages-1 ; ?>" class="none">&laquo;</a>
					<?php endif; ?>
					<?php for($c=$currentSplit; $c<$loopSplit;$c++): ?>
						<?php if( $pages==$c ): ?>
							<strong><?php echo $c; ?></strong>
						<?php else: ?>
							<a href="<?php echo $thisPageLink; ?>&onpage=<?php echo $c; ?>"><?php echo $c; ?></a>
						<?php endif; ?>
					<?php endfor; ?>
					<?php if($pages != $ceil ): ?>
						<a href="<?php echo $thisPageLink; ?>&onpage=<?php echo $pages+1; ?>" class="none">&raquo; </a>
					<?php endif; ?>
				<?php if($split < $splitPage) { ?>
					<a href="<?php echo $thisPageLink; ?>&onpage=<?php echo $currentSplit+$splitLim; ?>" class="none">&gt;&gt;</a>
				<?php } ?>
			<?php endif; ?>
		</div>
		<?php if(count($hasils) > 0): ?>
			<table class="wp-list-table widefat plugins" cellspacing="0">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Status</th>
						<th>Phone</th>
						<th>Company</th>
						<th class="last">Action</th>
					</tr> 
				</thead>	
					
				<tbody>
					<?php	foreach ( $hasils as $hasil ) { ?>
						<tr>
							<td><a href="admin.php?page=subscriber&ctc=list&action=detail&myId=<?php echo $hasil->subscriber_id; ?>"><?php echo $hasil->subscriber_id; ?></a></td>
							<td><a href="admin.php?page=subscriber&ctc=list&action=detail&myId=<?php echo $hasil->subscriber_id; ?>"><?php echo $hasil->name; ?></a></td>
							<td><?php echo $hasil->email; ?></td>
							<td><?php echo ($hasil->status == 1) ? "Subscribe" : "Unsubscribe"; ?></td>
							<td><?php echo $hasil->phone; ?></td>
							<td><?php echo $hasil->company; ?></td>
							<td><a href="admin.php?page=subscriber&ctc=list&action=detail&myId=<?php echo $hasil->subscriber_id; ?>"><?php echo _e('View') ?></a></td>
						</tr>
					<?php	} ?>
				</tbody>
				
			</table>
		<?php else: ?>
			<h2>No result found.</h2>
		<?php endif; ?>
	<?php } ?>