$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    const table = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL + '/role',
            type: 'GET',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        drawCallback: function () {
            funDataTableCheck('datable_check');
            funDataTableUnCheck('datable_check');
            funTooltip();
        },
        language: {
            processing: '<div class="spinner-border text-primary m-1" role="status"><span class="sr-only">Loading...</span></div>'
        },
        order: [[0, 'DESC']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
    })
    $(document).on('click', '#filter', function () {
        table.draw()
    });


    $(document).on('click', '.delete-single', function () {
        const value_id = $(this).data('id')

        swal({
            title: sweetalert_title,
            text: sweetalert_text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonColor: "#067CBA",
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                deleteRecord(value_id)
            }
        });
    })
    let $form = $('#addEditForm')
    $form.on('submit', function (e) {
        e.preventDefault();
        e.preventDefault()
        $form.parsley().validate();
        if ($form.parsley().isValid()) {
            loaderView();
            let formData = new FormData($form[0])
            axios
                .post(APP_URL + '/role', formData)
                .then(function (response) {
                    if ($("#form-method").val() === 'add') {
                        $form[0].reset();
                        $form.removeClass('was-validated');
                    }
                    setTimeout(function () {
                        window.location.href = APP_URL + '/role'
                    }, 1000);
                    successToast(response.data.message, 'success');
                })
                .catch(function (error) {
                    successToast(error.response.data.message, 'warning')
                });

            loaderHide();
        }
    })

    function deleteRecord(value_id) {

        $.ajax({
            type: 'DELETE',
            url: APP_URL + '/role' + '/' + value_id,
            success: function (data) {
                successToast(data.message, 'success');
                table.draw()
                loaderHide();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    }

    $(document).on('click', '.status-change', function () {
        const value_id = $(this).data('id');
        const status = $(this).data('status');
        swal({
            title: status,
            text: status_msg,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#067CBA",
            confirmButtonClass: "btn-danger",
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                changeStatus(value_id, status)
            }
        });
    });

    function changeStatus(value_id, status) {
        axios
            .get(APP_URL + '/role/status' + '/' + value_id + '/' + status)
            .then(function (response) {
                table.draw()
                successToast(response.data.message, 'success');
            })
            .catch(function (error) {
                successToast(error.response.data.message, 'warning')
            });
    }

    function myFunction(value) {
        console.log(value);
    }

    $('#all').click(function () {
        if ($(this).is(':checked')) {
            $("#create").attr('checked', true);
            $("#update").attr('checked', true);
            $("#read").attr('checked', true);
            $("#delete").attr('checked', true);
        } else {
            $("#create").attr('checked', false);
            $("#update").attr('checked', false);
            $("#read").attr('checked', false);
            $("#delete").attr('checked', false);
        }
    });
})

