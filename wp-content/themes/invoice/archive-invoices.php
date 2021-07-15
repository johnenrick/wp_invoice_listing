<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package invoice
 */

get_header();
?>
	<main id="primary" class="site-main p-4">
		
		<h1 class="page-header">Invoices</h1>
		<div class="d-flex align-items-center justify-content-space-between">
			<div class="text-uppercase">
				<span class="badge badge-primary2 mx-1">All</span>
				<span class="text-secondary mx-1">Ongoing</span>
				<span class="text-secondary mx-1">Verified</span>
				<span class="text-secondary mx-1">Pending</span>
			</div>
			<div></div>
			<button class="btn btn-warning">Mark As Paid</button>
		</div>
	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
