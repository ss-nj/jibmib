function addComma(str, id) {
    var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');
    while (objRegex.test(str)) {
        str = str.replace(objRegex, '$1,$2');
    }
    document.getElementById(id).value = str;
    //return str;
}

function addComma2(str,id) {
    $("#"+id+"").val(parseInt(str).toLocaleString());
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


function delete_attr_confirm(element)
{
    var form = $(element).closest('form');
    $(form).submit(function(e){
        e.preventDefault();
    });

    $.confirm({
        title: 'اخطار!',
        content: 'در صورت حذف خصوصیت،کالای مرتبط باید دوباره ویرایش شود!',
        type: 'orange',
        buttons: {
            confirm: {
                btnClass: 'btn-red',
                text:'تایید!',
                action: function () {
                    $.confirm({
                        title: 'هشدار!',
                        icon: 'fa fa-warning',
                        content: 'آیا برای حذف همچنان مطمئن هستید؟',
                        type: 'red',
                        theme: 'dark',
                        buttons: {
                            confirm: {
                                btnClass: 'btn-red',
                                text:'بله!',
                                action: function () {
                                    $(form)[0].submit();
                                }
                            },
                            cancel:{
                                text: 'خیر',
                                btnClass: 'btn-green',
                                function () {
                                    $.alert('نه!');
                                },

                            },
                        }
                    });
                }
            },
            cancel:{
                text: 'انصراف',
                btnClass: 'btn-green',
                function () {
                    $.alert('نه!');
                },

            },
        }
    });
}

function autocomplete(inp, inpId, arr,arrId) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    var product_id;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, s, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {

        /*check if the item starts with the same letters as the text field value:*/

        // if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            s = arr[i].indexOf(val);

            product_id =  arrId[i];
            // b.innerHTML = "<strong>" + arr[i].substr(s, val.length) + "</strong>";
            // b.innerHTML = arr[i].substr(val.length)+ b.innerHTML;
            b.innerHTML = arr[i];
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            b.innerHTML += "<input type='hidden' name='product_id'  value='" + arrId[i] + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
            b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                inpId.value = this.getElementsByTagName("input")[1].value;

                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                closeAllLists();
            });
            a.appendChild(b);
        }
        // }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        // console.log(elmnt.innerHTML);
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
            else
                console.log(x[i]);
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}



function search(inp, inpId, arr,arrId,slug,subCat,names,route) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    var product_id;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        console.log(1);

        var a, b, i, s, val = this.value;

        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/

                // if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/

                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                s = arr[i].indexOf(val);

                product_id =  arrId[i];

                // href = 'product.single,['+slug[i]+','+subCat[i]+','+names[i]+'';
                href = '"'+route+'/'+slug[i]+'/'+subCat[i]+'/'+names[i]+'"';
                // href = route+'/'+'+slug[i]+'/'+subCat[i]+'/'+names[i]+';
                b.innerHTML = "<a  href="+href+" >"+arr[i]+"</a>";


                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                b.innerHTML += "<input type='hidden' name='product_id' value='" + arrId[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    inpId.value = this.getElementsByTagName("input")[1].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
            }

                // }
            });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        // console.log(elmnt.innerHTML);
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
            else
                console.log(x[i]);
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}


//اضافه کردن تکست باکس برای ثبت سریال هیه
function add_serial($modal=null) {

    var newTextBoxDiv = $(document.createElement('div')).attr("class", 'col');

    newTextBoxDiv.attr('id','serials_div');
    newTextBoxDiv.after().html(
        '<input type="text" name="serials[]" id="Serials"  style="display: inline"  class="form-control w9" />'+
        '<input type="button" value="-" id="removeSerial"  onclick="remove_serial(this)" >'
        );

    if($modal!=null){
        newTextBoxDiv.appendTo("#animate");}
    else
        newTextBoxDiv.appendTo("#serials");
}
function remove_serial(butt) {
    butt.closest('div').remove();
    butt.remove();
}

//انتخاب کردن نوع هدیه
function  set_type(val) {
    if(val==='1')
    {
        $('#Serials').val(null);

        $('#div_count').show();
        //
        $('#name').prop("disabled",false);
        $('#count').prop("disabled",false);
        $('#expire').prop("disabled",false);
        $('#score').prop("disabled",false);
        $('#image').prop("disabled",false);

        $('#div_serials').hide();

        var elements = document.querySelectorAll('#serials_div');
        var i = 0;
        for (i == 0; i < elements.length; ++i) {
            elements[i].remove();
        }

    }
    else if(val==='0')
    {
        // $('#name').val(null);
        // $('#count').val(null);

        // $('#div_name').hide();
        $('#div_count').hide();
        $('#div_serials').show();

        $('#expire').prop("disabled",false);
        $('#name').prop("disabled",false);
        $('#score').prop("disabled",false);
        $('#Serials').prop("disabled",false);
        $('#addSerial').prop("disabled",false);
        $('#image').prop("disabled",false);

    }
    else
    {
        $('#div_name').show();
        $('#div_count').show();
        $('#div_serials').show();

        $('#expire').prop("disabled",true);
        $('#name').prop("disabled",true);
        $('#count').prop("disabled",true);
        $('#score').prop("disabled",true);
        $('#Serials').prop("disabled",true);
        $('#addSerial').prop("disabled",true);
        $('#image').prop("disabled",true);


        $('#count').val(null);
        $('#Serials').val(null);

    }
}
//جدا کردن سه رقمی اعداد در post_methods/index.blade.php
function addCommaOnload() {
    var objRegex = new RegExp('(-?[0-9]+)([0-9]{3})');
        var elements = document.querySelectorAll('.td_cost');
    var i = 0;
    for (i == 0; i < elements.length; ++i) {
        var str = elements[i].innerText;
        while (objRegex.test(str)) {
            str = str.replace(objRegex, '$1,$2');
        }
        elements[i].innerText = str;
    }
}

function add_to_favorite(element,product_id,route) {
    var class_name = $(element).attr('class');
    console.log(class_name);

    axios({
        method: 'post',
        dataType: 'json',
        url: route,
        params: {
            product_id: product_id,
        }
    })
        .then(function (response) {
            var Data = JSON.parse(JSON.stringify(response.data));
            if(Data['message']==='added before'){
                toast('موفق', 'قبلا به لیست علاقمندی ها اضافه شده!');
                console.log(Data['message']);
            }
            else if(Data['message']==='added'){
                console.log(Data['message']);
                toast('موفق', 'به علاقمندی ها اضافه شد.');
            }
            else if(Data['message']==='not login'){
                toast('نا موفق', 'برای اضافه کردن به علاقمندی ها به حساب خود وارد شوید!');
            }
            else{
                console.log(Data['message']);
                toast('نا موفق', 'اضافه نشد دوباره تللاش کنید!');

            }
        });
}
