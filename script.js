$(document).ready(function  (){
    $.ajax({
        url: '/api/users/read.php',
        type: 'get',
        dataType: 'JSON',
        success: function(response){
            response = response["records"];
            var len = response.length;
            for(var i=0; i<len; i++){
                var id = response[i].id;
                var name = response[i].name;
                var email = response[i].email;

                var tr_str = "<tr id='td"+i+"'>" +
                    "<td align='center'>" + id + "</td>" +
                    "<td align='center'>" + "<a href='/api/"+name+"'>" + name +"</a>" + "</td>" +
                    "<td align='center'>" + email + "</td>" +
                    "<td align='center'>" + "<button type='button' onclick=' $.ajax({\n" +
                    "        url:\"/api/users/delete.php\", \n" +
                    "        type: \"GET\", \n" +
                    "        data: { id:"+(id)+"}, \n" +
                    "        success:function(){\n" +
                    "         $(\"#td"+i+"\").fadeOut(1000, function(){ $(this).remove(); })\n" +
                    "        }\n" +
                    "    }); ' >Delete</button>" + "</td>" +
                    "</tr>";

                $("#userTable tbody").append(tr_str);
            }

        },
    });
});

$(function () {
    $('form').bind('submit', function () {
        $.ajax({
            type: 'GET',
            url: '/api/users/create.php',
            data: $('form').serialize(),
            success: function (result) {
                alert(result["message"]) && reload();;
            }
        });
        return false;
    });
});

