<?php

/*
    This file is part of ObjSpace CDN, a plugin for WordPress.

    ObjSpace CDN is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License v 3 for more details.

    https://www.gnu.org/licenses/gpl-3.0.html

*/

?>

<div class="objspacecdn-content objspacecdn-settings">

<?php

$buckets = $this->get_buckets();

if ( is_wp_error( $buckets ) ) {
	?>
	<div class="error">
		<p>
			<?php _e( 'Error retrieving a list of your buckets from ObjSpaceCDN:', 'objspacecdn' ); ?>
			<?php echo $buckets->get_error_message(); ?>
		</p>
	</div>
	<?php
}

if ( isset( $_GET['updated'] ) ) {
	?>
	<div class="updated">
			<p><div class="dashicons dashicons-yes"></div> <?php _e( 'Settings saved.', 'objspacecdn' ); ?></p>
	</div>
	<?php
} 

if ( isset( $_GET['migrated'] ) ) {
	?>
	<div class="updated">
			<p><div class="dashicons dashicons-info"></div> <?php _e( 'Existing files migrating.', 'objspacecdn' ); ?></p>
	</div>
	<?php
}

if (isset( $_GET['error'] ) ) {
	?>
	<div class="error">
			<p><div class="dashicons dashicons-no"></div> <?php _e( 'Warning. You cannot migrate existing files without that checkbox.', 'objspacecdn' ); ?></p>
	</div>
	<?php
}

?>

<form method="post">
<input type="hidden" name="action" value="save" />
<?php wp_nonce_field( 'objspacecdn-save-settings' ) ?>

<table class="form-table">
<tr valign="top">
	<td>
		<h3><?php _e( 'Bucket and Path Settings', 'objspacecdn' ); ?></h3>
		
		<p><?php _e( 'Select which bucket to use for uploading your media. You should not change this once set, as it will break any existing CDN uploads.', 'objspacecdn' ); ?></p>

		<p><select name="bucket" class="bucket">
		<option value="">-- <?php _e( 'Select a Bucket', 'objspacecdn' ); ?> --</option>
		<?php if ( is_array( $buckets ) ) foreach ( $buckets as $bucket ): ?>
		    <option value="<?php echo esc_attr( $bucket['Name'] ); ?>" <?php echo $bucket['Name'] == $this->get_setting( 'bucket' ) ? 'selected="selected"' : ''; ?>><?php echo esc_html( $bucket['Name'] ); ?></option>
		<?php endforeach;?>
		<option value="new"><?php _e( 'Create a new bucket...', 'objspacecdn' ); ?></option>
		</select></p>

		<p><input type="checkbox" name="expires" value="1" id="expires" <?php echo $this->get_setting( 'expires' ) ? 'checked="checked" ' : ''; ?> />
		<label for="expires"> <?php printf( __( 'Set a <a href="%s" target="_blank">far future HTTP expiration header</a> for uploaded files <em>(recommended)</em>', 'objspacecdn' ), 'http://developer.yahoo.com/performance/rules.html#expires' ); ?></label></p>
	</td>
</tr>

<tr valign="top">
	<td>
		<p><?php _e( 'Determine the name of your folder structure for your media. At this time, you cannot remove the year or month in order to prevent file-name collisions. If you already have folders (aka objects) in your bucket, please make sure to select a new location.', 'objspacecdn' ); ?></p>
		<p><label><?php _e( 'Object Path:', 'objspacecdn' ); ?></label>
		<input type="text" name="object-prefix" value="<?php echo esc_attr( $this->get_setting( 'object-prefix' ) ); ?>" size="30" />
		<label><?php echo trailingslashit( $this->get_dynamic_prefix() ); ?></label></p>
		<p class="description"><?php _e( 'The default is <code>wp-content/uploads/</code> (or <code>wp-content/uploads/site/#/</code> for Multisite).', 'objspacecdn' ); ?></p>
	</td>
</tr>

