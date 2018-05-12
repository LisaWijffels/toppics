<?php

include_once("../classes/Post.class.php");

//if latitude and longitude are submitted
if(!empty($_POST['latitude']) && !empty($_POST['longitude'])){
    //send request and receive json data by latitude and longitude
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($_POST['latitude']).','.trim($_POST['longitude']).'&sensor=false';
    $json = @file_get_contents($url);
    $data = json_decode($json);
    $status = $data->status;

    
    //if request status is successful
    if($status == "OK"){
        //get address from json data
        $location = $data->results[0]->formatted_address;

        //save
       $postId = $_POST['postid'];
       $db = Db::getInstance();
       $post_location = new Post($db);
       $post_location->setPost_id($postId);
       $post_location->SaveLocation($location);

    }else{
        $location = 'no location found';
        
         //save
       $postId = $_POST['postid'];
       $db = Db::getInstance();
       $post_location = new Post($db);
       $post_location->setPost_id($postId);
       $post_location->SaveLocation($location);
    }
    
    //return address to ajax 
    header('Content-Type: application/json');
    echo json_encode($location);

       
    
}
?>