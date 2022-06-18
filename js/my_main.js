function dodajPost(){
    let naslov = $("#naslovPost");
    let kat_id = $("#postCat");
    let tekst = $("#tekstPost");
    let slika = $("#slika");
    const naslovReg = /^[A-Z0-9][a-z0-9]+(\s\w+|\d+|\W)+$/;
    let brojErr = 0;
    if(!naslovReg.test(naslov.val()) || naslov.val().length < 20 || naslov.val().length > 100){
        if(!$('#titleErr').length){
            let err = '<p id="titleErr" class="alert-danger alert mt-1">Title must start with capital letter and contain min 20 letters and max 100 letters.</p>';
            $(err).insertAfter(naslov);
            naslov.css('border', '1px solid red');
        }
        brojErr++;
    }
    else{
        $("#titleErr").remove();
        naslov.css('border', '1px solid rgba(0,0,0,0.1)');
    }
    if(kat_id.val() == 0){
        if(!$('#katErr').length){
            let err = '<p id="katErr" class="alert-danger alert mt-1">You must choose category.</p>';
            $(err).insertAfter(kat_id);
            kat_id.css('border', '1px solid red');
        }
        brojErr++;
    }
    else {
        $("#katErr").remove();
        kat_id.css('border', '1px solid rgba(0,0,0,0.1)');
    }
    if(!slika.data("optional")){
        if(!slika.val()){
            if(!$("#slikaErr").length){
                let err = '<p id="slikaErr" class="alert-danger alert mt-1">Please choose an image.</p>';
                $(err).insertAfter(slika);
            }
            brojErr++;
        }
        else{
            $("#slikaErr").remove();
        }
    }

    if(tekst.val().length < 150){
        if(!$('#tekstErr').length){
            let err = '<p id="tekstErr" class="alert-danger alert mt-1">Content must contain at least 150 characters.</p>';
            $(err).insertAfter(tekst);
            tekst.css('border', '1px solid red');
        }
        brojErr++;
    }
    else{
        $("#tekstErr").remove();
        tekst.css('border', '1px solid rgba(0,0,0,0.1)');
    }
    if(!brojErr){
        return true;
    }
    else{
        return false;
    }
}
function proveriPoruku(){
    const fullnameReg = /^([\w]{3,})+\s+([\w\s]{3,})+$/i;
    const emailReg = /^[a-z][a-z\.\d\-\_]+\@[a-z]+(\.[a-z]+)+$/;
    const messReg = /^.{20,500}$/;
    let brojGresaka = 0;
    let fullname = $("#fullname");
    let mail = $("#mail");
    let message = $("#messContent");
    if(!fullnameReg.test(fullname.val())){
        if(!$(".nameErr").length) {
            fullname.css('border', '2px solid red');
            let err = '<p class="alert-danger nameErr">First name/last name must contain at least 3 letters</p>';
            $(err).insertAfter($(fullname));
        }
        brojGresaka++
    }
    else {
        fullname.css('border', '2px solid rgba(0,0,0,0.1)');
        $(".nameErr").remove();
    }
    if(!emailReg.test(mail.val())){
        if(!$(".mailErr").length){
            mail.css('border', '2px solid red');
            let err = '<p class="alert-danger mailErr">E.q. johndoe@gmail.com</p>';
            $(err).insertAfter($(mail));
        }
        brojGresaka++;
    }
    else {
        mail.css('border', '2px solid rgba(0,0,0,0.1)');
        $(".mailErr").remove();
    }
    if(!messReg.test(message.val())){
        if(!$(".messErr").length) {
            message.css('border', '2px solid red');
            let err = '<p class="alert-danger messErr">Message length must be between 20 and 500 letters</p>';
            $(err).insertAfter($(message));
        }
        brojGresaka++;
    }
    else {
        message.css('border', '2px solid rgba(0,0,0,0.1)');
        $(".messErr").remove();
    }
    console.log(brojGresaka)
    if(brojGresaka){
        return false;
    }
    else{
        return true;
    }

}
function proveriKat(){
    let catReg = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,19}(\s[a-zšđčćž]{2,19})*$/;
    let text = $("#addKat");
    if(!catReg.test(text.val())){
        $(text).css('border', '2px solid red');
        if(!$("#catErr").length) {
            let err = '<p class="my-1 alert-danger alert" id="catErr">Category name must start with uppercase letter and cannot contain symbols or digits.</p>'
            $(err).insertAfter(text);
        }return false;
    }
    else{
        return true;
    }
}
function proveriSurvey(){
    let odgovori = $(".odg");
    let pitanje = $('#pitanje');
    let reg = /[A-ZŠĐČĆŽ][a-zšđčćž]{1,19}(\s[a-zšđčćž]{2,19})*[?]/;
    let regOdg = /[A-ZŠĐČĆŽ][a-zšđčćž]{1,19}(\s[a-zšđčćž]{2,19})*/;
    let greske = 0;
    for(let x of odgovori){
        if(!regOdg.test($(x).val())){
            $(x).css('border', '1px solid red');
            $(x).val( 'Answer must contain only letters and must start with a capital letter.');
            greske++;
        }
        else{
            $(x).css('border', '1px solid rgba(0,0,0,0.1)');
        }
    }
    if(!reg.test(pitanje.val())){
        greske++;
        pitanje.css('border', '1px solid red');
        pitanje.val( 'Question must contain only letters,question mark and must start with a capital letter.');
    }
    else{
        pitanje.css('border', '1px solid rgba(0,0,0,0.1)');
    }
    if(greske){
        return false;
    }
    else{
        return true;
    }
}
$(document).ready(()=>{

    let emailReg = /^[a-z][a-z\.\d-\_]+\@[a-z]+(\.[a-z]+)+$/;
    let passReg = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/;

    //region Registracija AJAX
    $('#registerBtn').on("click", function(){
        proveraRegistracija();
        $("#msg").html('');
    })
    function proveraRegistracija(){
        let imePrezime = $('#fullname');
        let email = $('#email');
        let password = $('#password');
        let passwordConfirm = $('#passwordConfirm');
        let brojGresaka = 0;
        let nameReg = /^[A-ZŠĐČĆŽ][a-zšđčćž]{2,}(\s[A-ZŠĐČĆŽ][a-zšđčćž]{2,})+$/;


        if(!nameReg.test(imePrezime.val())){
            if(!$('#nameErr').length){
                let err = '<p id="nameErr" class="alert-danger alert mt-1">E.q John Doe</p>'
                imePrezime.css('border', '2px solid red');
                $(err).insertAfter(imePrezime);
            }
            brojGresaka++;
        }
        else{
            imePrezime.css('border', '1px solid rgba(0,0,0,0.1)');
            if($('#nameErr').length){
                $('#nameErr').remove();
            }
        }
        if(!emailReg.test(email.val())){
            if(!$('#mailErr').length){
                let err = '<p id="mailErr" class="alert-danger alert mt-1">E.q. johndoe@something.com</p>'
                email.css('border', '2px solid red');
                $(err).insertAfter(email);
            }
            brojGresaka++
        }
        else{
            email.css('border', '1px solid rgba(0,0,0,0.1)');
            if($('#mailErr').length){
                $('#mailErr').remove();
            }
        }
        if(!passReg.test(password.val())){
            if(!$('#passErr').length){
                let err = '<p id="passErr" class="alert-danger alert mt-1">Password must contain at least 8 letters, 1 symbol, 1 uppercase letter, 1 lowercase and 1 number.</p>'
                password.css('border', '2px solid red');
                $(err).insertAfter(password);
            }
            brojGresaka++;
        }
        else{
            password.css('border', '1px solid rgba(0,0,0,0.1)');
            if($('#passErr').length){
                $('#passErr').remove();
            }
        }
        if(!(password.val() == passwordConfirm.val())){
            if(!$("#passConfirmErr").length){
                let err = '<p id="passConfirmErr" class="alert-danger alert mt-1">Password does not match.</p>';
                $(err).insertAfter(passwordConfirm);
            }
            passwordConfirm.css('border', '2px solid red');
            brojGresaka++;
        }
        else if(password.val() == passwordConfirm.val() && passwordConfirm.val().length){
            passwordConfirm.css('border', '1px solid rgba(0,0,0,0.1)');
            $('#passConfirmErr').remove();
        }
        else{
            brojGresaka++;
        }
        if(!brojGresaka){
            ajaxCall('obradaRegistracija.php', imePrezime, email, password, passwordConfirm);
        }
    }
    function ajaxCall (path, name, mail, pass, passConfirm){
        $.ajax({
            url : 'models/' + path,
            type : 'POST',
            data : {
                imePrezime : name.val(),
                email : mail.val(),
                password : pass.val(),
                passwordConfirm : passConfirm.val()
            },
            success : function(response){
                let value = response;
                $('#msg').html(value.msg);
                setTimeout(function(){
                    window.location.href = 'login.php';
                }, 1000);
            },
            error : function (msg){
                $('#msg').html(JSON.parse(msg.responseText).msg);
            }
        })
    }
    //endregion

    //region Logovanje
    $("#login").on('click', function(){
        proveraLogovanje();
        $("#msgLog").html('');
    });

    function proveraLogovanje(){
        let email =  $('#emailLog');
        let pass = $("#passwordLog");
        let brojGresaka = 0;
        if(!email.val().length){
            brojGresaka++;
            email.css('border', '1px solid red');
        }
        else{
            email.css('border', '1px solid rgba(0, 0, 0, 0.1)');
        }
        if(!pass.val().length){
            brojGresaka++;
            pass.css('border', '1px solid red');
        }
        else{
            pass.css('border', '1px solid rgba(0, 0, 0, 0.1)');
        }
        if(!brojGresaka && emailReg.test(email.val()) && passReg.test(pass.val())){
            $.ajax({
                url : "models/obradaLogovanje.php",
                type: "POST",
                dataType : "json",
                data : {
                    email : email.val(),
                    pass : pass.val()
                },
                success : function(response){
                    window.location.href = 'profile.php'
                },
                error : function (response, xhr, msg) {
                    $("#msgLog").html(JSON.parse(response.responseText).msg);
                }
            })
        }
    }
    //endregion
    //region Unos postova

    //endregion
    //region Dohvatanje postova
    function getAllPostsUser(){
        $.ajax({
            url : 'models/dohvatiPostoveUser.php',
            type : 'GET',
            dataType : 'json',
            success : function (result){
                showUserPosts(result);
            },
            error : function (msg){
                console.log(msg);
            }
        })
    }

    //endregion
    $(document).on('click', '.del',function (){
        editDeletePost($(this).data('id'), 'obradaDeletePost', $(this));
    })
    $(document).on('click','#updatePost', function (){
        editDeletePost($(this).data('id'), 'obradaIzmenaPostova', $(this));
    })
    function editDeletePost(id_post, path, button){
        var dataToSend;
        if(button[0].id.indexOf('update') != -1){
            dataToSend = {
                id_post : id_post,
                naslov: $("#header").val(),
                tekst : $("#textNew").val()
            }
        }
        else{
            dataToSend = {
                id_post
            }
        }
        $.ajax({
            url : 'models/' + path + '.php',
            type : 'POST',
            data: dataToSend,
            dataType : 'json',
            success : function (result){
                $("#porukaED").html(result.msg);
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            },
            error : function (msg) {
                $("#porukaED").html(msg.msg);
            }
        })
    }
    $("#sendComment").on("click", function (){
        let msg = $('#message');
        if(msg.val().length < 20){
            msg.css('border', '2px solid red');
            $("#msgComment").html('Comment must contain at least 20 characters.');
        }
        else{
            msg.css('border', '1px solid rgba(0,0,0,0.1)');
            $("#msgComment").html('');
            $.ajax({
                url : 'models/obradaComment.php',
                data : {
                    message : $(msg).val(),
                    id_post : $(msg).data('id')
                },
                type : 'POST',
                dataType : 'json',
                success : function(result){
                    $("#msgComment").html(result.msg);
                    setTimeout(function(){
                        window.location.reload();
                    }, 1500)
                },
                error : function (msg){
                    $("#msgComment").html(msg.msg);
                }
            })
        }
    })


    function getAllUsers(){
        $.ajax({
            url : 'models/masterGetAllUsers.php',
            dataType : 'json',
            type : 'GET',
            success : function(result){
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    }
    $("#allUsers").on('click', function (){
        getAllUsers();
    })

    $(document).on("click",".delUser", function(){
        let id = this.dataset.user;
        $.ajax({
            url : 'models/obradaDeleteUser.php',
            dataType : 'json',
            data : {
                user_id : id
            },
            type : 'POST',
            success : function(result){
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function (){
                    window.location.reload();
                }, 2000);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $('#allPosts').on('click', function (){
        getAllPosts();
    })
    function getAllPosts(){
        $.ajax({
            url : 'models/masterGetAllPosts.php',
            dataType : 'json',
            type : 'GET',
            success : function(result){
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    }

    $(document).on('click', '.editPost',function (){
        let id = this.dataset.post;
        $.ajax({
            url : 'models/obradaIzmenaPostova.php',
            dataType : 'json',
            data :{
                id_post : id
            },
            type : 'POST',
            success : function(result){
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '#update',function (){
        const headlineRegEx = /^[A-ZŠĐČĆŽ]$/;
        let id = this.dataset.id;
        let naslov = $("#headline");
        let category = $("#category");
        let tekst = $("#tekst");
        let brojGreska = 0;
        if(!headlineRegEx.test(naslov.val().charAt(0)) || naslov.val().length < 20 || naslov.val().length > 100){
            if(!$("#headlineErr").length){
                let greska = '<p id="headlineErr">Headline must start with capital letter and must contain min 20 characters and max 100.</p>';
                $(naslov).css('border', '1px solid red');
                $(greska).insertAfter(naslov);
                brojGreska++;
            }
        }else{
            $(naslov).css('border', '1px solid rgba(0,0,0,0.1)');
        }
        if(tekst.val().length < 100){
            if(!$("#tekstErr").length){
                let greska = '<p id="tekstErr">Text content must contain at least 100 characters.</p>';
                $(tekst).css('border', '1px solid red');
                $(greska).insertAfter(tekst);
                brojGreska++;
            }
        }else{
            $(tekst).css('border', '1px solid rgba(0,0,0,0.1)');
        }
        if(!brojGreska){
            $.ajax({
                url : 'models/izmeniPost.php',
                dataType : 'json',
                data :{
                    id_post : id,
                    naslov : naslov.val(),
                    cat_id : category.val(),
                    tekst : tekst.val()
                },
                type : 'POST',
                success : function(result){
                    $('#messageAdmin').modal('show');
                    $('#messageAdmin').find('.modal-body').html(result.msg);
                    setTimeout(function (){
                        window.location.reload();
                    }, 2000);
                },
                error: function(msg){
                    $("#adminContent").html(JSON.parse(msg.responseText).msg)
                }
            })
        }

    })
    $(document).on('click', '.delPost', function (){
        let id = this.dataset.post;
        $.ajax({
            url : 'models/obradaBrisanjePostova.php',
            dataType : 'json',
            data :{
                id_post : id
            },
            type : 'POST',
            success : function(result){
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function (){
                    window.location.reload();
                }, 2000);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '.delComm', function (){
        let id = this.dataset.comment;
        $.ajax({
            url : 'models/obradaBrisanjeKomentara.php',
            dataType : 'json',
            data :{
                id_kom : id
            },
            type : 'POST',
            success : function(result){
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function (){
                    window.location.reload();
                }, 2000);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('submit', '#newsletter', function (e){
        e.preventDefault();
        let email = $("#newsletterMail");
        if(!email.val().length){
            email.css('border', '2px solid red');
            $("#newsMess").html('E.q. johndoe@gmail.com');
        }
        else{
            email.css('border', '2px solid rgba(0,0,0,0.1)');
            $("#newsMess").html('');
            $.ajax({
                url : 'models/obradaNewsletter.php',
                dataType : 'json',
                data :{
                    email : email.val()
                },
                type : 'POST',
                success : function(result){
                    $('#messageAdmin').modal('show');
                    $('#messageAdmin').find('.modal-body').html(result.msg);
                },
                error: function(msg){
                    console.log(msg.responseText)
                    $('#messageAdmin').modal('show');
                    $('#messageAdmin').find('.modal-body').html(JSON.parse(msg.responseText).msg);
                }
            })
        }


    })

    $('#newsletterShow').on('click',function(){
        $.ajax({
            url : 'models/dohvatiNewsletter.php',
            dataType : 'json',
            type : 'GET',
            success : function(result){
                console.log(result);
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    });
    $("#messages").on('click', function(){
        $.ajax({
            url : 'models/dohvatiPoruke.php',
            dataType : 'json',
            type : 'GET',
            success : function(result){
                console.log(result);
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $("#categoriesShow").on('click', function(){
        $.ajax({
            url : 'models/dohvatiKategorije.php',
            dataType : 'json',
            type : 'GET',
            success : function(result){
                console.log(result);
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $("#manageSurvey").on('click', function(){
        $.ajax({
            url : 'models/dohvatiSurvey.php',
            dataType : 'json',
            type : 'GET',
            success : function(result){
                console.log(result);
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '.editCat',function (){
        let id = this.dataset.category;
        $.ajax({
            url : 'models/obradaIzmenaKategorija.php',
            dataType : 'json',
            data :{
                id_cat : id
            },
            type : 'POST',
            success : function(result){
                $("#adminContent").html(result);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '.delNewsletter',function (){
        let id = $(this).data('post');
        console.log(id)
        $.ajax({
            url : 'models/obradaBrisanjeNewsletter.php',
            dataType : 'json',
            data :{
                id_news : id
            },
            type : 'POST',
            success : function(result){
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function (){
                    window.location.reload();
                }, 2000);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '.delMessage',function (){
        let id = $(this).data('message');
        $.ajax({
            url : 'models/obradaBrisanjePoruke.php',
            dataType : 'json',
            data :{
                id_mess : id
            },
            type : 'POST',
            success : function(result){
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function (){
                    window.location.reload();
                }, 2000);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '.addPost',function (){
        $.ajax({
            url : 'models/dohvatiKategorijeZaUnos.php',
            dataType : 'json',
            type : 'GET',
            success : function(result){
                ispisi(result)
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
        function ispisi(kategorije){
            let forma = `<form onSubmit="return dodajPost();" enctype="multipart/form-data" action="models/obradaPost.php" method="post">
                        <label for="naslovPost" class="">Title:</label>
                        <input type="text" id="naslovPost" class="form-control" name="naslovPost"/>
                        <label for="postCat" class="">Category</label>
                        <select name="postCat" id="postCat" class="form-control">
                            <option value="0">Choose</option>
                            ${kategorije}
                        </select>
                        <label for="slika">Image:</label>
                        <input type="file" class="form-control-file" id="slika" size="50" name="slika"/>
                        <label for="tekstPost">Post content:</label>
                        <textarea rows="20" name="tekstPost" id="tekstPost" class="form-control"></textarea>
                        <input type="submit" name="posaljiPost" value="Create a post">
                    </form>`
            $("#adminContent").html(forma);
        }
    })
    $(document).on('click', '.addCat',function(){
        let content = `<form method="post" action="models/obradaDodajKategoriju.php" onsubmit="return proveriKat()">
        <label for="kat">New category name:</label>
        <input type="text" class="form-control" name="newKat" id="addKat">
        <button type="submit" name="addKat" class="btn btn-primary mt-2">Add new category
        </button></form>`;
        $("#adminContent").html(content);
    })
    $(document).on('click', '.delCat',function () {
        let id = $(this).data('category');
        $.ajax({
            url: 'models/obradaBrisanjeKategorije.php',
            dataType: 'json',
            data: {
                id_cat: id
            },
            type: 'POST',
            success: function (result) {
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            },
            error: function (msg) {
                console.log(msg)
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '.editCat',function () {
        let proveri = proveriKat();
        if(proveri){
            let id = $(this).data('id');
            $.ajax({
                url: 'models/obradaIzmenaKategorije.php',
                dataType: 'json',
                data: {
                    id_cat: id
                },
                type: 'POST',
                success: function (result) {
                    $('#messageAdmin').modal('show');
                    $('#messageAdmin').find('.modal-body').html(result.msg);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                },
                error: function (msg) {
                    console.log(msg)
                    $("#adminContent").html(JSON.parse(msg.responseText).msg)
                }
            })
        }

    })
    $(document).on('click', '.activate', function(){
        console.log($(this).data('survey'))
        let id = $(this).data('survey');
        $.ajax({
            url : 'models/aktivirajAnketu.php',
            dataType : 'json',
            data :{
                id_survey : id
            },
            type : 'POST',
            success : function(result){
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function (){
                    window.location.reload();
                }, 2000);
            },
            error: function(msg){
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })
    $(document).on('click', '.addSurvey', function(){
        let form = `<form method="post" action="models/unesiSurvey.php" onsubmit=" return proveriSurvey();">
                            <div id="surveyForm">
                            <label for="pitanje">Survey question:</label>
                            <input type="text" name="pitanje" id="pitanje" class="form-control">
                            <label for="answer">Survey answer 1:</label>
                            <input type="text" name="answer[]" id="answer1" class="form-control odg odg1">
                            </div>
                            <button type="button" name="addAnswer" id="addAnswer" class="btn btn-light mt-1">Add a new answer</button>
                            <button type="submit" name="addSurvey" value="1" class="btn btn-primary mt-1">Add</button>
                            </form>`;
        $("#adminContent").html(form);
        var brojOdgovora = 1;
        $(document).on('click', '#addAnswer',function(){
            let odgovor =  `<label>Survey answer ${++brojOdgovora}:</label>
        <input type="text" name="answer[]" class="form-control odg odg${brojOdgovora}">`;
            $("#surveyForm").append($(odgovor));
        })
    })
    $(document).on('click', '.deleteSurvey',function () {
        let id = $(this).data('survey');
        $.ajax({
            url: 'models/obradaBrisanjeAnketa.php',
            dataType: 'json',
            data: {
                id: id
            },
            type: 'POST',
            success: function (result) {
                $('#messageAdmin').modal('show');
                $('#messageAdmin').find('.modal-body').html(result.msg);
                setTimeout(function () {
                    window.location.reload();
                }, 2000);
            },
            error: function (msg) {
                console.log(msg)
                $("#adminContent").html(JSON.parse(msg.responseText).msg)
            }
        })
    })

})
