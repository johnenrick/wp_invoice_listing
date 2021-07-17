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
      'view_item' => __('View Restaurant'),
      'add_new_item' => __('Add New Restaurant'),
      'add_new' => __('Add New Restaurant'),
      'edit_item' => __('Edit Restaurant'),
      'update_item' => __('Update Restaurant'),
      'search_items' => __('Search Restaurants'),
      'not_found' => __('Restaurant Not found'),
      'not_found_in_trash' => __('Restaurant Not found'),
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