<?php
use Cake\Utility\Hash;
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal[]|\Cake\Collection\CollectionInterface $accJournals
 */
?>
<style>      
/* Define the classes to be used in the table */    
.stripe-1 {
  background-color: #ffffff !important;
}

.stripe-2 {
  background-color: #fce3bf !important;
}
</style>
<?= $this->Krs->breadcrumb('Accounting', 'Jurnal Umum', 'Tampilkan') ?>
<div class="panel panel-inverse">
    <div class="panel-body bg-gray-100">
    	<?= $this->Form->create($accJournal) ?>
	    <div class="row">
			<div class="col-lg-3"></div>
			<div class="col-lg-6">
				<div class="panel panel-success">
					<div class="panel-heading">
			            <h4 class="panel-title">Cari data..</h4>
				        <div class="panel-heading-btn">
				            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
				        </div>
			        </div>
			       <div class="panel-body">			       		
						<div class="form-group row m-b-15">
							<label class="col-form-label col-md-2">Tanggal</label>
							<div class="col-md-10">
								<?php
								//, 'value'=>'04-02-2022', 'value'=>'30-02-2022'
								echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control  filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Awal...', 'value' => $this->request->getQuery('filterDateFrom')), 'filterDatePrintEnd', array("class"=>"form-control  filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Akhir...', 'value' => $this->request->getQuery('filterDateEnd')), 's/d', 'resetDate');

								// echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control  filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Cetak...', 'value' => $this->request->getQuery('filterDateFrom')), 'filterDatePrintEnd', array("class"=>"form-control  filterDatePicker filterDate", 'readonly' => true, 'placeholder' => 'Tgl Cetak...', 'value' => $this->request->getQuery('filterDateEnd')), 's/d', 'resetDate');

								// echo $this->Krs->inputDateRange('filterDateFrom', array("class"=>"form-control filterDatePicker filterDate", 'id'=>'filterDateFrom', 'readonly' => true, 'placeholder' => 'Tgl Awal...'), 'filterDateEnd', array("class"=>"form-control filterDatePicker filterDate", 'id'=>'filterDateEnd', 'readonly' => true, 'placeholder' => 'Tgl Akhir...'), 's/d', 'resetDate');
								?>
							</div>
						</div>					
					</div>
					<div class="panel-footer text-right bg-orange">
						<span id="loading-image" id="loading-image"></span>
					    <?php
					    echo $this->Form->button('Tampilkan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-search']);
						?>
					</div>					
				</div>
				
			</div>
		</div>	
		<?php echo $this->Form->end();?>
		<div class="panel-body">
			<div class="portlet-body">
				<div class="table-responsive">
					<span id="dateTitle"></span>
					<div>
						<table class="table table-striped table-hover display" id="myTable">
							<thead>
								<tr>
									<th>No. Ref</th>
									<th>Tanggal</th>
									<th>Uraian<br>(Penanggung Jawab)</th>
									<th>Debit</th>
									<th>Kredit</th>
								</tr>								
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<tr>
					                <th colspan="3" style="text-align:right">Sub Total:</th>
					                <th style="text-align:right"></th>
					                <th style="text-align:right"></th>
					            </tr>
					            
					            <tr>
					                
                                    <th colspan="3" style="text-align:right">TOTAL:</th>
                                	<th style="text-align:right"><span id="grandTotalDebet"></span></th>
					                <th style="text-align:right"><span id="grandTotalCredit"></span></th>
					                
					            </tr>
					            <?php
                                    /*  <th style="text-align:right"></th>
                                    <th style="text-align:right"></th>  */
					                ?>
					        </tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


</div>
<?php
// var confirmTitle = "Apakah anda ingin menampilkan data tersebut ?";
    // var formAction = "<?php //echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'general_ledger_report'], ['fullBase' => true]); ";
 //    handleFormConfirmSubmitValid('AccJournalGeneralLedgerReportForm', 'btn-search', confirmTitle, formAction);
