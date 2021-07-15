<?php 
function getRestaurantCustomPostTypeProperty(){
  return [
    'label' => __('Restaurants'),
    'description' => __('Restaurant listing of customer orders'),
    'labels' => [
      'name' => __( 'Restaurants' ),
      'singular_name' => __('Restaurant'),
      'menu_name' => __('Restaurants'),
      'parent_item_colon' => __('Parent Restaurant'),
      'all_items' => __('All Restaurants'),
      'view_item' => __('All Restaurants'),
      'add_new_item' => __('All Restaurants'),
      'add_new' => __('All Restaurants'),
      'edit_item' => __('All Restaurants'),
      'update_item' => __('All Restaurants'),
      'search_items' => __('All Restaurants'),
      'not_found' => __('All Restaurants'),
      'not_found_in_trash' => __('All Restaurants'),
    ],
    'supports' => [
      'title',
      'thumbnail', 
      'comments', 
      'revisions', 
      'custom-fields'
    ],
    'taxonomies' => [],
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