<?php 

/**
 * Trigger this file on Plugin uninstall
 * 
 * @package datafeedrCustomPlugin
 */


 if(!defined('WP_UNINSTALL_PLUGIN'))
 {
    die;
 }

   delete_option('access_id');
   delete_option('access_key');

   global $wpdb;
   $dtfcTbleNetwork = $wpdb->prefix."dtfc_networks";
   $dtfcTbleMerchant = $wpdb->prefix."dtfc_merchants";
   $wpdb->query("DROP TABLE IF EXISTS $dtfcTbleNetwork, $dtfcTbleMerchant");
   
   // Delete any cached data created by the plugin
   wp_cache_flush();