?>
<script type="text/javascript">
$(document).ready(function() {
	// var confirmTitle = "Apakah anda ingin menampilkan data tersebut ?";
    // var formAction = "<?php echo $this->Url->build(['controller'=>'acc_journals', 'action' => 'general_ledger_report'], ['fullBase' => true]); ?>";
    // handleFormConfirmSubmitValid('AccJournalGeneralLedgerReportForm', 'btn-search', confirmTitle, formAction);

	//handleDateRange('filterDatePicker', 'resetDate', 'filterDate', 'dd-mm-yyyy');

   	handleDateRange('filterDatePicker', 'resetDate', 'filterDate', 'dd-mm-yyyy');

	$('#loading-image').ajaxComplete(function() {
		$('#loading-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>" />').hide();
		
	});

	$(document).on("click", "#btn-search", function() {
	//{
		if (!$('#loading-image').attr('complete')) {
        	$('#loading-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').show();
		// $('#myTable').hide();
		}

		// var dateFrom=$('#filterDateFrom').val();
        // var dateEnd=$('#filterDateEnd').val();
		// console.log($('[name="filterDateFrom"]').val());
		// console.log($('[name="filterDatePrintEnd"]').val());
		var dateFrom = $('[name="filterDateFrom"]').val();
		var dateEnd = $('[name="filterDatePrintEnd"]').val();
        var dates = dateFrom+'^'+dateEnd;
        // alert(dates);
		if(dates.length != 0) {
			var urlDataTable = "<?php echo $this->Url->build(['prefix' => 'Acc', 'controller' => 'AccJournalLines', 'action' => 'getGeneralJournal?dateJournal='], ['fullBase' => true]); ?>"+dates;
			// alert(urlDataTable);
			// var urlDataTable = "<?php //echo $this->Html->url(array('event_id' => $uuid, 'controller'=>'acc_journal_lines', 'action' => 'get_general_journal?dateJournal=')); ?>"+dates;
			var oTable = $('#myTable').DataTable({
		        stripeClasses: ['stripe-1',
		                        'stripe-2'],
		        lengthMenu: [[ 15, 30, -1], [ 15, 30, "All"]], // page length options
		        bProcessing: true,
		        bDestroy: true,
		        bDeferRender: true,
		        iDisplayLength: 15,
		        fixedColumns: false,
		        sPaginationType: "full_numbers",
		        serverSide: true,
		        scrollY: 500,
		        scrollCollapse: true,
		        // sDom: "Blfrtip",
		        ajax: {
		            url: urlDataTable, // json datasource
		            type: "get",
		        },		        
		        "oLanguage": {
		            //"sLengthMenu": '<span class="dataTables_info">Tampilkan _MENU_ data per halaman</span>',
		            "sInfo": "Halaman _PAGE_ sampai _PAGES_, Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
		            "sEmptyTable": "Tidak ada data yang dapat ditampilkan",
		            "sInfoEmpty": "Tidak ada data yang dapat ditampilkan",
		            "sInfoFiltered": "(Ditemukan dari  total _MAX_ data)",
		            "infoEmpty": "Data tidak ditemukan",
		            "sZeroRecords": "Tidak ada data yang cocok",
		            "sSearch": '<span class="dataTables_info">Pencarian:</span>',
		            "sProcessing": "Sedang memproses data...",
		            "sLoadingRecords": "Sedang memuat data...",
		            "sUrl": "",
					"oPaginate": {
						"sFirst":    "Awal",
						"sPrevious": "Balik",
						"sNext":     "Lanjut",
						"sLast":     "Akhir"
					}
		        },
		        "initComplete":function(settings, json){
		        	var dateTitles = '<div class="alert alert-success fade show"><strong>Tanggal : ' + dateFrom + ' sampai ' + dateEnd +'</strong></div>';

		        	// var dateTitles = '<div class="note note-danger">Tanggal : ' + dateFrom + ' sampai ' + dateEnd+'</div>';
		        	$('#dateTitle').html(dateTitles).show();
		        	//alert(json.totalDebet);

		        	var numFormat = $.fn.dataTable.render.number( '.', ',', 2).display;
		        	var grandTotalDebet = json.totalDebet;
		        	var grandTotalCredit = json.totalCredit;		        	
		            
		            $("span#grandTotalDebet").html(numFormat(grandTotalDebet));
		            $("span#grandTotalCredit").html(numFormat(grandTotalCredit));

		            $('#loading-image').html('<i class="fa fa-spinner fa-pulse fa-fw"></i>').hide();
		            //$(this).find("span.grandTotalDebet").number(grandTotalDebet, 2, ",", ".");
		            // $(this).find("span.grandTotalDebet").val('asasf');
		            // $(this).find("span.grandTotalCredit").number(grandTotalCredit, 2, ",", ".");		            
		        },
		        "order": [[ 0, "desc" ], [ 1, "asc" ], [ 2, "asc" ]],
		        //{mData:"AccJournalLine.position", bSortable: false, bSearchable: false},
		        /*"columnDefs": [
		            {
		                "targets": [ 0 ],
		                "visible": false,
		                "searchable": false
		            },
		            {
		                "targets": [ 1 ],
		                "visible": false,
		                "searchable": false
		            },
		            {
		                "targets": [ 2 ],
		                "visible": false,
		                "searchable": false
		            },
		        ],*/
		        "aoColumns": [
		        	//{mData:"date"},
		        	{mData:"coaName"},
		        	{mData:"dateJournal", "sClass": "dt-left", bSearchable: false},        	
		        	{mData:"coaCustomerName", "sClass": "dt-left", bSearchable: false,
		        		render: function ( data, type, row ) {
				            return row.coaCustomerName + '<br>(<i>Penanggung Jawab: ' + row.recipientPayerName + '</i>)';
				        }
		        	},
		        	{mData:"debet", "sWidth": "120", "sClass": "dt-right", bSortable: false, bSearchable: false, "type": "numeric",
						mRender: $.fn.dataTable.render.number( '.', ',', 2, '' )
					},
					{mData:"credit", "sWidth": "120", "sClass": "dt-right", bSortable: false, bSearchable: false, "type": "numeric",
						mRender: $.fn.dataTable.render.number( '.', ',', 2, '' )
					},
		        ],
		        "footerCallback": function ( row, data, start, end, display ) {
		            var api = this.api(), data;
		 
		            // Remove the formatting to get integer data for summation
		            var intVal = function ( i ) {
		                return typeof i === 'string' ?
		                    i.replace(/[\$,]/g, '')*1 :
		                    typeof i === 'number' ?
		                        i : 0;
		            };
		            //var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, '£' ).display;
		            var numFormat = $.fn.dataTable.render.number( '.', ',', 2).display;

		            // alert(api.column( 3, { page:'current'} ).data());
		            var pageTotalDebet = api.column( 3, { page:'current'} ).data().reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		            var pageTotalCredit = api.column( 4, { page: 'current'} ).data().reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            // Update footer
		            //'Rp'+pageTotalDebet +' ( Rp'+ totalDebet +' total)'
		            // +' ( '+ totalDebet +' total)'
		            $( api.column( 3 ).footer() ).html(numFormat(pageTotalDebet));
		            $( api.column( 4 ).footer() ).html(numFormat(pageTotalCredit));
		        }
		        

	    	});
	    // {mData:"User.full_name",bSearchable:false}, // can't search virtual fields
	    $.fn.DataTable.ext.errMode = 'none';
	    $('#myTable').show();
	    //var oTable = $('#myTable').DataTable(xdefault);
		}
		
	});	

	$('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});
	$('input.auto').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000000'});
    $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});

    $("table tr #dr-diff").css("font-weight", "bold");
    $("table tr #cr-diff").css("font-weight", "bold");
});

//jQuery(document).ready(function() {
	
	// handleDateRange('filterDatePicker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
	
	
	
	//  else {
	// $('#myTable').hide();
	// }
	//$(document).on("click", "#btn-search", function() {
	// $('#myTable').hide();

	// if (!$('#loading-image').attr('complete')) {
		// $('#myTable').hide();
	// }
	// document.getElementById('btn-search').onclick = function() {
	// if(document.getElementById('btn-search').onclick == true) {
	//document.getElementById("btn-search").onclick = function()
	//if(document.getElementById('btn-search').clicked == true)

	/*const button = document.getElementById('btn-search');

	let elementClicked = false;

	button.addEventListener('click', function handleClick() {
	  // console.log('element clicked');

	  elementClicked = true;
	});
	// alert(elementClicked);
	if (elementClicked==true) {
		$('#myTable').show();
	} else {
		$('#myTable').hide();
	}*/
	
/*	if(document.getElementById('btn-search').onclick == true)

{

   alert("button was clicked");

} else {
	alert("gagag");
}*/

		
    //});
	// $('#myTable').hide();
	
	
//});
</script>
