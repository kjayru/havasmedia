<?php
// setup a dummy wpdb to prevent the default one from being instanciated
//$wpdb = new stdclass();

// include the base wpdb class to inherit from
//include ABSPATH . WPINC . "/wp-db.php";

class AppModel{

	function insert($table, $data, $format = null)
	{
		global $wpdb;
		$formats = $format = (array) $format;
		$fields = array_keys($data);
		$formatted_fields = array();
		$real_data = array();
		foreach ( $fields as $field ) {
			if ($data[$field]===null)
			{
				$formatted_fields[] = 'NULL';
				array_shift($formats);
				continue;
			}
			if ( !empty($format) )
				$form = ( $form = array_shift($formats) ) ? $form : $format[0];
			elseif ( isset($wpdb->field_types[$field]) )
				$form = $wpdb->field_types[$field];
			else
				$form = '%s';
			$formatted_fields[] = "'".$form."'";
			$real_data[] = $data[$field];
		}
		$sql = "INSERT INTO `$table` (`" . implode( '`,`', $fields ) . "`) VALUES (" . implode( ",", $formatted_fields ) . ")";
		$res = $wpdb->query( $wpdb->prepare( $sql, $real_data) );

		return $res;
	}

	function update($table, $data, $where, $format = null, $where_format = null)
	{
		global $wpdb;

		if ( !is_array( $where ) )
			return false;

		$formats = $format = (array) $format;
		$bits = $wheres = array();
		$fields = (array) array_keys($data);
		$real_data = array();
		foreach ( $fields as $field ) {
			if ($data[$field]===null)
			{
				$bits[] = "`$field` = NULL";
				array_shift($formats);
				continue;
			}
			if ( !empty($format) )
				$form = ( $form = array_shift($formats) ) ? $form : $format[0];
			elseif ( isset($wpdb->field_types[$field]) )
				$form = $wpdb->field_types[$field];
			else
				$form = '%s';
			$bits[] = "`$field` = {$form}";

			$real_data[] = $data[$field];
		}

		$where_formats = $where_format = (array) $where_format;
		$fields = (array) array_keys($where);
		foreach ( $fields as $field ) {
			if ( !empty($where_format) )
				$form = ( $form = array_shift($where_formats) ) ? $form : $where_format[0];
			elseif ( isset($wpdb->field_types[$field]) )
				$form = $wpdb->field_types[$field];
			else
				$form = '%s';
			$wheres[] = "`$field` = {$form}";
		}


		$sql = "UPDATE `$table` SET " . implode( ', ', $bits ) . ' WHERE ' . implode( ' AND ', $wheres );

		$res = $wpdb->query( $wpdb->prepare( $sql, array_merge($real_data, array_values($where))) );

		return $res->num_rows;
	}
}
?>