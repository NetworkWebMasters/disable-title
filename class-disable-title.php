<?php

/*  Copyright 2012  Frank Staude  (email : frank@staude.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class disable_title {
    
    function __construct() {
        add_filter( 'the_title',        array ( 'disable_title', 'the_title'),10,2);
        add_action( 'admin_menu',       array ( 'disable_title', 'add_meta_box') );
        add_action( 'save_post',        array ( 'disable_title', 'save_meta') );
        add_action( 'plugins_loaded',   array ( 'disable_title', 'load_translations' ) );
    }
    
    function load_translations() {
        load_plugin_textdomain('disable-title', false, dirname( plugin_basename( __FILE__ )) . '/languages/'  ); 
    }
    
    function the_title( $title, $id) { 
        if (!is_admin() ) { // no title replacement in backend
            $page       = get_post_meta( $id, '_z8n-fs-disable-title-detail', true );
            $category   = get_post_meta( $id, '_z8n-fs-disable-title-category', true );
            $archive    = get_post_meta( $id, '_z8n-fs-disable-title-archive', true );
            $home       = get_post_meta( $id, '_z8n-fs-disable-title-home', true );

            if ( is_page() || is_single() ) {
                if ( $page == 1 ) {
                    return '';
                } else { 
                    return $title;
                }
            }
            if (is_category() ) {
                if ( $category == 1 ) {
                    return '';
                } else { 
                    return $title;
                }            
            } 
            if (is_archive() ) { 
                if ( $archive == 1 ) {
                    return '';
                } else { 
                    return $title;
                }            
            }
            if ( is_home() ) { 
                if ( $home == 1 ) {
                    return '';
                } else { 
                    return $title;
                }            
            }
        }
        return $title;
    }
    
    function add_meta_box() {
        add_meta_box( 'disable_title', __('Title settings', 'disable-title'), array ('disable_title', 'disable_title_metabox' ), 'post' );
        add_meta_box( 'disable_title', __('Title settings', 'disable-title'), array ('disable_title', 'disable_title_metabox' ), 'page' );
    }
 
    function disable_title_metabox($post) {
        $detail = get_post_meta( $post->ID, '_z8n-fs-disable-title-detail', true );
        $category = get_post_meta( $post->ID, '_z8n-fs-disable-title-category', true );
        $archive = get_post_meta( $post->ID, '_z8n-fs-disable-title-archive', true );
        $home = get_post_meta( $post->ID, '_z8n-fs-disable-title-home', true );
        ?>
        <input type="hidden" name="z8n-fs-disable-title-posts" value="1">
        <input id="z8n-fs-disable-title-home" type="checkbox" <?php if ( $home == 1 ) echo 'checked="checked"'; ?> name="z8n-fs-disable-title-home" value="1">
        <?php _e('Disable title on homepage','disable-title'); ?><br />
        <input id="z8n-fs-disable-title-detail" type="checkbox" <?php if ( $detail == 1 ) echo 'checked="checked"'; ?> name="z8n-fs-disable-title-detail" value="1">
        <?php _e('Disable title on page/post','disable-title'); ?><br />
        <input id="z8n-fs-disable-title-category" type="checkbox" <?php if ( $category == 1 ) echo 'checked="checked"'; ?> name="z8n-fs-disable-title-category" value="1">
        <?php _e('Disable title on category page','disable-title'); ?><br />
        <input id="z8n-fs-disable-title-archive" type="checkbox" <?php if ( $archive == 1 ) echo 'checked="checked"'; ?> name="z8n-fs-disable-title-archive" value="1">
        <?php _e('Disable title on archive page','disable-title'); ?><br />
        <?php
    }
 
    function save_meta( $post_id ) {
        if ( isset( $_POST[ 'z8n-fs-disable-title-posts' ] ) ) {
            $detail = $_POST['z8n-fs-disable-title-detail'] ? 1 : 0;
            $category = $_POST['z8n-fs-disable-title-category'] ? 1 : 0;
            $archive = $_POST['z8n-fs-disable-title-archive'] ? 1 : 0 ;
            $home = $_POST['z8n-fs-disable-title-home'] ? 1 : 0;

            // Update values
            update_post_meta($post_id, '_z8n-fs-disable-title-home', $home);
            update_post_meta($post_id, '_z8n-fs-disable-title-detail', $detail);
            update_post_meta($post_id, '_z8n-fs-disable-title-category', $category );
            update_post_meta($post_id, '_z8n-fs-disable-title-archive', $archive );
        }
    }
}

?>