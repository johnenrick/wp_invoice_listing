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
				<div class="bg-white border pl-1 mr-1 text-nowrap">
					<i class="fas fa-calendar"></i>
					<input id="dateRangeFilter" name="dates" type="text" class="  border-none" size="22" style="width: auto" />
				</div>
				<div class="border bg-white mr-1 pl-1 text-nowrap">
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
<?php
get_sidebar();
get_footer();
?>

