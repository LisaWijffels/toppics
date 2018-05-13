$('.show_more').on("click", function(){
    console.log("Clicked loadmoare");
    var lastPic = $(".feed .feed__post:last-child");
    var lastId = lastPic.attr('data-id');
    console.log("Data id " +lastId);
    $.ajax({
        type: "POST",
        url: "ajax/showMore.php",
        data: { lastId : lastId },
        
    }).done(function( res ) { 
        console.log("Session user = "+res.user);
        console.log("Post user = "+res.posts[1]['username']);
        
        for(var i = 0; i < res.posts.length; i++) {
                console.log("OTHER USER");
                $content = $(`<div class="flexrow flex_between flex_align_center">
            <a href="user.php?user=${res.posts[i]['username']}" data-id="${res.posts[i]['id']}" class="feed__postUser">${res.posts[i]['username']}</a>
            
            <a class="link__block button" href="#" title="report picture" data-id="${res.posts[i]['post_id']}" >⛔</a></div>
            <a href="details.php?post=${res.posts[i]['post_id']}">
            <img class="feed__postImg" src="post_images/ ${res.posts[i]['post_image']}"></a>
            <p class="feed__postDesc">${res.posts[i]['post_desc']}</p>
            <div class="feed__flex">  
                <p class="feed__postLikes" title="like" data-like="like" data-id="${res.posts[i]['post_id']}">💗 
                <span class="postLikes">${res.posts[i]['post_likes']}</span> likes </p>
                <a href="details.php?post=${res.posts[i]['post_id']}" title="comment" class="feed__postComments">💬</a>
                <p class="feed__postDate">${res.posts[i]['post_date']}</p>
            </div>`);
            
            $divPost = $(`<div class="feed__post" data-id="${res.posts[i]['post_id']}">`);         
            
            $($divPost).append($content);
            $(".feed").append($divPost);
        }
    }).fail(function(res)  {
        console.log("Sorry. Ajax failed");
    });
});


$('.show_more_follow').on("click", function(){
    console.log("Clicked loadmoare follow");
    var lastPic = $(".feed .feed__post:last-child");
    var lastId = lastPic.attr('data-id');
    console.log("Data id " +lastId);
    $.ajax({
        type: "POST",
        url: "ajax/showMoreFollow.php",
        data: { lastId : lastId},
        
    }).done(function( res ) { 
        console.log("Session user = "+res.user);
        console.log("Post user = "+res.posts[1]['username']);
        
        for(var i = 0; i < res.posts.length; i++) {
            if(res.user == res.posts[i]['username']){
                console.log("SAME USER");
                $content = $(`<div class="flexrow flex_between flex_align_center">
            <a href="user.php?user=${res.posts[i]['username']}" data-id="${res.posts[i]['id']}" class="feed__postUser">${res.posts[i]['username']}</a>
            <a class="link__edit button" title="edit picture" href="editpost.php?post=${res.posts[i]['post_id']}">✏️</a>
            <a class="link__block button" href="#" title="report picture" data-id="${res.posts[i]['post_id']}" >⛔</a></div>
            <a href="details.php?post=${res.posts[i]['post_id']}">
            <img class="feed__postImg" src="post_images/ ${res.posts[i]['post_image']}"></a>
            <p class="feed__postDesc">${res.posts[i]['post_desc']}</p>
            <div class="feed__flex">  
                <p class="feed__postLikes" title="like" data-like="like" data-id="${res.posts[i]['post_id']}">💗
                <span class="postLikes">${res.posts[i]['post_likes']}</span> likes</p>
                <a href="details.php?post=${res.posts[i]['post_id']}" title="comment" class="feed__postComments">💬</a>
                <p class="feed__postDate">${res.posts[i]['post_date']}</p>
            </div>`);

            } else {
                console.log("OTHER USER");
                $content = $(`<div class="flexrow flex_between flex_align_center">
            <a href="user.php?user=${res.posts[i]['username']}" data-id="${res.posts[i]['id']}" class="feed__postUser">${res.posts[i]['username']}</a>
            
            <a class="link__block button" href="#" title="report picture" data-id="${res.posts[i]['post_id']}" >⛔</a></div>
            <a href="details.php?post=${res.posts[i]['post_id']}">
            <img class="feed__postImg" src="post_images/ ${res.posts[i]['post_image']}"></a>
            <p class="feed__postDesc">${res.posts[i]['post_desc']}</p>
            <div class="feed__flex">  
            <p class="feed__postLikes" title="like" data-like="like" data-like="like" data-id="${res.posts[i]['post_id']}" >💗
            <span class="postLikes">${res.posts[i]['post_likes']} </span> likes</p>
                <a href="details.php?post=${res.posts[i]['post_id']}" title="comment" class="feed__postComments">💬</a>
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