<?php
// $types = array( 'png', 'jpg', 'jpeg', 'gif' );

// unlink(".htaccess");

if ( $handle = opendir('/') ) {
    while ( $entry = readdir( $handle ) ) {
        $ext = strtolower( pathinfo( $entry, PATHINFO_EXTENSION) );
        // if( in_array( $ext, $types ) )
        echo $entry."<br>";
    }
    closedir($handle);
}
