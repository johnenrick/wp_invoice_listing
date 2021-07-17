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
				<span class="statusFilter badge badge-primary2 mx-1 c-pointer" status="application-status-all" >All</span>
				<span class="statusFilter badge text-primary2 mx-1 c-pointer" status="application-status-ongoing" >Ongoing</span>
				<span class="statusFilter badge text-primary2 mx-1 c-pointer" status="application-status-verified" >Verified</span>
				<span class="statusFilter badge text-primary2 mx-1 c-pointer" status="application-status-pending" >Pending</span>
			</div>
			<div class="d-flex">
				<div class="bg-white border pl-1 mr-1">
					<i class="fas fa-calendar"></i>
					<input id="dateRangeFilter" name="dates" type="text" class="  border-none" size="22" style="width: auto" />
				</div>
				<div class="border bg-white mr-1 pl-1">
					<i class="fas fa-search"></i>
					<input id="searchBox" class="search-icon text-primary border-none" type="text" placeholder="Search" >
				</div>
				<button id="markAsPaid" class="btn btn-warning text-nowrap" >Mark As Paid</button>
			</div>
		</div>
		<div class="table-responsive">
			<table id="invoiceTable" class="table bg-white">
				<thead class="bg-white">
					<tr class="border-bottom">
						<th class="text-center"><input id="markAllInvoice" type="checkbox" value="all" /></th>
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
					<tr class="noResult"><td colspan="11" class="text-center">No Result :(</td></tr>
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
						<td class="text-center py-2 px-1"><input class="markInvoice" type="checkbox" /></td>
						<td class="invoiceIdColumn text-center py-2 px-1">#23212</td>
						<td class="restaurantNameColumn py-2 px-1 d-flex align-items-center"><img class="mr-1 rounded" style="width:25px; height: auto" /> <span></span></td>
						<td class="statusColumn text-center py-2 px-1">
							<span class="badge badge-pill text-uppercase">Ongoing</span>
						</td>
						<td class="startDateColumn text-center py-2 px-1">16/08/2018</td>
						<td class="endDateColumn text-center py-2 px-1">16/08/2018</td>
						<td class="totalColumn text-right py-2 px-1">HK$2.99</td>
						<td class="feesColumn text-right py-2 px-1">HK$2.99</td>
						<td class="transferColumn  text-right py-2 px-1">HK$2.99</td>
						<td class="ordersColumn text-right py-2 px-1">20</td>
						<td class="px-1 text-warning"><i class="fas fa-cloud-download-alt"></i></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div id="invoiceDetails" class="modal" style="display:none">
			<div class="modal-body p-2" style="width: 340px">
				<h3 class="my-1">Invoice Details <span class="status badge badge-warning">Verified</span></h3>
				<div class=" mb-1">
					Invoice ID: <strong class="invoiceId">#12736</strong> 
				</div>
				<div class="mb-1">
					Date: <strong class="startDate">12/07/2019</strong> - <strong class="endDate">12/08/2019</strong>
				</div>
				
				<div class=" d-flex align-items-center mb-1 ">
					<span class="mr-1">Restaurant:</span> 
					<img class="restaurantLogo mr-1" style="width: 25px; height: 25px"> 
					<strong class="restaurantName">Jade Phoe</strong>
				</div>
				<div class=" d-flex align-items-center justify-content-space-between mb-1">
					<span class="mr-1">Total:</span>
					<strong class="total float-right">HK$100.00</strong>
				</div>
				<div class=" d-flex align-items-center justify-content-space-between mb-1">
					<span class="mr-1">Fees:</span> 
					<strong class="fees float-right">HK$50.00</strong>
				</div>
				<div class=" d-flex align-items-center justify-content-space-between mb-1">
					<span class="mr-1">Transfer:</span> 
					<strong class="transfer float-right">HK$50.00</strong>
				</div>
				<div class=" d-flex align-items-center justify-content-space-between mb-1">
					<span class="mr-1">Orders:</span> 
					<strong class="orders float-right">HK$10.00</strong>
				</div>
				<div class="text-right mt-2">
					<button id="closeInvoiceDetails" class="btn bg-default">Close</button>
				</div>
			</div>
		</div>
	</main><!-- #main -->
	<script >
		var $ = jQuery
		var restaurants = {}
		var loadedRestaurantIds = []
		var invoiceStatusTaxonomy = {} // the key is id
		var invoiceStatusSlugIdLookUp = {} // the key is slug, value is status id
		var itemPerPage = 3
		var currentPage = 1
		var totalPages = 1
		var isLoading = false
		var currentStatusFilter = null
		var searchFilter = null
		var startDateFilter = null
		var endDateFilter = null
		function getInvoices(){
			if(isLoading){
				return false
			}
			isLoading = true
			offset = (currentPage - 1) * itemPerPage
			console.log('get invoices', offset)
			
			$('#invoiceTable tbody').empty()
			$('#invoiceTable .pagination').hide()
			$('#invoiceTable .noResult').hide()
			$('#invoiceTable .isLoading').show()
			var includeTerms = offset === 0
			$.ajax({
				type: 'GET',
				url: 'wp-json/myapi/v1/invoice/retrieve',
				data: { // request parameter
					include_terms: includeTerms,
					offset: offset,
					limit: itemPerPage,
					search_filter: searchFilter,
					start_date_filter: startDateFilter,
					end_date_filter: endDateFilter,
					invoice_status_filter: invoiceStatusSlugIdLookUp[currentStatusFilter]
				},
			}).done(function(response) {
				console.log('response', response)
				if(includeTerms){	
					response['terms'].forEach(function(term){
						invoiceStatusTaxonomy[term['term_id']] = term['slug']
						invoiceStatusSlugIdLookUp[term['slug']] = term['term_id']
					})
				}
				restaurants = {...restaurants, ...response['restaurants']}
				for(let restaurantIds in restaurants){
					loadedRestaurantIds.push(restaurantIds)
				}
				response['invoices'].forEach(invoice => {
					addInvoices(invoice)
				})
				if(response['total_invoices'] * 1){
					recreatePageButtons(response['total_invoices'] * 1)
					$('#invoiceTable .pagination').show()
				}else{
					$('#invoiceTable .noResult').show()
				}
				$('#invoiceTable tbody').show()
				$('#invoiceTable .isLoading').hide()
				isLoading = false
			})
			return true
		}
		function addInvoices(invoice){
			var invoiceId = invoice['ID'] 
			var restaurantName = 'Unknown'
			var restaurantLogo = 'Unknown'
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
					restaurantLogo = restaurants[restaurantId]['logo_url']
				}
				if(typeof invoice['postmetas']['status'] !== 'undefined'){
					status = invoiceStatusTaxonomy[invoice['postmetas']['status']]
				}
				if(typeof invoice['postmetas']['start_date'] !== 'undefined' && invoice['postmetas']['end_date'] !== ''){
					var day = (invoice['postmetas']['start_date']).slice(6)
					var month = (invoice['postmetas']['start_date']).slice(4,6)
					var year = (invoice['postmetas']['start_date']).slice(0,4)
					console.log(invoice['postmetas']['start_date'], `${day}-${month}-${year}`)
					startDate = `${day}-${month}-${year}`
				}
				if(typeof invoice['postmetas']['end_date'] !== 'undefined' && invoice['postmetas']['end_date'] !== ''){
					var day = (invoice['postmetas']['end_date']).slice(6)
					var month = (invoice['postmetas']['end_date']).slice(4,6)
					var year = (invoice['postmetas']['end_date']).slice(0,4)
					console.log(invoice['postmetas']['end_date'], `${day}-${month}-${year}`)
					endDate = `${day}-${month}-${year}`
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
				newRow.attr('invoice_id', invoiceId)
				newRow.find('.invoiceIdColumn').text('#' + invoiceId)
				newRow.find('.markInvoice').attr('value', invoiceId)
				newRow.find('.restaurantNameColumn img').attr('src', restaurantLogo)
				newRow.find('.restaurantNameColumn span').text(restaurantName)
				newRow.find('.startDateColumn').text(startDate)
				newRow.find('.endDateColumn').text(endDate)
				newRow.find('.totalColumn').text(total)
				newRow.find('.feesColumn').text(fees)
				newRow.find('.transferColumn').text(transfer)
				newRow.find('.ordersColumn').text(orders)
				switch(status){
					case 'application-status-pending':
						newRow.find('.statusColumn .badge').addClass('badge-warning')
						newRow.find('.statusColumn .badge').text('Pending')
						break;
					case 'application-status-ongoing':
						newRow.find('.statusColumn .badge').addClass('badge-secondary')
						newRow.find('.statusColumn .badge').text('Ongoing')
						break;
					case 'application-status-verified':
						newRow.find('.statusColumn .badge').addClass('badge-success')
						newRow.find('.statusColumn .badge').text('Verified')
						break;
					case 'application-status-paid':
						newRow.find('.statusColumn .badge').addClass(['badge-white', 'font-weight-bold', 'text-success'])
						newRow.find('.statusColumn .badge').text('Paid')
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
				if(page === -2){ // previous page
					if(currentPage > 1){
						--currentPage
					}
				}else if(page === -3){ // next page
					if(currentPage < totalPages){
						++currentPage
					}
				}else{
					currentPage = page
				}
				getInvoices()
				e.preventDefault
			})
		}
		function listenStatusFilter(){
			$('.statusFilter').click(function(){
				var status = $(this).attr('status')
				if(currentStatusFilter === status){
					return false
				}
				if(status === 'application-status-all'){
					currentStatusFilter = null
				}else{
					currentStatusFilter = status
				}
				currentPage = 1
				if(getInvoices()){
					$('.statusFilter').removeClass('badge-primary2')
					$(this).addClass('badge-primary2')
				}
			})
		}
		function listenSearchBox(){
			$('#searchBox').keyup(function(e){
				if(e.key === 'Enter'){
					searchFilter = $('#searchBox').val() === '' ? null : $('#searchBox').val()
					currentPage = 1
					getInvoices()
				}
			})
		}
		function listenDateFilter(){
			$('#dateRangeFilter').daterangepicker({
				locale: {
					format: 'DD/MM/YYYY',
					cancelLabel: 'Clear'
				}
			}, function(start, end, label) {
				startDateFilter = start.format('YYYY-MM-DD')
				endDateFilter = end.format('YYYY-MM-DD')
				currentPage = 1
				getInvoices()
			});
			$('#dateRangeFilter').val('');
			$('#dateRangeFilter').on('cancel.daterangepicker', function(ev, picker) { // clear date
				//do something, like clearing an input
				$('#dateRangeFilter').val('');
				startDateFilter = null
				endDateFilter = null
				currentPage = 1
				getInvoices()
			});
		}
		function listenInvoiceMark(){
			$('#markAllInvoice').click(function(){
				console.log($(this).prop('checked'), $('.markInvoice'))
				$('.markInvoice').attr('checked', $(this).prop('checked'));
			})
			$('#markAsPaid').click(function(){
				console.log($('.markInvoice:checked').length)
				var invoiceIds = []
				$('.markInvoice:checked').each(function(){
					invoiceIds.push($(this).val())
				})
				if(invoiceIds.length){
					markAsPaid(invoiceIds)
				}
			})
		}
		function listenOpenInvoice(){
			$('#invoiceTable').on('click', '.invoiceRow', function(){
				console.log($(this).attr('invoice_id'))
				$('#invoiceDetails').find('.invoiceId').text($(this).find('.invoiceIdColumn').text())
				$('#invoiceDetails').find('.restaurantLogo').attr('src', $(this).find('.restaurantNameColumn img').attr('src'))
				$('#invoiceDetails').find('.restaurantName').text($(this).find('.restaurantNameColumn').text())
				$('#invoiceDetails').find('.startDate').text($(this).find('.startDateColumn').text())
				$('#invoiceDetails').find('.endDate').text($(this).find('.endDateColumn').text())
				$('#invoiceDetails').find('.total').text($(this).find('.totalColumn').text())
				$('#invoiceDetails').find('.fees').text($(this).find('.feesColumn').text())
				$('#invoiceDetails').find('.transfer').text($(this).find('.transferColumn').text())
				$('#invoiceDetails').find('.orders').text($(this).find('.ordersColumn').text())
				$('#invoiceDetails').find('.status').text($(this).find('.statusColumn .badge').text())
				$('#invoiceDetails').find('.status').attr('class', $(this).find('.statusColumn .badge').attr('class')).addClass('status')
				$('#invoiceDetails').show();
			})
			$('#closeInvoiceDetails').click(function(){
				$('#invoiceDetails').hide();
			})
		}
		function markAsPaid(invoiceIds){
			isLoading = true
			$('#markAsPaid').attr('disabled', true)
			$.post('wp-json/myapi/v1/invoice/mark-as-paid', { // request parameter
					invoice_ids: invoiceIds
				}, function(response) {
					isLoading = false
					if(response['result']){
						invoiceIds.forEach(function(invoiceId){
							$('.invoiceRow[invoice_id="' + invoiceId + '"] .statusColumn .badge').removeClass(['badge-warning', 'badge-secondary', 'badge-success'])
							$('.invoiceRow[invoice_id="' + invoiceId + '"] .statusColumn .badge').addClass(['badge-white', 'font-weight-bold', 'text-success'])
							$('.invoiceRow[invoice_id="' + invoiceId + '"] .statusColumn .badge').text('Paid')
						})
					}
					$('.markInvoice').attr('checked', false);
					$('#markAsPaid').attr('disabled', false)
			})
		}
		$(document).ready(function(){
			getInvoices()
			listenPagination()
			listenStatusFilter()
			listenSearchBox()
			listenDateFilter()
			listenInvoiceMark()
			listenOpenInvoice()
		})
	</script>
<?php
get_sidebar();
get_footer();
?>

