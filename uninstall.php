<?php
/*
    This file is part of ObjSpace CDN, a plugin for WordPress.

    ObjSpace CDN is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License v 3 for more details.

    https://www.gnu.org/licenses/gpl-3.0.html

*/

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit ();

// Deregister
    delete_option( 'obspacecdn_cdn' );
    delete_option( 'obspacecdn_settings' );
    delete_option( 'obspacecdn_importer' );

// Multisite
global $wpdb;
$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);
    if ($blogs) {
        foreach($blogs as $blog) {
            switch_to_blog($blog['blog_id']);
            	delete_option( 'obspacecdn_cdn' );
            	delete_option( 'obspacecdn_settings' );
            	delete_option( 'obspacecdn_importer' );
	        }
	    restore_current_blog();
    }