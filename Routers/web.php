<?php

Router::GET("/posts/callback",function(){
    echo "ahihi";
});
// Router::GET("/home","HomeController@index");
Router::GET("/posts","PostController@index");
// // Router::GET("/posts/detail/$id","PostController@show");
// Router::GET("/posts/create","PostController@create");
// Router::POST("/posts/create","PostController@postCreate");
