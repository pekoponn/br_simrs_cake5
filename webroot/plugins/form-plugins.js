// IE8 browser support
if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function(elt /*, from*/) {
        var len = this.length >>> 0;
        var from = Number(arguments[1]) || 0;
        from = (from < 0) ? Math.ceil(from) : Math.floor(from);
        if (from < 0)
            from += len;

        for (; from < len; from++) {
            if (from in this && this[from] === elt)
                return from;
        }
        return -1;
    };
}
if(typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, ''); 
    }
}


var handleSelect2Form = function() {
    "use strict";

    $(".select2Form").select2();
    $(".select2FormClear").select2({ allowClear: true });
    $(".select2FormMultiple").select2({ placeholder: "Select a state", allowClear: true });

};

var handleFormMaskedInput = function() {
    "use strict";
    $("#masked-input-percent").mask("9.99");
    $("#masked-input-ktp").mask("9999-9999-9999-9999");
    $("#masked-input-card").mask("9999-9999-9999-9999");
    $("#datepicker-default").mask("99-99-9999");
    $("#datepicker-inline").mask("99-99-9999");
    $("#datepicker-disabled-past").mask("99-99-9999");
    $(".input-daterange").mask("99-99-9999");    
    $("#datepickerLicense").mask("99-99-9999");
    $("#datepicker-autoClose").mask("99-99-9999");
    $("#datepicker-autoClose1").mask("99-99-9999");
    $("#datepicker-autoClose2").mask("99-99-9999");
    $("#datepicker-autoClose3").mask("99-99-9999");
    $("#datepicker-autoClose4").mask("99-99-9999");
    $("#datepicker-autoClose5").mask("99-99-9999");
    $("#datepicker-autoClose6").mask("99-99-9999");
    $("#datepicker-autoClose7").mask("99-99-9999");
    $("#datepicker-autoClose8").mask("99-99-9999");
    $("#datetimepicker1").mask("99-99-9999");
    $("#datetimepicker2").mask("99-99-9999");
    $("#datetimepicker3").mask("99-99-9999");
    $("#datetimepicker4").mask("99-99-9999");
    $("#datetimepicker5").mask("99-99-9999");
    $("#datetimepicker6").mask("99-99-9999");
    $("#datetimepicker7").mask("99-99-9999");
    $("#datetimepicker8").mask("99-99-9999");
    $("#default-daterange").mask("99-99-9999");
    $(".dateRange").mask("99-99-9999");

};

var handleDatepicker = function() {
    $('#datepicker-default').datepicker({
        todayHighlight: true,
        orientation: "bottom"
    });
    $('#datepicker-inline').datepicker({
        todayHighlight: true,
        orientation: "bottom"
    });
    $('.input-daterange').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom"
    });
    $('#datepickerLicense').datepicker({
        format: "dd-mm-yyyy",
        startDate: '-2d',
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom", 
    });
    $('#datepicker-disabled-past').datepicker({
        todayHighlight: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose1').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose2').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose3').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose4').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose5').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose6').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose7').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    $('#datepicker-autoClose8').datepicker({
        format: "dd-mm-yyyy",
        todayHighlight: true,
        autoclose: true,
        orientation: "bottom"
    });
    
};

var handleIonRangeSlider = function() {
    $('#default_rangeSlider').ionRangeSlider({
        min: 0,
        max: 5000,
        type: 'double',
        prefix: "$",
        maxPostfix: "+",
        prettify: false,
        hasGrid: true,
        skin: 'big'
    });
    $('#customRange_rangeSlider').ionRangeSlider({
        min: 1000,
        max: 100000,
        from: 30000,
        to: 90000,
        type: 'double',
        step: 500,
        postfix: " €",
        hasGrid: true,
        skin: 'flat'
    });
    $('#customValue_rangeSlider').ionRangeSlider({
        values: [
            'January', 'February', 'March',
            'April', 'May', 'June',
            'July', 'August', 'September',
            'October', 'November', 'December'
        ],
        type: 'single',
        hasGrid: true
    });
};

