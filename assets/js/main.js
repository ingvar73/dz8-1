// удаление по id
function select_table () {
    var form = document.querySelector("form");
    console.log(form.elements[1].type);
}

$(document).ready(function (e) {
    e.preventDefault();
   $("#myForm").ajaxForm(
       {
          dataType: 'json',
          data: {login: login, name: name, email: email, age: age, about: about, password: password, action: create},
          success: function (data) {

              $.each(data, function (i, v) {
                $('#'+i).val(v);
                });
             var temp = data.login+" "+data.name+" "+data.email+" "+data.age+" "+data.about+" "+data.password;
             $('#data').text(temp);
          }
       }
   );

});



$.(".btn_delete").click(function () {
      var id = $("#id").val();
      var action = $("#action").val();
         $.ajax({
            url: '/user',
            type: 'POST',
            dataType: 'json',
            data: {id: id, action: delete},
            success: function(data)
            {
               $("#data").html(data);
                console.log(data);
            },
            error: function (data) {
                console.log(data)
            };
         });
   });