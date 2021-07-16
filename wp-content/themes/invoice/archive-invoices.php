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
		<div class="d-flex align-items-center justify-content-space-between mb-2">
			<div class="text-uppercase">
				<span class="badge badge-primary2 mx-1">All</span>
				<span class="text-primary2 mx-1">Ongoing</span>
				<span class="text-primary2 mx-1">Verified</span>
				<span class="text-primary2 mx-1">Pending</span>
			</div>
			<div></div>
			<button class="btn btn-warning">Mark As Paid</button>
		</div>
		<div>
			<table class="table">
				<thead class="bg-white">
					<tr >
						<th class="text-center"><input type="checkbox" /></th>
						<th class="text-center">ID</th>
						<th>Restaurant</th>
						<th>Status</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Total</th>
						<th>Fees</th>
						<th>Transfer</th>
						<th>Orders</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-center py-2 px-1"><input type="checkbox" /></td>
						<td class="text-center py-2 px-1">#23212</td>
						<td class="py-2 px-1">Jade Phoenix Buffet</td>
						<td class="text-center py-2 px-1"><span class="badge badge-pill badge-secondary text-uppercase">Ongoing</span></td>
						<td class="text-center py-2 px-1">16/08/2018</td>
						<td class="text-center py-2 px-1">16/08/2018</td>
						<td class="text-right py-2 px-1">HK$2.99</td>
						<td class="text-right py-2 px-1">HK$2.99</td>
						<td class="text-right py-2 px-1">HK$2.99</td>
						<td class="text-right py-2 px-1">20</td>
						<td>Download</td>
					</tr>
				</tbody>
			</table>
		</div>
	</main><!-- #main -->
	<script >
		var $ = jQuery
		function getInvoices(filter = null, offset = 0){
			$.ajax({
				type: 'GET',
				url: 'wp-json/myapi/v1/invoice/retrieve',
				data: { },
			}).done(function(response) {
				// Do other stuff			
			})
		}
		$(document).ready(function(){
			getInvoices()
		})
	</script>
<?php
get_sidebar();
get_footer();
?>

