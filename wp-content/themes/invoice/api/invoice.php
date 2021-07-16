<?php

function retrieve_invoice(){
  $posts = get_posts([
    'post_type' => 'invoices'
  ]);
  return wp_send_json($posts);
}