<tr valign="top">
	<td>
		<h3><?php _e( 'Plugin Options', 'objspacecdn' ); ?></h3>

		<input type="checkbox" name="copy-to-s3" value="1" id="copy-to-s3" <?php echo $this->get_setting( 'copy-to-s3' ) ? 'checked="checked" ' : ''; ?> />
		<label for="copy-to-s3"> <?php _e( 'Copy files to ObjSpaceCDN as they are uploaded to the Media Library <em>(recommended)</em>', 'objspacecdn' ); ?></label>
		<br />
		<input type="checkbox" name="serve-from-s3" value="1" id="serve-from-s3" <?php echo $this->get_setting( 'serve-from-s3' ) ? 'checked="checked" ' : ''; ?> />
		<label for="serve-from-s3"> <?php _e( 'Point file URLs to ObjSpaceCDN/DNS Alias for files that have been copied to S3 <em>(recommended - can be used with dream.io below)</em>', 'objspacecdn' ); ?></label>
		<br />
		<input type="checkbox" name="fullspeed" value="1" id="fullspeed" <?php echo $this->get_setting( 'fullspeed' ) ? 'checked="checked" ' : ''; ?> />
		<label for="fullspeed"> <?php _e( 'Serve files from dream.io <em>(recommended & fastest)</em>', 'objspacecdn' ); ?></label>
		<br />
		<input type="checkbox" name="force-ssl" value="1" id="force-ssl" <?php echo $this->get_setting( 'force-ssl' ) ? 'checked="checked" ' : ''; ?> />
		<label for="force-ssl"> <?php _e( 'Always serve files over https (SSL) <em>(slowest - overrides CDN alias and dream.io)</em>', 'objspacecdn' ); ?></label>
		<br />

<!--
		<input type="checkbox" name="hidpi-images" value="1" id="hidpi-images" <?php echo $this->get_setting( 'hidpi-images' ) ? 'checked="checked" ' : ''; ?> />
		<label for="hidpi-images"> <?php _e( 'Copy any HiDPI (@2x) images to CDN (works with WP Retina 2x plugin)', 'objspacecdn' ); ?></label>
-->
	</td>
</tr>

<tr valign="top">
	<td>
		<h3><?php _e( 'CDN Path Settings', 'objspacecdn' ); ?></h3>
		
		<p><?php _e( 'If you use an alias for your CDN (like http://cdn.example.com) then you can tell ObjSpaceCDN to use that instead of the default http://obj.space/bucketname. Both URLs will always work, but pretty CDN is pretty.', 'objspacecdn' ); ?></p>
	
		<label><?php _e( 'Domain Name:', 'objspacecdn' ); ?></label> <br />
			<?php 
				if (is_ssl()) {
						?> https:// <?php
				} else {
						?> http:// <?php
				} 
			?>
		<input type="text" name="cloudfront" value="<?php echo esc_attr( $this->get_setting( 'cloudfront' ) ); ?>" size="50" />
		<p class="description"><?php _e( 'Leave blank if you meet any of the following conditions:', 'objspacecdn' ); ?></p>
		
		<p class="description">&bull; <?php _e( 'You aren&#8217;t using a DNS alias.', 'objspacecdn' ); ?>
		<br />&bull; <?php _e( 'You are using SSL.', 'objspacecdn' ); ?>
		</p>

	</td>
</tr>



<tr valign="top">
	<td>
		<button type="submit" class="button button-primary"><?php _e( 'Save Changes', 'objspacecdn' ); ?></button>
	</td>
</tr>
</table>

</form>

<?php 
	$all_attachments = wp_count_attachments();

	if ( $this->get_setting( 'copy-to-s3' ) == 1 ) {
	?><h3><?php _e( 'Migrate Existing Files', 'objspacecdn' ); ?></h3><?php

	if ( count($this->get_attachment_without_obspacecdn_info()) != 0 ) {
		?>
		<form method="post">
		<input type="hidden" name="action" value="migrate" />
		<?php wp_nonce_field( 'objspacecdn-save-settings' ) ?>
		
		<table class="form-table">
		<tr valign="top">
			<td>
				<p><?php _e( 'If want to upload existing images, check the following box and they will begin to upload to ObjSpaceCDN. If you have a high number of images, the uploader will run as long as it can, and then <em>schedule</em> a retry in an hour. To see if your images are uploaded to the Cloud, check the <a href="upload.php">Media Library</a>. Any item with a green checkmark under the CDN column is uploaded (and the red X means it\'s not). The uploader will automatically rerun itself on your images, no need to re-run!', 'objspacecdn' ); ?></p>
		
				<p><input type="checkbox" name="migrate-to-objspacecdn" value="1" id="migrate-to-objspacecdn" />
				<label for="migrate-to-objspacecdn"> <?php printf( __( '%d file(s) can be migrated to ObjSpaceCDN.', 'objspacecdn' ), count($this->get_attachment_without_obspacecdn_info()) ); ?></label>
				</p>		
			</td>
		</tr>
		<tr valign="top">
			<td>
				<button type="submit" class="button button-secondary"><?php _e( '<div class="dashicons dashicons-upload"></div> Upload Existing Media', 'objspacecdn' ); ?></button>
			</td>
		</tr>
		</table>
		</form>		  
	<?php } else { ?>
		<p><div class="dashicons dashicons-smiley"></div> <?php _e( 'All your media files are uploaded to the cloud! Celebrate!', 'objspacecdn' ); ?> </p>
	<?php }
}