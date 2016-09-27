/**
 * Created by admin-pc on 27.09.2016.
 */
$.ajax({
    url:"/user",
    type:"POST",
    dataType: 'json',
    data: {login: login, name: name, email: email, age: age, about: about, password: password, avatar: avatar, url: url},
    success:function(data){
        $("").html(data);
        var temp = data.login+" "+data.name+" "+data.email+" "+data.age+" "+data.about+" "+data.password+" "+data.avatar;
    }
});