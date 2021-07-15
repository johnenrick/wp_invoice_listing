<?php 
function getInvoiceStatusCustomTaxonomyProperty(){
  return [
    'hierarchical' => false,
    'labels' => [
      'name' => _x( 'Invoice Statuses', 'taxonomy general name' ),
      'singular_name' => _x( 'Invoice Status ', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Invoice Statuses' ),
      'popular_items' => __( 'Popular Invoice Statuses' ),
      'all_items' => __( 'All Invoice Statuses' ),
      'parent_item' => null,
      'parent_item_colon' => null,
      'edit_item' => __( 'Edit Invoice Status' ), 
      'update_item' => __( 'Update Invoice Status' ),
      'add_new_item' => __( 'Add New Invoice Status' ),
      'new_item_name' => __( 'New Invoice Status Name' ),
      'separate_items_with_commas' => __( 'Separate Invoice Status with commas' ),
      'add_or_remove_items' => __( 'Add or remove Invoice Statuses' ),
      'choose_from_most_used' => __( 'Choose from the most used Invoice Statuses' ),
      'menu_name' => __( 'Invoice Statuses' ),
    ],
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite' => array( 'slug' => 'invoice-status' ),
  ];
}
function getInvoiceStatusDefaultTerms(){
  return [
    [
      'name' => 'Pending',
      'description' => 'Application status is pending',
      'slug' => 'application-status-pending',
    ],
    [
      'name' => 'Ongoing',
      'description' => 'Application status is Ongoing',
      'slug' => 'application-status-ongoing',
    ],
    [
      'name' => 'Verified',
      'description' => 'Application status is verified',
      'slug' => 'application-status-verified',
    ],
    [
      'name' => 'Paid',
      'description' => 'Application status is paid',
      'slug' => 'application-status-paid',
    ]
    
  ];
}