<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal $accJournal
 */
use Cake\Utility\Hash;

$dataChild = $this->Html->link('Journal', ['action' => 'index'], ['full_base'=>true]);
$dataDate = (empty($accJournal->date)) ? '' : $this->Krs->fDate($accJournal->date, 'd-m-Y');
$dataDateOld = (empty($accJournal->date)) ? '' : $this->Krs->fDate($accJournal->date, 'Y-m-d');
$dataJournalType = $accJournal->journal_type;
$accJournalLineManifestId = 0;
//$accJournalLineManifestId = (!empty($accJournalLine[0]['manifest_id'])) ? $accJournalLine[0]['manifest_id'] : 0;
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

<?= $this->Krs->breadcrumb('Accounting', $dataChild, 'Ubah') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Perincian</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <?= $this->Form->create($accJournal) ?>
    <?php // nav-tabs-inverse ?>
    <div class="panel-body bg-warning-transparent-4">
        <div class="form-group row m-b-15">            
            <label class="col-form-label col-md-2">Cabang</label>
            <div class="col-md-4">
                <div class="input-group">
                    <?php
                    echo $this->Form->input('branch_id', ['empty'=>false, 'options'=>$data['getListBranch'], 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'autofocus'=>'autofocus', 'type'=>'select']);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Kode</label>
            <div class="col-md-4">
            <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);
            // echo $this->Form->control('branch_id', ['type' => 'hidden', 'value' => 1]);
            echo $this->Form->input('codes', ['class' => 'form-control-plaintext', 'placeholder'=>'No..', 'value'=>$accJournal['code'], 'readonly ' => true]);
            echo $this->Form->control('code_revisions', ['type' => 'hidden', 'value' => $accJournal->code_revision]);
            echo $this->Form->control('date_journal_old', ['type' => 'hidden', 'value' => $dataDateOld]);
            echo $this->Form->control('totalLine', ['type' => 'hidden', 'id' => 'totalLine']);
            ?>
            </div>
            <label class="col-form-label col-md-2">Jenis Jurnal</label>
            <div class="col-md-2">
                <div class="input-group">
                    <?php
                    echo $this->Form->input('journal_type', ['empty'=>false, 'options'=>$this->Krs->journalType(), 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'autofocus'=>'autofocus', 'type'=>'select', 'id'=>'select-populate', 'default'=>$dataJournalType]);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row m-b-15">            
            <label class="col-form-label col-md-2">Tanggal</label>
            <div class="col-md-4">
                <div class="input-group" id="default-daterange">
                    <?php
                    echo $this->Form->input('date_journal', array('id' => 'datepicker-autoClose', 'error' => false, 'class'=>'form-control', 'placeholder' => 'Tanggal..', 'value'=>$dataDate));
                    ?>
                    <span class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </span>
                </div>
            </div>
            <label class="col-form-label col-md-2">Penanggung Jawab</label>
            <div class="col-md-4">
                <div class="input-group">
                    <?php
                    echo $this->Form->input('recipient_payer_name', ['class'=>'form-control', 'placeholder'=>'Penanggung Jawab..', 'value'=>$accJournal->recipient_payer_name]);
                    // echo $this->Form->input('recipient_payer_name', ['empty'=>false, 'options'=>$dataRowRecipientPayer, 'data-placeholder'=>'Silakan pilih..', 'class'=>'form-control select2Form', 'autofocus'=>'autofocus', 'type'=>'select', 'id'=>'select-populates', 'default'=>'Memorial']);
                    ?>
                </div>
            </div>
        </div>
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-2">Judul</label>
            <div class="col-md-10">
                <?php
                echo $this->Form->input('subject', ['class' => 'form-control', 'placeholder'=>'Judul..']);
                ?>
            </div>
            <?php
            /*
            <label class="col-form-label col-md-2">Cek/BG</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('cek_bg', ['class' => 'form-control', 'placeholder'=>'Cek Bg..']);
                ?>
            </div>
            <label class="col-form-label col-md-2">No. Ref</label>
            <div class="col-md-4">
                <?php
                echo $this->Form->input('no_ref', ['class' => 'form-control', 'placeholder'=>'No.Ref..']);
                ?>
            </div>
            */
            ?>
        </div>     

        <div class="table-responsive">
            <table class="table m-b-0 table-advance">
                <tr class="sum">
                    <td>
                        <table class="table table-striped table-bordered display" id="myTable" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Posisi</th>
                                    <th>D/K</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Uraian</th>
                                    <th>Jumlah Debit</th>
                                    <th>Jumlah Kredit</th>
                                    <th><?php
                                    // echo $this->Form->button('<i class="fas fa-plus"></i>', ['class'=>'btn btn-primary', 'id'=>'btnAddCart', 'type'=>'button', 'escapeTitle' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Tambah', 'id_data'=>$accJournal->id.'^'.$accJournalLineManifestId]);
                                    ?></th>
                                </tr>
                            </thead>
                                
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align:right">Total:</th>
                                    <th style="text-align:right"></th>
                                    <th style="text-align:right"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>

                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="panel-footer text-right bg-orange">
    <?php
    echo $this->Form->button('Simpan', ['class'=>'btn btn-primary', 'type'=>'button', 'escape' => false, 'id'=> 'btn-add', 'disabled'=>'disabled']);
    ?>
    </div>
    <div class="modal fade" role="dialog" id="ajax-modal" style="overflow:hidden;"></div>
    <?= $this->Form->end() ?>
