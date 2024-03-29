=== ObjSpace CDN ===
Contributors: Ipstenu
Tags: cloud, objspace, objspacecdn, cdn
Requires at least: 3.8
Tested up to: 4.2
Stable tag: 0.5.3
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Connect your WordPress install to your ObjSpace CDN for supercharged media deployment.

== Description ==

<em>Note: If you have issues with the plugin, please post in the support forums here.</em>

This plugin is a fork of https://wordpress.org/plugins/dreamspeed-cdn/ which has been adapted to work with Yomura's obj.space object store. For support please open a ticket via the client portal.

This plugin automatically copies images, videos, documents, and any other media added through WordPress' media uploader to ObjSpaceCDN. It then automatically replaces the URL to each media file with their respective ObjSpaceCDN URL or, if you have configured a CDN Alias, the respective custom URL. Image thumbnails are also copied to ObjSpaceCDN and delivered similarly.

Uploading files directly to ObjSpaceCDN is not supported by this plugin. They are uploaded to your server first, via the WordPress media uploader, then copied to ObjSpaceCDN.

Development happens on <a href="https://github.com/yomura/objspacecdn/">Github</a>. Issues and Pull Requests welcome.

= Known Conflicts =

* Broken Link Checker - This plugin will cause the "Migrate Exisiting Files" to fail.

= Credits =
<em>This plugin is a spork (fork and combination) of <a href="https://wordpress.org/plugins/amazon-s3-and-cloudfront/">Amazon S3 and Cloudfront</a> and <a href="https://github.com/deliciousbrains/wp-amazon-web-services">Amazon Web Services</a>, both by the awesome Brad Touesnard.</em>

== Installation ==

1. Sign up for <a href="http://www.obj.space/">ObjSpaceCDN</a>
1. Install and Activate the plugin
1. Fill in your Key and Secret Key

== Frequently asked questions ==

= General Questions =

<strong>What does it do?</strong>

ObjSpace CDN connects your WordPress site to the ObjSpace CDN, automatically pushing your media up to the CDN making it faster for your visitors.

<strong>Can I use this on Multisite?</strong>

Yes, but it has to be configured per site.

= Using the Plugin =

<strong>There are a lot of options, which ones do I want?</strong>

I would personally suggest checking the following:

* Copy files to ObjSpaceCDN as they are uploaded to the Media Library
* Point file URLs to ObjSpaceCDN/DNS Alias for files that have been copied to S3
* Serve files from obj.space

This will be the fastest

<strong>Do I have to manually push images?</strong>

Nope! New image uploads are copied first to your normal location, then sync'd up.

<strong>Can I force older images to be pushed?</strong>

Yes. Go to the CDN page and at the bottom is a section "Migrate Existing Files" - If there's a checkbox and a button, you have files to upload, so check the box and press the button.

The uploader runs in chunks per hour, since it has to upload <em>all</em> image sizes, as well as edit your posts. If you have over 20k images, it may NOT work right, however.

<strong>How long will it take to upload everything?</strong>

That depends on how many files you have. It averages uploading 20 images per-hour, though that can change based on how large the images are and how many resizes you use.

<strong>How can I check if an image is uploaded?</strong>

Go to the Media Library. There's a column called 'CDN' and that will have a checkmark if it's uploaded.

<strong>Do I have to edit my posts to use the new URLs?</strong>

Generally no. The Migrate Existing Files features will edit the posts for you.

<strong>It <em>edits</em> my posts? Why not use a filter?</strong?>

It does edit. It saves as a post revision, so you can roll back. But there's no filter because you may not have all your images uploaded to the cloud yet.

= Advanced Stuff =

<strong>Can I use SSL?</strong>

Yes. If you set your WordPress home/site URLs to https, then the plugin will auto-detect that you're on https and attempt to serve up the files securely. If for any reason that doesn't work, there's an option to activate force SSL on the settings page.

Keep in mind, you cannot use a custom CDN (like cdn.yourdomain.com) with HTTPs at this time, due to issues with certificates outside the control of this plugin.

<strong>If I wanted to push my existing images up manually, how do I do that?</strong>

First copy it all up via a desktop tool like Cyberduck. Once all the images are in the right place, do a search/replace on your content:

# Find `example.com/wp-content/uploads/`
# Replace with `bucketname.obj.space/wp-content/uploads/`

= Errors, Bugs, and Weird Stuff =

<strong>Why, when my URLs changed to the CDN, are they all broken images?</strong>

Make sure your CDN URL is working. If you have Cloudflare or something proxy-ish in front of your domain, you may need to edit DNS directly and point your CDN alias to ObjSpaceCDN.

<strong>I have a post and the links still are local, even though the images are on CDN. What gives?</strong>

This is a very rare case, and should no longer happen except in wild conditions where for some reason your OLD image URL doesn't match what WP thought it was. Sadly,  you'll have to search/replace them after the fact for post content. If this happens because of how a plugin is changing the visible domain URL (like WordPress MU Domain Mapping), please let me know which plugin and I'll put in a check to accommodate it as best I can.

Of note: Currently the official WordPress importers aren't standardized, so there's not 100% safe way to check.

<strong>Why aren't my images found?</strong>

Check if they're failing on the CDN alias, but they do work at the obj.space URL. If so, you somehow goofed your permissions. You have to go into the ObjSpaceCDN editor and set permissions from PRIVATE to PUBLIC. This happens usually because the bucket was private when you made it.

== Screenshots ==

1. ObjSpaceCDN Keys
2. ObjSpaceCDN Buckets
3. ObjSpaceCDN Bucket Settings
4. ObjSpace CDN Key Settings (empty)
5. ObjSpace CDN Key Settings (filled in)
6. ObjSpace CDN Configuration Settings
7. Media Library with CDN checkmarks
8. Migrate Existing Files section (on ObjSpace CDN Configuration page)

