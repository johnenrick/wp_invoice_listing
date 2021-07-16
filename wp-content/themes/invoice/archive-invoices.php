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
			<table id="invoiceTable" class="table">
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
				</tbody>
			</table>
			<div id="prototypeContainer">
				<table>
					<tbody>
						<tr class="invoiceRow bg-white">
							<td class="text-center py-2 px-1"><input type="checkbox" /></td>
							<td class="invoiceIdColumn text-center py-2 px-1">#23212</td>
							<td class="restaurantNameColumn py-2 px-1"><img /> <span></span></td>
							<td class="statusColumn text-center py-2 px-1">
								<span class="badge badge-pill text-uppercase">Ongoing</span>
							</td>
							<td class="startDateColumn text-center py-2 px-1">16/08/2018</td>
							<td class="endDateColumn text-center py-2 px-1">16/08/2018</td>
							<td class="totalColumn text-right py-2 px-1">HK$2.99</td>
							<td class="feesColumn text-right py-2 px-1">HK$2.99</td>
							<td class="transferColumn  text-right py-2 px-1">HK$2.99</td>
							<td class="orderColumn text-right py-2 px-1">20</td>
							<td>Download</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</main><!-- #main -->
	<script >
		var $ = jQuery
		var restaurants = {}
		var loadedRestaurantIds = []
		var invoiceStatusTaxonomy = {} // the key is id
		function getInvoices(filter = null, offset = 0){
			var includeTerms = offset === 0
			$.ajax({
				type: 'GET',
				url: 'wp-json/myapi/v1/invoice/retrieve',
				data: {include_terms: includeTerms},
			}).done(function(response) {
				console.log('response', response)
				if(includeTerms){	
					response['terms'].forEach(function(term){
						invoiceStatusTaxonomy[term['term_id']] = term['slug']
					})
				}
				restaurants = {...restaurants, ...response['restaurants']}
				restaurants.forEach(restaurant => {
					loadedRestaurantIds.push(restaurant['ID'])
				})
				console.log('restaurants 1', restaurants)
				response['invoices'].forEach(invoice => {
					addInvoices(invoice)
				})
			})
		}
		function addInvoices(invoice){
			var invoiceId = invoice['ID'] 
			var retaurantName = 'Unknown'
			var retaurantLogo = 'Unknown'
			var status = 'application-status-pending'
			var startDate = '-'
			var endDate = '-'
			var total = 0 
			var fees = 0 
			var transfer = 0
			var orders = 0
			if(Object.keys(invoice['postmetas']).length){
				if(typeof invoice['postmetas']['restaurant'] !== 'undefined'){
					restaurantId = invoice['postmetas']['restaurant']
					restaurantName = restaurants[restaurantId]['name']
					restaurantLogo = restaurants[restaurantId]['logo']
				}
				if(typeof invoice['postmetas']['status'] !== 'undefined'){
					status = invoiceStatusTaxonomy[invoice['postmetas']['status']]
				}
				if(typeof invoice['postmetas']['start_date'] !== 'undefined'){
					startDate = invoice['postmetas']['start_date']
				}
				if(typeof invoice['postmetas']['end_date'] !== 'undefined'){
					endDate = invoice['postmetas']['end_date']
				}
				if(typeof invoice['postmetas']['total'] !== 'undefined'){
					total = invoice['postmetas']['total']
				}
				if(typeof invoice['postmetas']['fees'] !== 'undefined'){
					fees = invoice['postmetas']['fees']
				}
				if(typeof invoice['postmetas']['transfer'] !== 'undefined'){
					transfer = invoice['postmetas']['transfer']
				}
				if(typeof invoice['postmetas']['orders'] !== 'undefined'){
					orders = invoice['postmetas']['orders']
				}
				var newRow = $('#prototypeContainer .invoiceRow').clone();
				newRow.find('.invoiceIdColumn').text(invoiceId)
				newRow.find('.retaurantNameColumn img').attr('src', retaurantLogo)
				newRow.find('.retaurantNameColumn span').text(retaurantName)
				newRow.find('.startDateColumn').text(startDate)
				newRow.find('.endDateColumn').text(endDate)
				newRow.find('.totalColumn').text(total)
				newRow.find('.feesColumn').text(fees)
				newRow.find('.transferColumn').text(transfer)
				newRow.find('.ordersdColumn').text(orders)
				switch(status){
					case 'application-status-pending':
						newRow.find('.statusColumn .badge').addClass('badge-warning')
						break;
					case 'application-status-ongoing':
						newRow.find('.statusColumn .badge').addClass('badge-secondary')
						break;
					case 'application-status-verified':
						newRow.find('.statusColumn .badge').addClass('badge-success')
						break;
					case 'application-status-paid':
						newRow.find('.statusColumn .badge').addClass(['badge-white', 'font-weight-bold', 'text-success'])
						break;
				}
				$('#invoiceTable tbody').append(newRow)
				return true
			}else{
				 return false
			}
			
		}
		$(document).ready(function(){
			getInvoices()
		})
	</script>
<?php
get_sidebar();
get_footer();
?>

