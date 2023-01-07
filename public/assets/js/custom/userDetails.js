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
            url: APP_URL + '/userVehicle',
            type: 'GET',
            data: function (d) {
                d.user_id = $('#user_id').val()
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'creation_time', name: 'creation_time'},
            {data: 'name', name: 'name'},
            {data: 'vehicle_type', name: 'vehicle_type'},
            {data: 'brand', name: 'brand'},
            {data: 'model', name: 'model'},
            {data: 'body', name: 'body'},
            {data: 'year', name: 'year'},
            {data: 'engine', name: 'engine'},
            {data: 'fuel', name: 'fuel'},
            {data: 'is_filter', name: 'is_filter'},
            {data: 'updation_time', name: 'updation_time'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        drawCallback: function () {
            funTooltip()
        },
        language: {
            processing: '<div class="spinner-border text-primary m-1" role="status"><span class="sr-only">Loading...</span></div>',
        },
        order: [[0, 'DESC']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
    })

    const address_table = $('#address-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: APP_URL + '/userAddress',
            type: 'GET',
            data: function (d) {
                d.user_id = $('#user_id').val()
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'creation_time', name: 'creation_time'},
            {data: 'address', name: 'address'},
            {data: 'updation_time', name: 'updation_time'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        drawCallback: function () {
            funTooltip()
        },
        language: {
            processing: '<div class="spinner-border text-primary m-1" role="status"><span class="sr-only">Loading...</span></div>',
        },
        order: [[0, 'DESC']],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
    })

    let $form = $('#addVehicle')
    $form.on('submit', function (e) {
        e.preventDefault()
        $form.parsley().validate();
        if ($form.parsley().isValid()) {
            loaderView();
            let formData = new FormData($('#addVehicle')[0])
            $.ajax({
                url: APP_URL + '/userVehicleStore',
                type: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    loaderHide();
                    if (data.success === true) {
                        $form.parsley().reset();
                        $form[0].reset();
                        successToast(data.message, 'success')
                        $("#vehicleModal").modal('hide');
                        table.draw();
                    } else {
                        successToast(data.message, 'warning')
                    }
                },
                error: function (data) {
                    loaderHide();
                    console.log('Error:', data)
                }
            })
        }
    })

    let $formAddress = $('#addEditForm')
    $formAddress.on('submit', function (e) {
        e.preventDefault()
        $formAddress.parsley().validate();
        if ($formAddress.parsley().isValid()) {
            loaderView();
            let formData = new FormData($('#addEditForm')[0])
            $.ajax({
                url: APP_URL + '/userAddressStore',
                type: 'POST',
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    loaderHide();
                    if (data.success === true) {
                        $formAddress[0].reset()
                        $formAddress.parsley().reset();
                        successToast(data.message, 'success')
                        setTimeout(function () {
                            window.location.href = APP_URL + '/userAddressStore'
                        }, 1000);
                    } else if (data.success === false) {
                        successToast(data.message, 'warning')
                    }
                },
                error: function (data) {
                    loaderHide();

                    console.log('Error:', data)
                }
            })
        }
    })


    $(document).on('click', '.delete-vehicle', function () {
        const value_id = $(this).data('id')

        swal({
            title: sweetalert_title,
            text: sweetalert_text,
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
                deleteRecord(value_id)
            }
        });
    });

    function deleteRecord(value_id) {
        $.ajax({
            type: 'DELETE',
            url: APP_URL + '/deleteUserVehicle' + '/' + value_id,
            success: function (data) {
                successToast(data.message, 'success');
                table.draw()
                loaderHide();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    }

    $(document).on('click', '.delete-single', function () {
        const value_id = $(this).data('id')

        swal({
            title: address_title,
            text: address_text,
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
                deleteRecords(value_id)
            }
        });
    });

    function deleteRecords(value_id) {
        $.ajax({
            type: 'DELETE',
            url: APP_URL + '/deleteUserAddress' + '/' + value_id,
            success: function (data) {
                successToast(data.message, 'success');
                address_table.draw()
                loaderHide();
            }, error: function (data) {
                console.log('Error:', data)
            }
        })
    }


    $("#type").on('change', function () {
        axios
            .post(APP_URL + '/getBrands', {type: $(this).val()})
            .then(function (response) {
                $("#brands").html(response.data);
            })
    });

    $("#brands").on('change', function () {
        axios
            .post(APP_URL + '/getModels', {brand: $(this).val()})
            .then(function (response) {
                $("#vehicle_model").html(response.data);
            })
    });

    $(document).on('click', '.edit-single', function () {
        const value_id = $(this).data('id')
        axios
            .get(APP_URL + '/editUserVehicle/' + value_id)
            .then(function (response) {
                console.log(response.data);
                $("#vehicleModalEditDetails").html(response.data.data);
                $("#vehicleModalEdit").modal('show');
            })

    });

})


