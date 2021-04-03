CKEDITOR.replaceAll('ck-editor', {
    language: 'fa'
});
$('.datepicker').persianDatepicker({
    format: "YYYY-M-D",
    autoClose: true
});
// var modal = document.getElementById("myModal");
// $(".myBtn").click(function () {
//     modal.style.display = "block";
// });
// $(".close").click(function () {
//     var modal = document.getElementById("myModal");
//     modal.style.display = "none";
// });

// window.onclick = function (event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// };

$('.select2').select2({
    placeholder: "یک یا چند تا از وارد زیر را انتخاب کنید",
    // tags: true,
    width: "100%",// just for stack-snippet to show properly
    multiple: true,
    // tokenSeparators: [',', ' '],
    // dir: "rtl",
    language: "fa",
    // placeholder: 'موارد جدید را اضافه کنید',
    // allowClear: true,
});


function deleteWithModal(form, id, e) {
    e.preventDefault();
    swal("آیا اطمینان دارید؟", {
        dangerMode: true,
        buttons: true,
        icon: "warning",
        title: "اخطار!",

    })
        .then((willDelete) => {
            if (willDelete) {
                // let formDelete = form + id;
                // submiter(document.getElementById(formDelete));
                let formDelete = form + id;
                submiter($( document.getElementById(formDelete)));
                // document.getElementById(formDelete).submit();
            } else {
                swal("حذف شما لغو گردید!");
            }
        });
}

$(document).on('click', '.active-btn', function (e) {

    e.preventDefault();
    let icon = $(this).find('.active-btn-icon');
    let badge = $(this).find('.active-btn-badge');

    icon.removeClass('fa fa-check');
    icon.addClass('fa fa-window-close');

    let url = $(this).attr("href");
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            if (response.active) {
                icon.removeClass('alert-danger fa fa-window-close');
                icon.addClass('alert-success fa fa-check');

                badge.removeClass('badge-danger');
                badge.addClass('badge-success');
                badge.text('فعال');
            } else {
                icon.removeClass('alert-success fa fa-check');
                icon.addClass('alert-danger fa fa-window-close');

                badge.removeClass('badge-success');
                badge.addClass('badge-danger');
                badge.text('غیر فعال');
            }
            swal(response.message, {
                dangerMode: false,
                icon: typeof response.active !== 'undefined' ?"success":"error",
                title: typeof response.active !== 'undefined' ?"موفق":"خطا",
                showCloseButton: true,

            })
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }

    });
});
$(document).on('click', '.vip-btn', function (e) {

    e.preventDefault();
    let icon = $(this).find('.vip-btn-icon');
    let badge = $(this).find('.vip-btn-badge');

    icon.removeClass('fa fa-check');
    icon.addClass('fa fa-window-close');

    let url = $(this).attr("href");
    $.ajax({
        type: "get",
        url: url,
        success: function (response) {
            console.log(response);
            if (response.is_vip) {
                icon.removeClass('alert-secondary fa fa-window-close');
                icon.addClass('alert-primary fa fa-check');

                badge.removeClass('badge-secondary');
                badge.addClass('badge-primary');
                badge.text('ویژه');
            } else {
                icon.removeClass('alert-primary fa fa-check');
                icon.addClass('alert-secondary fa fa-window-close');

                badge.removeClass('badge-primary');
                badge.addClass('badge-secondary');
                badge.text('عادی');
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {

        }

    }).then(() => {
        swal("با موفقیت ثبت شد", {
            dangerMode: false,
            icon: "success",
            title: "موفق!",
            showCloseButton: true,

        }).then(() => {
            // location.reload();
        });
    });
});


$(document).ready(function () {

    var to, from;
    to = $(".range-to-example").persianDatepicker({
        inline: false,
        // initialValueType: 'gregorian',
        observer: true,
        format: 'YYYY-MM-DD-H:mm:ss',
        initialValue: false,
        onSelect: function (unix) {
            to.touched = true;
            $('#view_end_time').trigger('change');

            if (from && from.options && from.options.maxDate != unix) {
                var cachedValue = from.getState().selected.unixDate;
                from.options = {maxDate: unix};
                if (from.touched) {
                    from.setDate(cachedValue);

                }
            }
        }
    });
    from = $(".range-from-example").persianDatepicker({
        inline: false,
        // initialValueType: 'gregorian',
        observer: true,
        format: 'YYYY-MM-DD-H:mm:ss',
        initialValue: false,
        onSelect: function (unix) {
            $('#view_start_time').trigger('change');

            from.touched = true;
            if (to && to.options && to.options.minDate != unix) {
                var cachedValue = to.getState().selected.unixDate;
                to.options = {minDate: unix};
                if (to.touched) {
                    to.setDate(cachedValue);

                }
            }
        }
    });

});
