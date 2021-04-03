function add_comma(str,id)
{
    num = str.replace(/\d(?=(?:\d{3})+$)/g, '$&,');
    document.getElementById(id).value = num;
}
function delete_confirm(element)
{
    var form = $(element).closest('form');
    $(form).submit(function(e){
        e.preventDefault();
    });

    $.confirm({
        title: 'هشدار!',
        content: 'آیا برای حذف مطمئن هستید ؟',
        buttons: {
            confirm: {
                btnClass: 'btn-green',
                text:'بله',
                action: function () {
                    $(form)[0].submit();
                }
            },
            cancel:{
                text: 'خیر',
                btnClass: 'btn-red',
                function () {
                    $.alert('نه!');
                },

            },
        }
    });
}

