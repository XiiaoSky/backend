<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Http\JsonResponse;

class Checktoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(isset($_SERVER['HTTP_USERID'])){

            $token = $_SERVER['HTTP_USERID'];

            $count = Users::where('id',$token)->count();

            if($count >= 1){
                return $next($request);
           }else{
     
               $data['status']    = false;
               $data['message']  = "Enter Right userId";
               return new JsonResponse($data, 401);
           }
        
           
        
           }else{
               
               $data['status']    = false;
               $data['message'] = "Unauthorized Access";
            return new JsonResponse($data, 401);
           }
    }
}
