$(".feed__postLikes").on("click", function(e) {
    let thisPost = $(this);
    let thisPostSpan = $(this).children("span");
    let likes = thisPostSpan.html();
    let postID = thisPost.attr("data-id");

    console.log(likes);
    console.log(postID);

    $.ajax({
        type: "POST",
        url: "ajax/addLike.php",
        data: { likes : likes, postID : postID },

    }).done(function(res){
        
        let like = thisPostSpan.html(res.likes);

    }).fail(function(res){
        console.log("ajax fail");
    });

});