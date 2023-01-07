$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
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
                .post(APP_URL + '/permission', formData)
                .then(function (response) {
                    if ($("#form-method").val() === 'add') {
                        $('input[type="checkbox"]').attr("checked", false);
                        $form[0].reset();
                    }
                    successToast(response.data.message, 'success');
                })
                .catch(function (error) {
                    successToast(error.response.data.message, 'warning')
                });

            loaderHide();
        }
    })

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

