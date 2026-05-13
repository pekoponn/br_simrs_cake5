
var handleFormConfirmSubmitValid = function(formName, idName, confirmTitle, urlLink) {
    "use strict";

    $('#' + formName).validate({    
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "text-danger" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-5" ).addClass( "text-danger" ).removeClass( "text-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".col-sm-5" ).addClass( "text-success" ).removeClass( "text-danger" );
        }
    });  
    
    $('button[id="'+ idName+'"]').on('click', function (e) {
    e.preventDefault();
    //alert('yuhuuu');
        if ($(this).valid()) {
            var $form = $(this).closest('form');
            bootbox.confirm(confirmTitle, function(result) {
                if(result==true) {
                   $form.attr('action', urlLink);
                   $form.submit();
                   return true;
                }
            });
        }
    });    
   /* $('#' + formName).validate({    
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "text-danger" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-5" ).addClass( "text-danger" ).removeClass( "text-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".col-sm-5" ).addClass( "text-success" ).removeClass( "text-danger" );
        }
    });*/        
};

var handleFormSelect2Search = function(idName, placeholders, minLength, urlLink, clearForms) {
    "use strict";
    if( typeof clearForms === 'undefined' || clearForms === null ){
        var clearForm = false;
    } else {
        var clearForm = true;
    }

    $('#' + idName).select2({
        allowClear: clearForm,
        minimumInputLength: minLength,
        placeholder: placeholders,
        ajax: {
            url: urlLink,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    dataSearch: params.term // search term
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                // params.page = params.page || 1;
                return {
                    results: data,
                    // results: data.AccChartOfAccount,
                    /*pagination: {
                    more: (params.page * 30) < data.total_count
                    }*/
                };
            },
            cache: true
        },
        // templateResult: formatRepo,
        // templateSelection: formatRepoSelection,
        // closeOnSelect: true
    });

};

var handleFormSelect2SearchClass = function(idName, placeholders, minLength, urlLink) {
    "use strict";
    $('.' + idName).select2({
        minimumInputLength: minLength,
        placeholder: placeholders,
        ajax: {
            url: urlLink,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    dataSearch: params.term // search term
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                // params.page = params.page || 1;
                return {
                    results: data,                    
                };
            },
            cache: true
        },
    });
};

var handleFormPreview = function(idName, urlLink) {
    "use strict";

    var modalDetail = $('#modal-detail');

    $('#'+idName).on('click', function(){
        // create the backdrop and wait for next modal to be triggered
        var formAction = urlLink;
        setTimeout(function(){
            modalDetail.load(formAction, '', function(){
                //modalDetail.modal('show');
                $('#modal-detail').modal();
            });
        }, 100);
    });   
};

var handleCheckAllGrid = function(idName) {
    "use strict";
    $('#'+ idName + ' .group-checkable').click( function () {
        $( '#'+ idName + ' input[type="checkbox"]' ).prop('checked', this.checked)
    });
};

var handleSelect2Form = function() {
    "use strict";

    $(".select2Form").select2();
    $(".select2FormClear").select2({ allowClear: true });
    $(".select2FormMultiple").select2({ placeholder: "Select a state", allowClear: true });

};

/*var handleDatePickerRange = function(idName) {
    "use strict";

    datePickerReset('date-picker', 'resetDate', 'filterDate', 'dd-mm-yyyy');
    datePicker('date-picker-from', 'date-picker-to', 'dd-mm-yyyy');

    function datePickerReset(className, idReset, dateIdReset, formatDate, monthYear) {
        datePicker(className, formatDate, monthYear);
        dateReset(idReset, dateIdReset);
    }

    function dateReset(idForm, idFormDate) {
        // $('#' + idForm).on('click', function() {
        //     document.getElementById(idFormDate).value = '';
        // });
        $('.' + idForm).on('click', function() {
            $('.' + idFormDate).val("");
        });
    }

    function datePicker(className, formatDate, monthYear) {
        var dateFormat = (formatDate==null) ? 'dd-mm-yyyy' : formatDate;
        
        if(monthYear=='y') {
            $('.' + className).datepicker({
                format: dateFormat,
                viewMode: 'months', 
                minViewMode: 'months',
                orientation: 'auto right',
                autoclose: true,
                todayHighlight: !0
            });
        } else {
            $('.' + className).datepicker({
                format: dateFormat,
                orientation: 'auto',
                autoclose: true,
                todayHighlight: !0
            });
        }
    }
};*/