var handleFormMaskedInput = function() {
    "use strict";
    $("#masked-input-date").mask("99-99-9999");
    $("#masked-input-phone").mask("(999) 999-9999");
    $("#masked-input-tid").mask("99-9999999");
    $("#masked-input-ssn").mask("999-99-9999");
    $("#masked-input-pno").mask("aaa-9999-a");
    $("#masked-input-pkey").mask("a*-999-a999");
};

var handleFormColorPicker = function () {
    "use strict";
    $('#colorpicker').colorpicker({format: 'hex'});
    $('#colorpicker-append').colorpicker({format: 'hex'});
    $('#colorpicker-append').on('colorpickerChange', function(e) {
        var color = $('#colorpicker-append').colorpicker('getValue');
        
        $('#colorpicker-append').find('.input-group-text i').css('color', color);
    });
    $('#colorpicker-rgba').colorpicker();
};

var handleFormTimePicker = function () {
    "use strict";
    $('#timepicker').timepicker();
};

var handleFormPasswordIndicator = function() {
    "use strict";
    var options = {};
    options.ui = {
        container: '#pwd-default-container',
        viewports: { progress: '#pwstrength-default-progress' },
        showVerdictsInsideProgressBar: true,
        progressBarExtraCssClasses: 'progress-bar-striped'
    };
    options.common = {
        debug: true,
        onLoad: function () {
            $('#pwstrength-default-text').text('Start typing password...');
        }
    };
    $('#pwstrength-default').pwstrength(options);
    
    var options = {};
    options.ui = {
        container: '#pwd-popover-container',
        viewports: { progress: '#pwstrength-popover-progress' },
        showPopover: true,
        showErrors: true,
        showVerdictsInsideProgressBar: true,
        progressBarExtraCssClasses: 'progress-bar-striped'
    };
    options.common = {
        debug: true,
        onLoad: function () {
            $('#pwstrength-popover-text').text('Start typing password...');
        }
    };
    $('#pwstrength-popover').pwstrength(options);
};

var handleJqueryAutocomplete = function() {
    var availableTags = [
        'ActionScript',
        'AppleScript',
        'Asp',
        'BASIC',
        'C',
        'C++',
        'Clojure',
        'COBOL',
        'ColdFusion',
        'Erlang',
        'Fortran',
        'Groovy',
        'Haskell',
        'Java',
        'JavaScript',
        'Lisp',
        'Perl',
        'PHP',
        'Python',
        'Ruby',
        'Scala',
        'Scheme'
    ];
    $('#jquery-autocomplete').autocomplete({
        source: availableTags
    });
};

var handleBootstrapCombobox = function() {
    $('.combobox').combobox();
};

var handleTagsInput = function() {
    $('.bootstrap-tagsinput input').focus(function() {
        $(this).closest('.bootstrap-tagsinput').addClass('bootstrap-tagsinput-focus');
    });
    $('.bootstrap-tagsinput input').focusout(function() {
        $(this).closest('.bootstrap-tagsinput').removeClass('bootstrap-tagsinput-focus');
    });
};

var handleSelectpicker = function() {
    $('.selectpicker').selectpicker('render');
};

var handleJqueryTagIt = function() {
    $('#jquery-tagIt-default').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-inverse').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-white').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-primary').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-info').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-success').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-warning').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
    $('#jquery-tagIt-danger').tagit({
        availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"]
    });
};

