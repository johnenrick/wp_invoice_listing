<?php
require "invoice.php";
add_action( 'rest_api_init', function () {
  register_rest_route( 'myapi/v1', '/invoice/retrieve', array(
    'methods' => 'GET',
    'callback' => 'retrieve_invoice',
  ) );
} );