/*var handleCheckAllGrid = function(idName) {
    $('#'+ idName + ' .group-checkable').change(function () {
        var set = $(this).attr("data-set");
        var checked = $(this).is(":checked");
       
        // alert('asd');
        $(set).each(function () {
            if (checked) {
                $(this).attr("checked", true);
                $(this).parents('tr').toggleClass("active");
            } else {
                $(this).attr("checked", false);
                $(this).parents('tr').toggleClass(false);
            }
        });
    });
    
    $('#'+ idName + ' tbody tr .checkboxes').change(function(){
        $(this).parents('tr').toggleClass("active");
    });

};*/

var handleDatePicker = function(className, formatDate, monthYear) {
    var dateFormat = (formatDate==null) ? 'dd-mm-yyyy' : formatDate;
    
    if(monthYear=="y") {
        $('.' + className).datepicker({
            format: dateFormat,
            viewMode: 'months', 
            minViewMode: 'months',
            orientation: 'bottom',
            autoclose: true,
            todayHighlight: !0,
            defaultDate: "+1w",
            showAnim: "blind", 
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 2,
        });
    } else {
        $('.' + className).datepicker({
            format: dateFormat,
            orientation: 'bottom',
            autoclose: true,
            todayHighlight: !0,

            defaultDate: "+1w",
            showAnim: "blind", 
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 2,          
        });
    }
};

var handleDateRange = function(className, idReset, dateIdReset, formatDate, monthYear, className1) {
    "use strict";

    datePickerReset(className, idReset, dateIdReset, formatDate);
    datePicker(className, formatDate, monthYear, className1);

    function datePickerReset(pickerClassName, pickerIdReset, pickerDateIdReset, pickerFormatDate, pickerMonthYear) {
        datePicker(pickerClassName, pickerFormatDate, pickerMonthYear);
        dateReset(pickerIdReset, pickerDateIdReset);
    }

    function dateReset(idForm, idFormDate) {
        $('.' + idForm).on('click', function() {
            $('.' + idFormDate).val("");
        });
    }

    function datePicker(dateClassName, dateFormatDate, dateMonthYear, dateClassName1=null) {
        var dateFormat = (dateFormatDate==null) ? 'dd-mm-yyyy' : dateFormatDate;
        // alert(dateMonthYear);
        if(dateMonthYear=='y') {
            $('#' + dateClassName).datepicker({
                format: dateFormat,
                startView: "months",
                viewMode: 'months', 
                minViewMode: 'months',
                orientation: 'bottom',
                autoclose: true,
                todayHighlight: !0,
                defaultDate: "+1w",
                showAnim: "blind", 
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 2,
            });

            if(dateClassName1) {
                $('#' + dateClassName1).datepicker({
                    format: dateFormat,
                    startView: "months",
                    viewMode: 'months', 
                    minViewMode: 'months',
                    orientation: 'bottom',
                    autoclose: true,
                    todayHighlight: !0,
                    defaultDate: "+1w",
                    showAnim: "blind", 
                    changeMonth: true,
                    changeYear: true,
                    numberOfMonths: 2,
                });
            }
        } else {
            $('.' + dateClassName).datepicker({
                format: dateFormat,
                orientation: 'auto',
                autoclose: true,
                todayHighlight: !0
            });
        }
    }
};

var handleDataTableCombinationSetting = function() {
    "use strict";
    
    if ($('#data-table-combine').length !== 0) {
        var options = {
            dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            buttons: [
                { extend: 'copy', className: 'btn-sm' },
                { extend: 'csv', className: 'btn-sm' },
                { extend: 'excel', className: 'btn-sm' },
                { extend: 'pdf', className: 'btn-sm' },
                { extend: 'print', className: 'btn-sm' }
            ],
            responsive: true,
            autoFill: true,
            colReorder: true,
            keys: true,
            rowReorder: true,
            select: true
        };

        if ($(window).width() <= 767) {
            options.rowReorder = false;
            options.colReorder = false;
            options.autoFill = false;
        }
        $('#data-table-combine').DataTable(options);
    }
};

