<?php

function retrieve_invoice($parameter){
  global $wpdb;
  $wpdb->show_errors();
  $invoiceSQLQuery = "
    from $wpdb->posts 
    left join $wpdb->postmeta AS invoice_status on invoice_status.post_id=$wpdb->posts.id AND invoice_status.meta_key='status' 
    left join $wpdb->postmeta AS retaurant on retaurant.post_id=$wpdb->posts.id AND retaurant.meta_key='restaurant'
    left join $wpdb->postmeta AS retaurant_name on retaurant_name.post_id=retaurant.meta_value AND retaurant_name.meta_key='name'
    where post_type='invoices' AND post_status='publish'
  ";
  if(isset($parameter['invoice_status_filter']) && $parameter['invoice_status_filter']){
    $invoiceStatusFilter = $parameter['invoice_status_filter'];
    $invoiceSQLQuery .= "AND $wpdb->postmeta.meta_value=$invoiceStatusFilter";
  }
  if(isset($parameter['search_filter']) && $parameter['search_filter']){
    $searchFilter = $parameter['search_filter'];
    $invoiceSQLQuery .= "AND ($wpdb->posts.ID='$searchFilter' OR retaurant_name.meta_value like '%$searchFilter%')";
  }
  $totalResult = $wpdb->get_var("select count(*) $invoiceSQLQuery"); // count before pagination
  /* Get Invoices */
  $offset = $parameter['offset'];
  $limit = $parameter['limit'];
  $invoices = $wpdb->get_results("select $wpdb->posts.* $invoiceSQLQuery LIMIT $limit OFFSET $offset", ARRAY_A); // invoices
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
  $postMetas = $invoiceIds !== '' ? $wpdb->get_results("select * from $wpdb->postmeta where post_id in ($invoiceIds)", ARRAY_A) : []; // post metas of invoices
  $restaurantIds = '';
  foreach($postMetas as $postMeta){
    $invoiceIndex = $invoiceIdIndexLookUp[$postMeta['post_id']];
    $invoice = $invoices[$invoiceIndex];
    $invoices[$invoiceIndex]['postmetas'][$postMeta['meta_key']] = $postMeta['meta_value'];
    if($postMeta['meta_key'] === 'restaurant'){
      if($restaurantIds !== ''){
        $restaurantIds .= ',';
      }
      $restaurantIds .= $postMeta['meta_value'];
    }
  }
  /* Get restaurants */
  $restaurants = [];
  $postMetas = $restaurantIds !== '' ? $wpdb->get_results("select * from $wpdb->postmeta where post_id in ($restaurantIds)", ARRAY_A) : []; // post metas of restaurants
  $logoIds = '';
  $logoIdRestaurantIdLookUp = [];
  foreach($postMetas as $postMeta){
    $restaurantId = $postMeta['post_id'];
    if(!isset($restaurants[$restaurantId])){ // post id is the restaurant id
      $restaurants[$restaurantId] = [];
    }
    $restaurants[$restaurantId][$postMeta['meta_key']] = $postMeta['meta_value'];
    if($postMeta['meta_key'] === 'logo'){
      $logoIdRestaurantIdLookUp[$postMeta['meta_value']] = $restaurantId;
      if($logoIds !== ''){
        $logoIds .= ',';
      }
      $logoIds .= $postMeta['meta_value'];
    }
  }
  /* Get restaurant photos */
  $restaurantLogos = $logoIds !== '' ? $wpdb->get_results("select * from $wpdb->posts where ID in ($logoIds)", ARRAY_A) : []; // logos
  foreach($restaurantLogos as $restaurantLogo){
    $restaurantId = $logoIdRestaurantIdLookUp[$restaurantLogo['ID']];
    $restaurants[$restaurantId]['logo_url'] = $restaurantLogo['guid'];
  }
  $terms = [];
  if(isset($parameter['include_terms'])){ // application status
    $terms = $wpdb->get_results("select $wpdb->term_taxonomy.taxonomy, $wpdb->term_taxonomy.term_id, $wpdb->terms.slug from $wpdb->term_taxonomy left join $wpdb->terms on $wpdb->terms.term_id=$wpdb->term_taxonomy.term_id where taxonomy='invoice-statuses'", ARRAY_A); // invoice status taxonomy
  }

  return wp_send_json([
    'invoices' => $invoices,
    'total_invoices' => $totalResult * 1,
    'terms' => $terms,
    'restaurants' => $restaurants
  ]);
}