</div>
<?php

// $urlCartJurnalProcess = $this->Url->build(['prefix'=>false, 'controller'=>'acc_journals', 'action' => 'add_cart', '_full'=>true]);
?>
<script>
$(document).ready(function() {
    var urlDataTable = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'acc_journal_lines', 'action' => 'edit_many_datatable?idJournal='.$accJournal->id], ['fullBase' => true]); ?>";
    var formActionAdd = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'acc_journal_lines', 'action' => 'add'], ['fullBase' => true]); ?>";
    var formActionDelete = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'acc_journal_lines', 'action' => 'delete'], ['fullBase' => true]); ?>";
    var formActionEdit = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'acc_journal_lines', 'action' => 'edit'], ['fullBase' => true]); ?>";
    var formActionPreview = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'acc_journals', 'action' => 'preview_journal_line'], ['fullBase' => true]); ?>";
    var urlGetCoaFromJurnalEdit = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'acc_journals', 'action' => 'get_coa_from_journal_edit'], ['fullBase' => true]); ?>";

    var confirmTitle = "Apakah anda ingin menyimpan data tersebut ?";
    var formAction = "<?php echo $this->Url->build(['prefix'=>'Acc', 'controller'=>'acc_journals', 'action' => 'edit_many', $accJournal->id], ['fullBase' => true]); ?>";
    handleFormConfirmSubmitValid('AccJournalAddForm', 'btn-add', confirmTitle, formAction);

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
        "columnDefs": [
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
        ],
        "aoColumns": [
            {mData:"id"},
            {mData:"position"},
            {mData:"ledgerdc", "sWidth": "30", "sClass": "dt-center"},
            {mData:"coaName", "sWidth": "250", "sClass": "dt-left"},
            {mData:"coaCustomerName", "sClass": "dt-left"},
            {mData:"debet", "sWidth": "90", "sClass": "dt-right", bSortable: false, bSearchable: false, "type": "numeric",
                mRender: $.fn.dataTable.render.number( '.', ',', 2 )
                //, 'Rp '
            },
            {mData:"credit", "sWidth": "90", "sClass": "dt-right", bSortable: false, bSearchable: false, "type": "numeric",
                mRender: $.fn.dataTable.render.number( '.', ',', 2, )
            },
            {bSortable: false, bSearchable: false, "sClass": "dt-center", "sWidth": "60",
                "mRender": function ( data, type, row ) {
                    var dataId = row.id;
                    var action = '<button type="button" id_data="' + dataId + '" class="btn btn-indigo m-r-5 btnTableEdit"><i class="fa fa-pencil-alt"></i></button>';
                    //<button type="button" id_data="' + dataId + '" class="btn btn-danger m-r-5 btnTableDelete"><i class="fa fa-trash-alt"></i></button>
                    return action;
                }
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

            var pageTotalDebet = api.column( 5, { page:'current'} ).data().reduce( function (a, b) { return intVal(a) + intVal(b); }, 0 );
            var pageTotalCredit = api.column( 6, { page: 'current'} ).data().reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 5 ).footer() ).html(numFormat(pageTotalDebet));
            $( api.column( 6 ).footer() ).html(numFormat(pageTotalCredit));

            $('#totalLine').val(pageTotalDebet);

            if(pageTotalDebet==pageTotalCredit) {
                //alert("sama oeee");
                $("#btn-add").prop("disabled", false);
                

            } else {
                //alert("tidak sama oeee");
                $("#btn-add").prop("disabled", true);
            }
        },
        bFilter: false, // to display datatable search
    });

    // {mData:"User.full_name",bSearchable:false}, // can't search virtual fields
    //$.fn.DataTable.ext.errMode = 'none';
    //var oTable = $('#myTable').DataTable(xdefault);

    //$('#btnTableEdit').on('click', function(){
    $(document).on("click", ".btnTableEdit", function(){
        var $modal = $('#ajax-modal');

        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };

        // Alamat untuk edit form
        var formAction = formActionEdit+'/'+id_data;
        $//('body').modalmanager('loading');

        setTimeout(function(){
            $modal.load(formAction, '', function(){
                $modal.modal();
            });
        }, 1000);
    });

    //$('#btnTablePreview').on('click', function(){
    $(document).on("click", "#btnTablePreview", function(){
        var $modal = $('#ajax-modal');

        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };

        // Alamat untuk edit form
        var formAction = formActionPreview+'/'+id_data;
        //$('body').modalmanager('loading');

        setTimeout(function(){
            $modal.load(formAction, '', function(){
                $modal.modal();
            });
        }, 1000);
    });


    $(document).on("click", "#btnAddCart", function(){
        // alert("asfasf");

        var $modal = $('#ajax-modal');

        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };

        // Alamat untuk edit form
        var formAction = formActionAdd+'/'+id_data;
        $//('body').modalmanager('loading');

        setTimeout(function(){
            $modal.load(formAction, '', function(){
                $modal.modal();
            });
        }, 1000);
    });

    $(document).on("click", ".btnTableDelete", function(){
       // var $modal = $('#ajax-modal');
        var confirmTitle = "Apakah anda yakin ingin menghapus data tersebut ?";
        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };

        var $form = $(this).closest('form');
        bootbox.confirm(confirmTitle, function(result) {
            if(result==true) {
                // Alamat untuk edit form
                var formAction = formActionDelete+'/'+id_data;
                $//('body').modalmanager('loading');
                jQuery.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    dataType: "html",
                    data: value,
                    url: formAction,
                   
                    success: function(data, textStatus, jqXHR) {
                        //$('#ajax-modal').modal('show');                       
                        var table = $('#myTable').DataTable(); 
                        table.ajax.reload( null, false );
                        swal({
                          title: "Berhasil",
                          text: "Data berhasil dihapus.",
                          timer: 3500,
                          showConfirmButton: false,
                          type: 'success',
                          customClass: 'facebook',
                        });                     
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                       swal("Error!", textStatus, "error");
                    }
                });
                return true;
            }
        });

        
    });
    
    

    function autoLoad() {
        $('input.auto').autoNumeric({aSep: '.', aDec: ',', pSign: 's', vMax: '100000000000'});
        $('.noCode').autoNumeric({aSep: '.', aDec: ',', mDec: '', vMax:'999'});

        $("table tr #dr-diff").css("font-weight", "bold");
        $("table tr #cr-diff").css("font-weight", "bold");

        $(".select2-clear").select2({ allowClear: true });
        $(".select2-multiple").select2({ placeholder: "Select a state", allowClear: true });

        $(".select2Form").select2();
    }
    autoLoad();


});
</script>
<?php
/*
$.fn.editable.defaults.mode = 'inline';
    $.fn.editable.defaults.inputclass="form-control input-sm";
    $.fn.editable.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>"; 
    $.fn.editable.defaults.url="/post";

   
    var a=[];
        $.each( <?php echo json_encode($data['rowCOA']); ?>, function(e, i) {
            a.push( {
                id: e, text: i
            })
        });
    
    $('.statusEditCoa').editable({
        source: a,
        select2: { width: 300, cacheDataSource: false, },
        tpl: '<select></select>',
        type: 'select2',
        url: urlGetCoaFromJurnalEdit,
        pk: 1,      
        type: "POST",
        dataType: 'json',      
        success: function(response, newValue) {
            //userModel.set('username', newValue); //update backbone model
            //alert(response);
            //alert(response.id);
            //text: "Status " + newValue + " berhasil disimpan!",
            var res = response.split("^");
            
            swal({
              title: "Berhasil",
              text: "Nama Perkiraan berhasil disimpan!",
              timer: 2500,
              showConfirmButton: false,
              type: 'success',
              customClass: 'facebook',
            });
        }
        
    });*/
?>