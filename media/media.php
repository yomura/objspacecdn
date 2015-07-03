<?php

/*
    This file is part of ObjSpace CDN, a plugin for WordPress.

    ObjSpace CDN is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License v 3 for more details.

    https://www.gnu.org/licenses/gpl-3.0.html

*/

function obspacecdn_init( $dos ) {
    global $objspacecdn;
    require_once 'classes/objspacecdn.php';
    $objspacecdn = new obspacecdn_Services( __FILE__, $dos );
    
    // Sync existing media if called
    add_action( 'obspacecdn_media_sync', array( $objspacecdn, 'bulk_upload_to_objspacecdn') );
    add_action( 'import_start', array( $objspacecdn, 'import_start') );
    add_action( 'import_end', array( $objspacecdn, 'import_end') );
}

// If everything is set...
add_action( 'obspacecdn_init', 'obspacecdn_init' );

/**
 * @since 2.0
 * @access public
 * @param mixed $post_id Post ID of the attachment or null to use the loop
 * @param int $expires Secondes for the link to live
 * @return array
 */
function obspacecdn_get_secure_attachment_url( $post_id, $expires = 900, $operation = 'GET' ) {}