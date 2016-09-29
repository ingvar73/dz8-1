// удаление по id
var select = $('#sel_tab_del').on('change', function () {
    var selectedOption = $('#sel_tab_del option:selected');


// function setNewAction(selectOption)
// {
//     for(var i = 0 ; i < selectOption.length ; i++)
//     {
//         if(selectOption[i].selected)
//         {
//             document.forms[0].action ='/'+selectOption[i].value;
//         }
//     }
//     document.forms[0].submit();
// }

$(document).ready(function () {
    $.("#btn_delete").click(function () {
        alert ("В функции");
        var id = $("#id").val();
        var action = $("#action").val();
        var select = $('#sel_tab_del').on('change', function () {
            var selectedOption = $('#sel_tab_del option:selected');
        });
        switch (select){
            case 'users':{
                $("#myForm1").attr('action', '/users');
                $.ajax({
                    url: '/users',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id, action: delete},
                    success: function(data)
                    {
                        alert("Это USERS");
                    }
                });
                break;
            }
            case 'orders': {
                $("#myForm1").attr('action', '/orders');
                $.ajax(
                    {
                        url: '/orders',
                        type: 'POST',
                        dataType: 'json',
                        data: {id: id, action: delete},
                        success: function(data)
                        {
                            alert("Это ORDERS");
                        }
                    });
                break;
            }
            case 'products': {
                $("#myForm1").attr('action', '/products');
                $.ajax({
                    url: '/products',
                    type: 'POST',
                    dataType: 'json',
                    data: {id: id, action: delete},
                    success: function(data)
                    {
                        alert("Это PRODUCTS");
                    }
                });
                break;
            }
        }
    });
});