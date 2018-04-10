$(".editProfileText").on("click", function(e){
    e.preventDefault();
    $("#formEditText").toggleClass('hidden visible');
    $("#valueEditText").toggleClass('visible hidden');
    $(".editProfileText").removeClass("visible").addClass("hidden");
    
});

$("[name='btnprofileText']").on("click", function(e) {
    console.log("Clicked btnprofileText");
    var profile_text = $("[name='profileText']").val();
    
    $.ajax({
        type: "POST",
        url: "ajax/editProfileText.php",
        data: { profile_text: profile_text },
        
    }).done(function( res ) { //als ajax antwoord (echo) terugstuurt
        console.log("Data Saved: "+ res);
        $("#valueEditText").toggleClass('hidden visible');
        $("#formEditText").toggleClass('visible hidden');
        $("#valueEditText").html(profile_text);
        
    }).fail(function(res)  {
       console.log("Sorry. Ajax failed");
    }); 
    
    e.preventDefault();
    
});

$(".editEmail").on("click", function(e){
    e.preventDefault();
    $("#formEditEmail").toggleClass('hidden visible');
    $("#valueEditEmail").toggleClass('visible hidden');
    $(".editEmail").addClass("hidden");
    console.log("check");
});

$("[name='btnEmail']").on("click", function(e) {
    var profile_email = $("[name='email']").val();
    
    $.ajax({
        type: "POST",
        url: "ajax/editProfileEmail.php",
        data: { profile_email: profile_email },
        
    }).done(function( res ) { //als ajax antwoord (echo) terugstuurt
        console.log("Data Saved: "+ res);
        $("#valueEditEmail").toggleClass('hidden visible');
        $("#formEditEmail").toggleClass('visible hidden');
        $("#valueEditEmail").html(profile_email);
        
    }).fail(function(res)  {
       console.log("Sorry. Ajax failed");
    }); 
    
    e.preventDefault();
    
});


$(".editPic").on("click", function(e){
    e.preventDefault();
    $("#formEditPic").toggleClass('hidden visible');
    $(".editPic").removeClass("visible").addClass("hidden");
    console.log("check");
});

$(".editPassword").on("click", function(e){
    e.preventDefault();
    $("#formEditPassword").toggleClass('hidden visible');
    $(".editPassword").addClass('hidden');
    console.log("check");
});