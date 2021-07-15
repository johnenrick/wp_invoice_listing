<?php
include 'invoice.php';
include 'restaurant.php';
function custom_post_types(){
  register_post_type('invoices', getInvoiceCustomPostTypeProperty());
  register_post_type('restaurants', getRestaurantCustomPostTypeProperty());
}