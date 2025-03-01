<?php
if (!function_exists('apiresponse')) {
    function apiresponse($status,$massage,$data=Null) {
        // Your logic here
        return response()->json(['status'=>$status,'massage'=>$massage,'data'=>$data]);// Example return
    }
}