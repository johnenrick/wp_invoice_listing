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
      'view_item' => __('View Invoice'),
      'add_new_item' => __('Add New Invoice'),
      'add_new' => __('Add Invoice'),
      'edit_item' => __('Edit Invoice'),
      'update_item' => __('Update Invoice'),
      'search_items' => __('Search Invoices'),
      'not_found' => __('Invoice Not Found'),
      'not_found_in_trash' => __('Invoice Not Found In Trash'),
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