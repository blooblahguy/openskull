<?php
	// options
	$intlen = 7; // 7 = 9,999,999 records
	$prefix = ATL_DB_PREFIX; // for ease of extensibility
	$hashtable = $prefix.'hashtable'; // what we use to cache this structure

	// here's our schema for the entire database
	// strikingly similar to wordpress. This is so that people can relate to it quickly
	// and also large tables are faster than many table with lots of joins
	$schema = array(
		// options
		$prefix.'options' => array(
			'name' => 'VARCHAR(255)'
			, 'value' => 'VARCHAR(255)'
		)

		// posts/pages/guides/etc
		, $prefix.'posts' => array(
			'post_title' => 'VARCHAR(255)'
			, 'post_type' => 'VARCHAR(255)'
			, 'post_name' => 'VARCHAR(255)'
			, 'post_parent' => "INT({$intlen}) UNSIGNED"
			, 'post_content' => 'LONGTEXT'
			, 'post_author' => "INT({$intlen}) UNSIGNED"
			, 'post_slug' => "VARCHAR(255)"
			, 'comment_count' => "INT({$intlen}) UNSIGNED"
		)
		, $prefix.'postmeta' => array(
			'post_id' => "INT({$intlen})"
			, 'meta_key' => 'VARCHAR(255)'
			, 'meta_value' => 'LONGTEXT'
		)

		// users
		, $prefix.'users' => array(
			'login' => 'VARCHAR(255)'
			, 'name' => 'VARCHAR(255)'
			, 'nickname' => 'VARCHAR(255)'
			, 'email' => 'VARCHAR(255)'
			, 'password' => 'VARCHAR(255)'
			, 'avatar' => 'VARCHAR(255)'
			, 'activation_key' => 'VARCHAR(255)'
		)
		, $prefix.'usermeta' => array(
			'user_id' => "INT({$intlen}) UNSIGNED"
			, 'meta_key' => 'VARCHAR(255)'
			, 'meta_value' => 'LONGTEXT'
		)

		// comments
		, $prefix.'comments' => array(
			'post_id' => "INT({$intlen})"
			, 'user_id' => "INT({$intlen}) UNSIGNED"
			, 'comment_content' => "LONGTEXT"
			, 'comment_karma' => "INT({$intlen})"
			, 'comment_parent' => "INT({$intlen}) UNSIGNED"
			, 'comment_type' => 'VARCHAR(255)'
		)
		, $prefix.'commentmeta' => array(
			'comment_id' => "INT({$intlen}) UNSIGNED"
			, 'meta_key' => 'VARCHAR(255)'
			, 'meta_value' => 'LONGTEXT'
		)

		// tags
		, $prefix.'tags' => array(
			'tag_name' => "VARCHAR(255)"
			, 'tag_type' => "VARCHAR(255)"
			, 'description' => "LONGTEXT"
			, 'parent_id' => "INT({$intlen}) UNSIGNED"
			, 'parent_objects' => "LONGTEXT"
		)
		, $prefix.'tagmeta' => array(
			'tag_id' => "INT({$intlen}) UNSIGNED"
			, 'parent_type' => "VARCHAR(255)"
			, 'parent_id' => "INT({$intlen}) UNSIGNED"
		)
	);

	/////////////////////////////////////////////////////////////////////////////////
	// Probably no need to edit below this line
	/////////////////////////////////////////////////////////////////////////////////
	// these all run once on site initalization, unless force = 1, then they are always present
	$defaults = array(
		$prefix.'options' => array(
			'entries' => array(
				array (
					'name' => 'site_title'
					, 'value' => ATL_DEFAULT_TITLE
				)
				, array (
					'name' => 'site_initialized'
					, 'value' => '1'
				)
			)
			, 'force' => 0
		)
	);








	//////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////
	// NOTHING HERE SHOULD BE EDITED
	//////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////

	// we do a hashtable for speed
	$qry = "CREATE TABLE IF NOT EXISTS `{$hashtable}`(
		`table_name` VARCHAR(100) NOT NULL
		, `change_hash` VARCHAR(100) NOT NULL
		, UNIQUE(table_name)
	) ";
	$db->query($qry) or die($db->error);

	// table change hashes (this is a big performance improvement)
	$hashes = $db->query("SELECT * FROM {$hashtable}");
	echo $db->error;
	$all = array();
	while ($t = $hashes->fetch_assoc()) {
		$all[$t['table_name']] = $t['change_hash'];
	}
	$hashes = $all;

	foreach ($schema as $table => $fields) {
		$change_hash = hashArray($schema[$table]);
		
		if (! isset($hashes[$table]) ) {
			// Create a new table
			$qry = "CREATE TABLE IF NOT EXISTS `$table` (id INT({$intlen}) UNSIGNED NOT NULL AUTO_INCREMENT, ";
			
			// loop and add custom fields
			foreach ($fields as $name => $type) {
				$type = explode(":",$type);
				$qry .= "`$name` $type[0] NOT NULL $type[1], ";
			}

			// always have these fields
			$qry .= "`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, ";
			$qry .= "`modified` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, ";
			$qry .= "UNIQUE KEY id (id))";

			// create this table with fields
			$db->query($qry) or die($db->error);
			
			// hash table
			$qry = "INSERT INTO {$hashtable} (table_name, change_hash) 
			SELECT '{$table}', '{$change_hash}' FROM DUAL
			WHERE NOT EXISTS (
				SELECT table_name FROM {$hashtable} WHERE table_name = '{$table}'
			) LIMIT 1";

			$db->query($qry) or die($db->error);

		} elseif ($hashes[$table] !== $change_hash) {
			// this is where we update table fields
			$all_fields = $db->query("SHOW COLUMNS FROM {$table} ");
			$all = array();
			while ($f = $all_fields->fetch_assoc()) {
				$all[$f['Field']] = $f;
			}
			$all_fields = $all;

			// loop and add custom fields
			foreach ($fields as $name => $type) {
				list($type, $extra) = explode(":", $type);

				// we found a new column
				if (! isset($all_fields[$name])) {
					$qry = "ALTER TABLE `$table` ADD `$name` $type $extra NOT NULL";
					$db->query($qry) or die($db->error);
				} else {
					// lets check that the field type and defaults are the same
					$db_type = strtolower($all_fields['Name']['Type']);
					$db_dfex = strtolower($all_fields['Name']['Default'] . $all_fields['Name']['Extra']);
					if (strtolower($type) !== $db_type || strtolower($extra) !== $db_dfex) {
						$qry = "ALTER TABLE `$table` MODIFY COLUMN `$name` $type NOT NULL $extra";
						$db->query($qry) or die($db->error);
					}
				}

				// shows that we matched up a local column with a database column
				unset($all_fields[$name]);
			}

			// anything left over should be dropped as a column
			foreach ($all_fields as $name => $values) {
				$qry = "ALTER TABLE `$table` drop column `$name` ";
				$db->query($qry) or die($db->error);
			}

			// now update change hash, so that we only hit this function when we've updated the $schema
			$qry = "UPDATE {$hashtable} SET change_hash = '{$change_hash}' WHERE table_name = '{$table}' ";
			$db->query($qry) or die($db->error);

			echo("Successfully updated to latest database schema");
		}
	} 

?>