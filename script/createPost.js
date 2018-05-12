function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var image = e.target.result;
            $('#posted_image').css('background-image', 'url(' + image + ')');

        }
        
         reader.readAsDataURL(input.files[0]);
    }
}

$("#post_image").change(function () {
    console.log("file changed");
    var file = $('#post_image')[0].files[0];
    var filesize = file.size;
    console.log(filesize);
    if(filesize > 1000000){
        var newError = `<p>File size is too big, please pick a picture smaller than 1MB.</p>`;
        
        $(".errorMessage").fadeIn();
        $(".errorMessage").append(newError);
    } else {
        if($('#posted_image').hasClass( "visible" )){

        } else {
            $('#posted_image').toggleClass('hidden visible');
        }

        $(".errorMessage").empty();
        $(".errorMessage").hide();
    }
    
    
    readURL(this);
});

$("#buttondrop").on("click", function (e) {
    e.preventDefault();

    var file = $('#post_image')[0].files[0];
    
    var post_desc = $(".post_desc").val();

    try {
        if (file == null) {
            throw "Please upload a picture";
        }

        if (post_desc == "") {
            throw "Please enter a description.";
        }

        var filesize = file.size;

        if (filesize > 1000000){
            throw "File size is too big, please pick a picture smaller than 1MB.";
        }

        $(".errorMessage").empty();
        $(".errorMessage").fadeOut();

        var post_tags = $(".post_tags").val();

        var form = new FormData();
        form.append("post_image", file);
        form.append("post_desc", post_desc);
        form.append("post_tags", post_tags);

        $.ajax({
            type: "POST",
            url: "ajax/addPost.ajax.php",
            data: form,
            contentType: false,
            processData: false,
        }).done(function (res) {
            console.log("Data Saved: " + res.status);
            if (res.status == "success") {
                //append new post
                console.log("Ajax was successfull");

                var newPost = `
                        <div class="feed__post" data-id="${res.post_id}">
                            <div class="flexrow flex_between">
                                <a href="user.php?user=${res.post_user}" class="feed__postUser">${res.post_user}</a>
                            
                            <a class="link__block button" href="#" data-id="${res.post_id}">⛔</a>
                        </div>
                        <a href="details.php?post=${res.post_id}" class="post__id" data-id="${res.post_id}">
                        <img class="feed__postImg" src="post_images/ ${res.post_image}"></a>
                        <p class="feed__postDesc">${res.post_desc}</p>
                        
                        <div class="feed__flex">  
                            <p class="feed__postLikes" data-like="like" data-id="${res.post_id}" >
                            💗<span class="postLikes">0</span> likes</p>

                            <a href="details.php?post=${res.post_id}" class="feed__postComments">💬</a>

                            
                            <p class="feed__postDate">Just now</p>

                            
                        </div>
                    </div>`;
                $(".feed").prepend(newPost);
                $('#postForm')[0].reset();
                $('#posted_image').toggleClass('visible hidden');

            } else {
                console.log("Ajax not getting right value");
            }

        }).fail(function (res) {
            console.log("Sorry. Ajax failed ");
        });

    } catch ($e) {
        var newError = `<p>${$e}</p>`;
        $(".errorMessage").fadeIn();
        $(".errorMessage").append(newError);
    }
});

