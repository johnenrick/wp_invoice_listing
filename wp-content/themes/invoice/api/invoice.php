<?php

function retrieve_invoice(){
  global $wpdb;
  $wpdb->show_errors();
  /* Get Invoices */
  $invoices = $wpdb->get_results("select * from $wpdb->posts where post_type='invoices'", ARRAY_A); // invoices
  $invoiceIds = '';
  $invoiceIdIndexLookUp = [];
  foreach($invoices as $index => $invoice){
    $invoiceIdIndexLookUp[$invoice['ID']] = $index;
    $invoices[$index]['postmetas'] = [];
    if($invoiceIds !== ''){
      $invoiceIds .= ',';
    }
    $invoiceIds .= $invoice['ID'];
  }
  $postMetas = $wpdb->get_results("select * from $wpdb->postmeta where post_id in ($invoiceIds)", ARRAY_A); // post metas of invoices
  $restaurantIds = '';
  foreach($postMetas as $postMeta){
    $postIndex = $invoiceIdIndexLookUp[$postMeta['post_id']];
    $post = $invoices[$postIndex];
    $post['postmetas'][$postMeta['meta_key']] = $postMeta['meta_value'];
    if($postMeta['meta_key'] === 'restaurant'){
      if($restaurantIds !== ''){
        $restaurantIds .= ',';
      }
      $restaurantIds .= $postMeta['meta_value'];
    }
  }
  /* Get restaurants */
  $retaurants = [];
  $postMetas = $wpdb->get_results("select * from $wpdb->postmeta where post_id in ($restaurantIds)", ARRAY_A); // post metas of restaurants
  $logoIds = '';
  $logoIdRestaurantIdLookUp = [];
  foreach($postMetas as $postMeta){
    $restaurantId = $postMeta['post_id'];
    if(!isset($retaurants[$restaurantId])){ // post id is the restaurant id
      $retaurants[$restaurantId] = [];
    }
    $retaurants[$restaurantId][$postMeta['meta_key']] = $postMeta['meta_value'];
    if($postMeta['meta_key'] === 'logo'){
      $logoIdRestaurantIdLookUp[$postMeta['meta_value']] = $restaurantId;
      if($logoIds !== ''){
        $logoIds .= ',';
      }
      $logoIds .= $postMeta['meta_value'];
    }
  }
  /* Get restaurant photos */
  $retaurantLogos = $wpdb->get_results("select * from $wpdb->posts where ID in ($logoIds)", ARRAY_A); // logos
  foreach($retaurantLogos as $retaurantLogo){
    $restaurantId = $logoIdRestaurantIdLookUp[$retaurantLogo['ID']];
    $retaurants[$restaurantId]['logo_url'] = $retaurantLogo['guid'];
  }
  return wp_send_json([
    'posts' => $invoices,
    'retaurants' => $retaurants
  ]);
}
