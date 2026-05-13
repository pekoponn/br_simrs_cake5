function submitForm(idName, confirmTitle, urlLink) {
    $('#' + idName).click(function() {
        var $form = $(this).closest('form');
        bootbox.confirm(confirmTitle, function(result) {
            if (result == true) {
                var form_action = urlLink;
                $form.attr('action', form_action);
                $form.submit();
                return true;
            }
        });
    });
}

function checkAllGrid(idName) {
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
        //jQuery.uniform.update(set);
        //return;
    });

    $('#' + idName + ' tbody tr .checkboxes').change(function() {
        $(this).parents('tr').toggleClass("active");
    });

}

function previewForm(idName, urlLink) {
    //ajax demo:
    var $modal = $('#ajax-modal');

    $('#' + idName).on('click', function() {
        // create the backdrop and wait for next modal to be triggered

        var formAction = urlLink;

        setTimeout(function() {
            $modal.load(formAction, '', function() {
                $modal.modal();
            });
        }, 100);

    });
}

function datePicker(className, formatDate, monthYear) {
    var dateFormat = (formatDate == null) ? 'dd-mm-yyyy' : formatDate;

    if (monthYear == "y") {
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
}

function datePickerReset(className, classNameReset, dateNameReset, formatDate, monthYear) {
    datePicker(className, formatDate, monthYear);
    dateReset(classNameReset, dateNameReset);
}

function dateReset(className, dateName) {
    $('.' + className).on('click', function() {
        $('.' + dateName).val("");
    });
}

function selectCall(className, titleName, urlData, minlength=2) {
    $('.' + className).select2({
        placeholder: titleName,
        allowClear: true,
        minimumInputLength: minlength,
        ajax: {
            dataType: 'json',
            url: urlData,
            delay: 250,
            data: function(params) {
                return {
                    search: params.term
                }
            },
            processResults: function(data, page) {
                return {
                    results: data
                };
            },
            cache: true,
        }
    });
}