// handle untuk DataTables
var handleDataTablesApi = function(classTable, modalTable, modalDetailTable, btnApproveCeo, btnPreview, urlDataTable, urlApproveCeo, urlPreview, userId) {
    "use strict";

    // Setup - add a text input to each footer cell
   /* $('#'+classTable+' tfoot th').each( function () {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );*/

    

    var tableApi = $('#'+classTable).DataTable({
        stripeClasses: ['stripe-1',
                        'stripe-2'],
        lengthMenu: [[ 15, 30, -1], [ 15, 30, "All"]], // page length options
        bProcessing: true,
        bDestroy: true,
        bDeferRender: true,
        iDisplayLength: 15,
        fixedColumns: false,
        sPaginationType: "full_numbers",
        bServerSide: true,
        scrollY: 500,
        cache: false,
        //bSearchable: false,
        "paging": true,
        //responsive: true,
        //scrollX: true,
        //order: [0, "asc"],
        scrollCollapse: true,
        ajax: {
            url: urlDataTable, // json datasource
            type: "post",
            // data: function ( d ) {
            //      return $.extend( {}, d, {
            //        "search_keywords": $("#searchInput").val().toLowerCase(),
            //        "filter_option": $("#sortBy").val().toLowerCase()
            //      } );
            // }

            data: {
              // key1: value1 - in case if we want send data with request
            }


            // datatype: "json",
            // headers: { "__requestverificationtoken": token }
        },
        columns: [
            {  
                data: "pcaCode",
                render: function(data, type, row){
                    return data.split("^").join("<br/>");
                }
            },
            { 
                data: "pcaProgress",
                render: function(data, type, row){
                    return data.split("^").join("<br/>");
                }
            },
            { 
                data: "pcaLineAmount", width: "90", "sClass": "dt-right", sortable: false, searchable: false, type: "numeric",
                render: $.fn.dataTable.render.number( '.', ',', 2 )
            },
            { 
                bSortable: false, bSearchable: false, "sClass": "dt-center", "sWidth": "120",
                render: function ( data, type, row ) {
                    var dataId = row.pcaId;
                    var dataLine = row.pcaLineData;
                    var dataModal = row.pcaDataModal;
                    var dataAmount = row.pcaLineTotalAmount;

                    if(row.pcaApproveCeo=='-') {
                        var iconBtn = '<i class="fa fa-times"></i></a>';
                        var colorBtn = 'btn-danger';
                        var dataBtn = dataId+'^Y^'+userId;
                    } else {
                        var iconBtn = '<i class="fa fa-check"></i></a>';
                        var colorBtn = 'btn-lime';
                        var dataBtn = dataId+'^N^'+userId;
                    }
                    
                    var actionBtn = '<button type="button" id_data="' + dataId + '" data_line="'+dataLine+'" data_modal="'+dataModal+'" data_amount="'+dataAmount+'"" class="btn btn-yellow btn-sm p-l-15 p-r-15 '+btnPreview+'" id="btn-preview'+ dataId +'"><i class="fa fa-desktop"></i></button>   <button type="button" id_data="' + dataBtn + '" class="btn '+colorBtn+' btn-sm p-l-15 p-r-15 '+btnApproveCeo+'" id="btn-approve-ceo'+ dataId +'">'+iconBtn+'</button>';

                    return actionBtn;
                }
            },

        ],
        columnDefs: [
            { orderable: false, targets: [0, 1, 2, 3] }
        ],
        "oLanguage": {
            // "sLengthMenu": '<span class="dataTables_info">Tampilkan _MENU_ data per halaman</span>',
            "sInfo": "Halaman _PAGE_ sampai _PAGES_, Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
            "sEmptyTable": "Tidak ada data yang dapat ditampilkan",
            "sInfoEmpty": "Tidak ada data yang dapat ditampilkan",
            "sInfoFiltered": "(Ditemukan dari  total _MAX_ data)",
            "infoEmpty": "Data tidak ditemukan",
            "sZeroRecords": "Mohon Maaf, Data tidak ditemukan !!",
            "sSearch": '<span class="dataTables_info">Pencarian:</span>',
            "sProcessing": "Sedang memproses data...",
            "sLoadingRecords": "Sedang memuat data...",
            "sUrl": "",
            "oPaginate": {
                "sFirst":    "&lang;&lang;",
                "sPrevious": "&lang;",
                "sNext":     "&rang;",
                "sLast":     "&rang;&rang;"
            }
        },
        bFilter: true, // to display datatable search
    });
    
    $(document).on("click", "."+btnPreview, function(){
        var $modal = $('#'+modalTable);
        var id_data=$(this).attr("id_data");
        const dataLine=$(this).attr("data_line");
        const dataModal=$(this).attr("data_modal");
        const dataAmount=$(this).attr("data_amount");
        
        var value = {
            id_data: id_data
        };

        const dataLineArray = dataLine.split(",");
        const dataModalArray = window.atob(dataModal).split("^");
        
        var wrapper = document.getElementById(modalDetailTable);
        var myHTML = '';
        myHTML += '<div class="modal-dialog modal-lg" role="document"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Data : '+dataModalArray[0]+'</h4><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></div><div class="modal-body"><div class="container-fluid"><div class="row m-b-15"><div class="col-sm-12" style="text-align: center;border-bottom: 1px solid #000000;"><span style="font-weight:bold;font-size:12pt;" valign="center" height="50">FORM<br/>PERMOHONAN PETTY CASH ADVANCE</span></div></div><div class="row m-b-15"><div class="col-sm-12"><div class="row"><div class="col-1 col-sm-1">Proyek</div><div class="col-11 col-sm-11"> : '+dataModalArray[1]+'</div></div><div class="row"><div class="col-1 col-sm-1">Tanggal</div><div class="col-11 col-sm-11"> : '+dataModalArray[2]+'</div></div><div class="row"><div class="col-1 col-sm-1">Nama</div><div class="col-11 col-sm-11"> : '+dataModalArray[3]+'</div></div><div class="row"><div class="col-1 col-sm-1">Devisi</div><div class="col-11 col-sm-11"> : '+dataModalArray[4]+'</div></div><div class="row"><div class="col-1 col-sm-1">Tujuan</div><div class="col-11 col-sm-11"> : '+dataModalArray[5]+'</div></div></div></div>';
        myHTML += '<div class="row m-b-15"><div class="col-sm-12"><div class="table-responsive"><table class="table m-b-0 table-advance table-hover" cellspacing="0" cellpadding="1" border="0" align="center"><thead class="thead-dark text-center"><tr><th width="40">NO</th><th>RINCIAN PERMOHONAN</th><th width="70">JUMLAH</th><th width="100">HARGA</th><th width="120">TOTAL</th></tr></thead>';

        for (let i = 0; i < dataLineArray.length; i++) {
              // Print the current element
            var counts = i+1;
            const dataLine = window.atob(dataLineArray[i]).split("^");
            myHTML += '<tr><td align="center">'+counts+'</td><td>'+dataLine[1]+'</td><td align="right">'+dataLine[2]+'</td><td align="right">'+dataLine[3]+'</td><td align="right">'+dataLine[4]+'</td></tr>';
        }
        myHTML += '<tr><td colspan="4" align="right"><b>GRAND TOTAL</b></td><td align="right"><b>'+dataAmount+'</b></td></tr>';
        myHTML += '</table></div></div><div class="col-sm-12">Keterangan: <br>'+dataModalArray[6]+'</div></div>';

        myHTML += '</div></div></div></div>';
        wrapper.innerHTML = myHTML;
        // $("#"+modalDetailTable).html(myHTML);

        
        setTimeout(function(){
            //$modal.load(formAction, '', function(){
                $modal.modal();
            //});
        }, 500);
       
    });

    $(document).on("click", "."+btnApproveCeo, function(){

        var confirmTitle = "Apakah anda yakin ingin memproses PCA tersebut ?";
        var id_data=$(this).attr("id_data");
        var value = {
            id_data: id_data
        };

        var idData = id_data.split("^");

        var $form = $(this).closest('form');
        bootbox.confirm(confirmTitle, function(result) {
            if(result==true) {
                // Alamat untuk edit form
                jQuery.ajax({
                    type: "post",
                    async: true,
                    cache: false,
                    dataType: "html",
                    data: {
                        id:idData[0], status:idData[1], userId:idData[2]
                    }, 
                    /*headers: {
                        'X-CSRF-Token': $('meta[name="csrfToken"]').attr('content')
                    },*/
                    // data: value,
                    url: urlApproveCeo,
                   
                    success: function(data, textStatus, jqXHR) {
                        var table = $('#'+classTable).DataTable(); 
                        table.ajax.reload( null, false );
                        swal({
                          title: "Berhasil",
                          text: "Terima kasih, data PCA berhasil diubah.",
                          timer: 4500,
                          icon: 'success',
                          button: false,
                          // showConfirmButton: false,                          
                          //className: 'facebook',
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
};

var Krs = function () {
    "use strict";
    return {
        //main function
        init: function () {
            //handleCheckAllGrids();
            //handleFormConfirmSubmitValid();
            handleFormPreview();
            handleFormSelect2Search();
            handleCheckAllGrid();
            // handleSelect2Form();
            // handleDatePicker();
            //handleDatePickerRange();
            handleDateRange();
            //handleDataTablesApi();
            //handleDataTableCombinationSetting();
        }
    };
}();

$(document).ready(function() {
    Krs.init();
});