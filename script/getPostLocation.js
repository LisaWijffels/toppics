$("#buttondrop").on("click", function (e) {
    e.preventDefault();

    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showLocation);
    }else{ 
        $('#location').html('Geolocation is not supported by this browser.');
    }

});


function showLocation(position){
    console.log("showlocationpost");

    var postid = $(".post__id").attr("data-id");

    console.log(postid);

    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    $.ajax({
        type:'POST',
        url:'ajax/getPostLocation.php',
        data:'latitude='+latitude+'&longitude='+longitude+'&postid='+postid,
        success:function(msg){
            if(msg){
                $("#location").html(" 🌍 "+ msg);
                
            }else{
                $("#location").html('Not Available');
            }
        }
    });
}