var handleDateRangePicker = function() {
    $('#default-daterange').daterangepicker({
        opens: 'right',
        format: 'DD-MM-YYYY',
        separator: ' to ',
        startDate: moment().subtract('days', 29),
        endDate: moment(),
        minDate: '01-12-2012',
        maxDate: '31-12-2018',
    }, function (start, end) {
        $('#default-daterange input').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

    $('#advance-daterange span').html(moment().subtract('days', 29).format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#advance-daterange').daterangepicker({
        format: 'MM-DD-YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01-01-2012',
        maxDate: '31-12-2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        $('#advance-daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
};

var handleSelect2 = function() {
    $(".default-select2").select2();
    $(".multiple-select2").select2({ placeholder: "Select a state" });
};

var handleDateTimePicker = function() {
    $('#datetimepicker1').datetimepicker();
    $('#datetimepicker2').datetimepicker({
        format: 'LT'
    });
    $('#datetimepicker3').datetimepicker();
    $('#datetimepicker4').datetimepicker();
    $("#datetimepicker3").on("dp.change", function (e) {
        $('#datetimepicker4').data("DateTimePicker").minDate(e.date);
    });
    $("#datetimepicker4").on("dp.change", function (e) {
        $('#datetimepicker3').data("DateTimePicker").maxDate(e.date);
    });
};

var handleBootstrapColorPalette = function() {
    $('#color-palette-1').colorPalette().on('selectColor', function(e) {
        $('[data-id="color-palette-1"]').val(e.color);
    });
    var options = {
        colors:[['#000000', '#424242', '#636363', '#9C9C94', '#CEC6CE', '#EFEFEF', '#EFF7F7', '#FFFFFF']]
    }
    $('#color-palette-custom').colorPalette(options).on('selectColor', function(e) {
        $('[data-id="color-palette-custom"]').val(e.color);
    });
};

var handleSimpleColorpicker = function() {
    $('select[name="jquery-simplecolorpicker"]').simplecolorpicker('selectColor', '#2d353c');
    $('select[name="jquery-simplecolorpicker-fa"]').simplecolorpicker({theme: 'fontawesome'});
    $('select[name="colorpicker-picker-longlist"]').simplecolorpicker({picker: true, theme: 'glyphicons'});
};

var handleClipboard = function() {
    var clipboard = new ClipboardJS('.btn');
    
    clipboard.on('success', function(e) {
        $(e.trigger).tooltip({
            title: 'Copied',
            placement: 'top'
        });
        $(e.trigger).tooltip('show');
        setTimeout(function() {
            var bootstrapVersion = handleCheckBootstrapVersion();
            if (bootstrapVersion >= 3 && bootstrapVersion < 4) {
                $(e.trigger).tooltip('destroy');
            } else if (bootstrapVersion >= 4 && bootstrapVersion < 5) {
                $(e.trigger).tooltip('dispose');
            }
        }, 500);
    });
};

var handleFormSelect2Search = function(idName, placeholders, minLength, urlLink) {
    "use strict";
    $('#' + idName).select2({
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
                return {
                    results: data,
                };
            },
            cache: true
        },
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
                return {
                    results: data,                    
                };
            },
            cache: true
        },
    });
};

var handleFormConfirmPassword = function() {
    "use strict";

    $('#confirm_password').on('keyup', function () {
        if (document.getElementById('password').value ==document.getElementById('confirm_password').value) {
            //$(this).val() == $('#password').val()
            document.getElementById("confirm_password").style.borderColor = "lime";
            document.getElementById('btn-add').disabled = false;
            document.getElementById('message').innerHTML = 'Password sudah cocok';
        } 
        else{
            document.getElementById("confirm_password").style.borderColor = "red";
            document.getElementById('btn-add').disabled = true;
            document.getElementById('message').innerHTML = 'Password tidak cocok';
        }
    });
};

var handleFormCheckAllGrid = function(idName) {
    "use strict";

    $('#' + idName + ' .group-checkable').change(function() {
        var set = $(this).attr("data-set");
        var checked = $(this).is(":checked");

        $(set).each(function() {
            if (checked) {
                $(this).attr("checked", true);
                $(this).parents('tr').toggleClass("active");
            } else {
                $(this).attr("checked", false);
                $(this).parents('tr').toggleClass(false);
            }
        });
    });

    $('#' + idName + ' tbody tr .checkboxes').change(function() {
        $(this).parents('tr').toggleClass("active");
    });

}

var FormPlugins = function () {
    "use strict";
    return {
        //main function
        init: function () {
            handleDatepicker();
            handleSelect2();
            handleSelect2Form();
            handleFormConfirmPassword();
            handleDateTimePicker();
            handleFormSelect2Search();
            handleFormSelect2SearchClass();
        }
    };
}();

$(document).ready(function() {
    FormPlugins.init();
});