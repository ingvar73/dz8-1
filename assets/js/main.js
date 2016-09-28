// удаление по id
function select_table_del () {
    $('#sel_tab_del').change(function () {
        var selectedOption = $('#sel_tab_del option:selected');
    });
}

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


$.(".btn_delete").click(function () {
      var id = $("#id").val();
      var action = $("#action").val();
    sel = select_table_del();
    switch (sel){
        case 'users':{
        $('#myForm1').setAttribute('action', '/users');
            $.ajax({
                url: '/users',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: delete},
                success: function(data)
                {
                    console.log(data);
                }
            });
            break;
        }
    case 'orders': {
        $('#myForm1').setAttribute('action', '/orders');
        $.ajax(
            {
            url: '/orders',
            type: 'POST',
            dataType: 'json',
            data: {id: id, action: delete},
            success: function(data)
            {
                console.log(data);
            }
        });
        break;
        }
    case 'products': {
        $('#myForm1').setAttribute('action', 'products');
            $.ajax({
                url: '/products',
                type: 'POST',
                dataType: 'json',
                data: {id: id, action: delete},
                success: function(data)
                {
                    console.log(data);
                }
        });
            break;
        }
    }
   });