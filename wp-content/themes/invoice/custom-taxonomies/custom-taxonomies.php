<?php
include 'invoice-status.php';
function custom_taxonomies(){
  register_taxonomy('invoice-statuses', ['invoices'], getInvoiceStatusCustomTaxonomyProperty());
  $invoiceStatuses = getInvoiceStatusDefaultTerms();
  insertPredfinedTerms('invoice-statuses', $invoiceStatuses);
}
function insertPredfinedTerms($taxonomy, $terms){
  foreach($terms as $term){
    wp_insert_term(
      $term['name'],
      $taxonomy,
      array(
        'description'=> $term['description'], 
        'slug' => $term['slug'], 
        'parent'=> isset($term['parent']) ? $term['parent'] : null
      )
    );
  }
}