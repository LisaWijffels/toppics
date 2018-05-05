$('.show_more').on("click", function(){
    console.log("Clicked loadmoare");
    var lastPic = $(".feed .feed__post:last-child");
    var lastId = lastPic.attr('data-id');
    console.log("Data id " +lastId);
    $.ajax({
        type: "POST",
        url: "ajax/showMore.php",
        data: { lastId : lastId},
        
    }).done(function( res ) { 
        console.log("Data Saved: "+ res);
        
        for(var i = 0; i < res.length; i++) {
            $divPost = $(`<div class="feed__post" data-id="`+res[i]['post_id']+`">`);
            $content = $(`<div class="flexrow flex_between"><p class="feed__postUser"><?php echo $p['username']?></p><?php if($p['username'] == $_SESSION['username']): ?><a class="link__edit button" href="editpost.php?post=<?php echo $p['post_id']; ?>">✏️</a><?php endif; ?></div>
                    <a href="details.php?post=`+res[i]['post_id']+`">
                    <img class="feed__postImg" src="post_images/ `+res[i]['post_image']+`"></a>
                    <p class="feed__postDesc">`+res[i]['post_desc']+`</p>
                    
                    <div class="feed__flex">  
                        <p class="feed__postLikes">💗`+['post_likes']+` likes</p>
                        <a href="details.php?post=`+res[i]['post_id']+`" class="feed__postComments">💬</a>
                        <p class="feed__postDate">`+res[i]['post_date']+`</p>
                    </div>`);
            
            console.log(res[i]['post_id']);
            $($divPost).append($content);
            $(".feed").append($divPost);
        }
    }).fail(function(res)  {
        console.log("Sorry. Ajax failed");
    });
});