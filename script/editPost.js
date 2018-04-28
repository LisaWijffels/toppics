$("#editPostDesc").on("click", function(e){
    e.preventDefault();
    
    $("#formEditDesc").toggleClass('hidden visible');
    $("#valueDesc").toggleClass('visible hidden');
    $("#editPostDesc").hide();
    
});

$('#btnAddTag').on("click", function(e){
    e.preventDefault();
    console.log("About to save a tag");
    var tag_name = $("#addTag").val();
    var post_id = $("#post_id").attr('data-id');

    $.ajax({
        type: "POST",
        url: "ajax/addPostTag.php",
        data: { tag_name: tag_name, post_id: post_id},
        
    }).done(function( res ) { //als ajax antwoord (echo) terugstuurt
        console.log("Data Saved: "+ res);
        location.reload();
    }).fail(function(res)  {
       console.log("Sorry. Ajax failed");
    });

});

$("[name='btnPostDesc']").on("click", function(e) {
    
    var post_desc = $("[name='postDesc']").val();
    var post_id = $("#post_id").attr('data-id');
    
    
    $.ajax({
        type: "POST",
        url: "ajax/editPostDesc.php",
        data: { post_desc: post_desc, post_id: post_id},
        
    }).done(function( res ) { //als ajax antwoord (echo) terugstuurt
        console.log("Data Saved: "+ res);
        $("#valueDesc").toggleClass('hidden visible');
        $("#formEditDesc").toggleClass('visible hidden');
        $("#editPostDesc").show();
        $("#valueDesc").html(post_desc);
        
    }).fail(function(res)  {
       console.log("Sorry. Ajax failed");
    }); 
    
    e.preventDefault();
    
});

$(".delete_tag").on("click", function(e){
    e.preventDefault();
    var thisElement = $(this);

    
    var tag_id = thisElement.attr('data-tag-id');
    console.log("deleting tag "+tag_id);
    
    $.ajax({
        type: "POST",
        url: "ajax/deletePostTag.php",
        data: { tag_id: tag_id},
        
    }).done(function( res ) { //als ajax antwoord (echo) terugstuurt
        console.log("Data Deleted: "+ res);
        thisElement.parent().remove();
        
        
    }).fail(function(res)  {
       console.log("Sorry. Ajax failed");
    });
    
    e.preventDefault();
    
});

