$(".follow").on("click", function(e){
    let user = $('.feed__postUser').attr("data-id");

    console.log(user);

    //to database
    $.ajax({
         method: "POST",
         url: "ajax/follow.php",
         data: {user : user}
    })
    .done(function( res ) {

        if( res.status == "success") {
            console.log('followed this user');
            $('.followed').html("followed this user");
            $('.follow').hide();
        }
    });

    e.preventDefault();
});