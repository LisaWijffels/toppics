$(".feed__postLikes").on("click", function(e) {
    let likes = $(".postLikes").html();
    let postID = $(".post__id").attr("data-id");

    console.log(likes);
    console.log(postID);

   $.ajax({
        method: "POST",
        url: "ajax/addLike.php",
        data: { likes: likes, postID: postID }
   })
   .done(function( res ) {

    if( res.status == "success") {
        
    }
});



    e.preventDefault();
});