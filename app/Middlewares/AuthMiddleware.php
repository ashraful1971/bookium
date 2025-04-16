<?php

namespace Ashraful\Bookium\App\Middlewares;

use Ashraful\Bookium\Contracts\Middleware;
use Ashraful\Bookium\Contracts\Request;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request)
    {
        if($request->token === 'secret'){
            return true;
        }
        
        // if (is_user_logged_in()) {
        //     return true;
        // }

        return false;
    }
}
