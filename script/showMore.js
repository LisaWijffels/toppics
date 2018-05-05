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
        console.log("Session user = "+res.user);
        console.log("Post user = "+res.posts[1]['username']);
        
        for(var i = 0; i < res.posts.length; i++) {
            if(res.user == res.posts[i]['username']){
                console.log("SAME USER");
                $content = $(`<div class="flexrow flex_between">
            <p class="feed__postUser">${res.posts[i]['username']}</p>
            <a class="link__edit button" href="editpost.php?post=${res.posts[i]['post_id']}">✏️</a>
            <a class="link__block button" href="#" data-id="${res.posts[i]['post_id']}" >⛔</a></div>
            <a href="details.php?post=${res.posts[i]['post_id']}">
            <img class="feed__postImg" src="post_images/ ${res.posts[i]['post_image']}"></a>
            <p class="feed__postDesc">${res.posts[i]['post_desc']}</p>
            <div class="feed__flex">  
                <p class="feed__postLikes">💗${['post_likes']} likes</p>
                <a href="details.php?post=${res.posts[i]['post_id']}" class="feed__postComments">💬</a>
                <p class="feed__postDate">${res.posts[i]['post_date']}</p>
            </div>`);

            } else {
                console.log("OTHER USER");
                $content = $(`<div class="flexrow flex_between">
            <p class="feed__postUser">${res.posts[i]['username']}</p>
            
            <a class="link__block button" href="#" data-id="${res.posts[i]['post_id']}" >⛔</a></div>
            <a href="details.php?post=${res.posts[i]['post_id']}">
            <img class="feed__postImg" src="post_images/ ${res.posts[i]['post_image']}"></a>
            <p class="feed__postDesc">${res.posts[i]['post_desc']}</p>
            <div class="feed__flex">  
                <p class="feed__postLikes">💗${res.posts[i]['post_likes']} likes</p>
                <a href="details.php?post=${res.posts[i]['post_id']}" class="feed__postComments">💬</a>
                <p class="feed__postDate">${res.posts[i]['post_date']}</p>
            </div>`);
                

            }
            $divPost = $(`<div class="feed__post" data-id="${res.posts[i]['post_id']}">`);
            
            
            
            $($divPost).append($content);
            $(".feed").append($divPost);
        }
    }).fail(function(res)  {
        console.log("Sorry. Ajax failed");
    });
});