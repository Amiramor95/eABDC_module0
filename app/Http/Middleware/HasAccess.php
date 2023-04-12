<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\CurrentUser;

class HasAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $access)
    {
        $proceed = false;

        switch(CurrentUser::UserType())
        {
            case 'admin':
                $proceed = config('access.admin.'.$access, false);
                break;
            case 'parent':
                $proceed = config('access.parent.'.$access, false);
                break;
            case 'serviceProvider':
                $proceed = config('access.serviceProvider.'.$access, false);
                break;
            case 'agent':
                $proceed = config('access.agent.'.$access, false);
                break;
            case 'moderator':
                $proceed = config('access.moderator.'.$access, false);
                break;
            case 'bookshop':
                $proceed = config('access.bookshopAgent.'.$access, false);
                break;
            case 'teacher':
                $proceed = config('access.teacher.'.$access, false);
                break;
            case 'saleOperator': 
            {//dd(CurrentUser::BranchType());
                switch(CurrentUser::BranchType())
                {
                    case '1':
                        $proceed = config('access.saleOperator.'.$access, false);
                        break;
                    case '2':
                        $proceed = config('access.bookshop.'.$access, false);
                        break;
                    case '3':
                        $proceed = config('access.soleProprietor.'.$access, false);
                        break;
                }

            }
        }
        //update ended

        if (!$proceed) 
        {

            if($request->ajax())
            {
                die(header("HTTP/1.0 404 Not Found")); 
            }
            else
            {
                return abort(404);
            }

        }

        return $next($request);
    }
}
