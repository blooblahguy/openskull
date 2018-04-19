<?php 
	$qry = "SELECT 
		entries.* 
	FROM atl_posts entries 
	LEFT JOIN atl_users ON atl_users.id = entries.post_author
	WHERE entries.post_type = 'entry' 
	";
	$entries = $db->query($qry);
	if ($entries->num_rows == 0) { ?>
		<div class="message error">There is nothing here yet. </div>
	<? }
	echo $db->error;
?>
<div class="entry_table os-table">
	<div class="os-thead row">
		<div class="os pad10">Name</div>
		<div class="os pad10">Phone</div>
		<div class="os pad10">Email</div>
		<div class="os pad10">Log</div>
		<div class="os pad10">Assigned</div>
		<div class="os pad10">Status</div>
		<div class="os pad10">Interest</div>
	</div>
	<div class="os-tbody">
		<? while ($entry = $entries->fetch_assoc()) { ?>
			<div class="os-tr row">
				<div class="col"></div>
				<div class="col"></div>
				<div class="col"></div>
				<div class="col"></div>
				<div class="col"></div>
				<div class="col"></div>
				<div class="col"></div>
			</div>
		<? } ?>
	</div>
</div>