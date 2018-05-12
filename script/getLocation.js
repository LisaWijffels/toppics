$(document).ready(function(){

    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showLocation);
    }else{ 
        $('#location').html('Geolocation is not supported by this browser.');
    }

});

function showLocation(position){
    console.log("showlocation");

    let postID = $(".post__id").attr("data-id");
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $.ajax({
        type:'POST',
        url:'ajax/getLocation.php',
        data:'latitude='+latitude+'&longitude='+longitude+'&postID='+postID,
        success:function(msg){
            if(msg){
                $("#location").html(msg);
                
            }else{
                $("#location").html('Not Available');
            }
        }
    });
}