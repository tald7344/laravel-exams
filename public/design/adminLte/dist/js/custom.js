// Check All Checkbox in the datatable
function check_all() {
    $('input[class="item_checkbox"]:checkbox').each(function () {
        // the input[class="ckeck_all"] has two value 1 or 0
        if ($('input[class="check_all"]:checkbox:checked').length == 0) {
            $(this).prop('checked', false);
        } else {
            $(this).prop('checked', true);
        }
    });
}

function delete_All() {
    $(document).on('click', '.submit_delete_all', function () {
        $('#form_data').submit();
    });

    $(document).on('click', '.delete_all', function () {
        var record_number = $('input[class="item_checkbox"]:checkbox').filter(':checked').length;
        if (record_number > 0) {
            $('#record_count').text(record_number);
            $('.not_empty_record').removeClass('d-none');
            $('.empty_record').addClass('d-none');
            $('.submit_delete_all').removeClass('d-none');
        } else {
            $('.empty_record').removeClass('d-none');
            $('.not_empty_record').addClass('d-none');
            $('.submit_delete_all').addClass('d-none');
        }
        $('#deleteAllModal').modal('show');
    });
};