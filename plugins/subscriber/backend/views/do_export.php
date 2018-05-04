<?php 
include_once( dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . DIRECTORY_SEPARATOR .'wp-load.php' );
function query_to_csv($filename, $attachment = false, $headers = true) {
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
		global $wpdb;
		$table = $wpdb->prefix."subscriber";
        $result = mysql_query("SELECT `name`,`email`,`status` FROM  $table ORDER BY subscriber_id DESC") or die( mysql_error() );
        
        if($headers) {
            $row = mysql_fetch_assoc($result);
            if($row) {
                fputcsv($fp, array_keys($row));
                mysql_data_seek($result, 0);
            }
        }
        
        while($row = mysql_fetch_assoc($result)) {
            fputcsv($fp, $row);
        }
        
        fclose($fp);
    }
	$date = new DateTime();
	$ts = $date->format("Y-m-d-G-i-s");
	$filename = "subscriber-list-$ts.csv";
    query_to_csv( $filename, true, true);
	