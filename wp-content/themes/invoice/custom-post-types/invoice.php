<?php 
function getInvoiceCustomPostTypeProperty(){
  return [
    'label' => __('Invoices'),
    'description' => __('Invoice listing of customer orders'),
    'labels' => [
      'name' => __( 'Invoices' ),
      'singular_name' => __('Invoice'),
      'menu_name' => __('Invoices'),
      'parent_item_colon' => __('Parent Invoice'),
      'all_items' => __('All Invoices'),
      'view_item' => __('All Invoices'),
      'add_new_item' => __('All Invoices'),
      'add_new' => __('All Invoices'),
      'edit_item' => __('All Invoices'),
      'update_item' => __('All Invoices'),
      'search_items' => __('All Invoices'),
      'not_found' => __('All Invoices'),
      'not_found_in_trash' => __('All Invoices'),
    ],
    'supports' => [
      'title',
      'author', 
      'thumbnail', 
      'comments', 
      'revisions', 
      'custom-fields'
    ],
    'taxonomies' => ['status'],
    'hierarchical' => false,
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true,
    'menu_position' => 5,
    'can_export' => true,
    'has_archive' => true,
    'exclude_from_search' => false,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'show_in_rest' => true,
  ];
}