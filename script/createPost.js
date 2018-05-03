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
    $('#posted_image').toggleClass('hidden visible');
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
                        <div class="feed__post">
                            <p class="feed__postUser">${res.post_user}</p>
                            <img class="feed__postImg" src="post_images/ ${res.post_image}"></a>
                            <p class="feed__postDesc">${post_desc}</p>
                            <div class="feed__flex">  
                                <p class="feed__postLikes">💗${"0"} likes</p>
                                <p class="feed__postDate">${res.post_date}</p>
                            </div>
                            
                        </div>`;
                $(".feed").prepend(newPost);

            } else {
                console.log("Ajax not getting right value");
            }

        }).fail(function (res) {
            console.log("Sorry. Ajax failed ");
        });

    } catch ($e) {
        var newError = `<div class="error"><p>${$e}</p></div>`;
        $("main").prepend(newError);
    }
});

