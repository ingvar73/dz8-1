/**
 * Created by ingvar73 on 15.09.2016.
 */
// $(function () {
//    $.(".btn_create").click(function () {
//       var login = $("#login").val();
//       var name = $("#name").val();
//       var email = $("#email").val();
//       var age = $("#age").val();
//       var about = $("#about").val();
//       var avatar = $("#avatar").val();
//       var password = $("#password").val();
//
//          $.ajax({
//             url: 'http://dz8.rest/user',
//             type: 'POST',
//             dataType: 'json',
//             data: {login: login, name: name, email: email, age: age, about: about, avatar: avatar, password: password, action: create},
//             success: function(data)
//             {
//                $("#data").html(data);
//             }
//          });
//    })
// });

/**
 * Второй вариант с использованием jquery.form
 *
 **/

$(document).ready(function () {

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

// $.each(data, function (i, v) {
//    $('#'+i).val(v);
// });

/***
 *
 * $.each(data, function(i, v){
$('#'+i).val(v);
};
 */


// $(document).ready(function () {
//
//     $("#myForm1").ajaxForm(
//         {
//             dataType: 'json',
//             data: {id: id, action: delete},
//             success: function (data) {
//
//                 $.each(data, function (i, v) {
//                     $('#'+i).val(v);
//                 });
//             }
//         }
//     );
//
// });

$(function () {
   $.(".btn_delete").click(function (e) {
       e.preventDefault();
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
            }
            error: function (data) {
                console.log(data);
            }
         });
   })
});