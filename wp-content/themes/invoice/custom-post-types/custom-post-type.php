<?php
include 'invoice.php';
function custom_post_types(){
  register_post_type('invoices', getInvoiceCustomPostTypeProperty());
}