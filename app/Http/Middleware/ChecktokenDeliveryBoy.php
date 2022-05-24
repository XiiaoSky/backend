<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;

class ChecktokenDeliveryBoy
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
        if(isset($_SERVER['HTTP_TOKEN'])){

            $token = $_SERVER['HTTP_TOKEN'];

            $count = Delivery::where('token',$token)->count();

            if($count >= 1){
                return $next($request);
           }else{
             $data['status']    = false;
               $data['message']  = "Enter Right Token";
               return new JsonResponse($data, 401);
           }
        
           
        
           }else{
               $data['status']    = false;
               $data['message']   = "Unauthorized Access";
            return new JsonResponse($data, 401);
           }
    }
}
