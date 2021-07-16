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
		<div class="table-responsive">
			<table id="invoiceTable" class="table bg-white">
				<thead class="bg-white">
					<tr class="border-bottom">
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
				<tfoot class="">
					<tr class="isLoading"><td colspan="11" class="text-center">Please wait...</td></tr>
					<tr class="pagination ">
						<td colspan="2" class="p-1">
							<small>Page <span class="currentPage"></span> of <span class="totaResults"></span></small>
						</td>
						<td colspan="9" class="text-center p-1">
							<div class="d-flex justify-content-end">
								<button class="btn btn-sm btn-default pageButton" page="-2"><</button>
								<div class="pageButtons"></div>
								<button class="btn btn-sm btn-default pageButton" page="-3">></button>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
		<div id="prototypeContainer">
				<table>
					<tbody>
						<tr class="invoiceRow c-pointer border-bottom hover-shadow">
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
	</main><!-- #main -->
	<script >
		var $ = jQuery
		var restaurants = {}
		var loadedRestaurantIds = []
		var invoiceStatusTaxonomy = {} // the key is id
		var itemPerPage = 3
		var currentPage = 1
		var totalPages = 1;
		function getInvoices(offset = 0){
			console.log('get invoices', offset)
			$('#invoiceTable tbody').empty()
			$('#invoiceTable .pagination').hide()
			$('#invoiceTable .isLoading').show()
			var includeTerms = offset === 0
			$.ajax({
				type: 'GET',
				url: 'wp-json/myapi/v1/invoice/retrieve',
				data: { // request parameter
					include_terms: includeTerms,
					offset: offset,
					limit: itemPerPage,
				},
			}).done(function(response) {
				console.log('response', response)
				if(includeTerms){	
					response['terms'].forEach(function(term){
						invoiceStatusTaxonomy[term['term_id']] = term['slug']
					})
				}
				restaurants = {...restaurants, ...response['restaurants']}
				for(let restaurantIds in restaurants){
					loadedRestaurantIds.push(restaurantIds)
				}
				response['invoices'].forEach(invoice => {
					addInvoices(invoice)
				})
				recreatePageButtons(response['total_invoices'])
				$('#invoiceTable tbody').show()
				$('#invoiceTable .pagination').show()
				$('#invoiceTable .isLoading').hide()
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
				newRow.find('.invoiceIdColumn').text('#' + invoiceId)
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
		function recreatePageButtons(totalResults){
			$('#invoiceTable tfoot .pageButtons').empty()
			totalPages = Math.ceil(totalResults / itemPerPage)
			$('#invoiceTable tfoot .pagination .totaResults').text(totalPages)
			$('#invoiceTable tfoot .pagination .currentPage').text(currentPage)
			for(let page = 1; page <= totalPages; page++){
				$('#invoiceTable tfoot .pageButtons').append(`<button class="btn btn-sm btn-default rounded-none pageButton ${(currentPage === page ? 'text-black' : 'text-primary2')}" page="${page}">${page}</button>`)
			}
			
		}
		function listenPagination(){
			$('.pagination').on('click', '.pageButton', function(e){
				var page = $(this).attr('page') * 1
				if(page === -2){ // previous
					if(currentPage > 1){
						--currentPage
					}
				}else if(page === -3){ // next
					if(currentPage < totalPages){
						++currentPage
					}
				}else{
					currentPage = page
				}
				getInvoices((currentPage - 1) * itemPerPage)
				e.preventDefault
			})
		}
		$(document).ready(function(){
			getInvoices()
			listenPagination()
		})
	</script>
<?php
get_sidebar();
get_footer();
?>

