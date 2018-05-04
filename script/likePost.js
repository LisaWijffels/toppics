$(".feed__postLikes").on("click", function(e) {
    let thisPost = $(this);
    let thisPostSpan = $(this).children("span");
    let likes = thisPostSpan.html();
    let likeUnlike = thisPost.attr("data-like");
    let postID = thisPost.attr("data-id");

    //console.log(likes);
    //console.log(postID);
    //console.log(likeUnlike);

    $.ajax({
        type: "POST",
        url: "ajax/addLike.php",
        data: { likes : likes, postID : postID, likeUnlike : likeUnlike },

    }).done(function(res){

        let like = thisPostSpan.html(res.likes);
        let dataId = thisPost.attr("data-like", res.likeUnlike);

    }).fail(function(res){
        console.log("ajax fail");
    });

});


