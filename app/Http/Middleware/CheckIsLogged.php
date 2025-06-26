<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIsLogged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //verifica se usuario está logado
        if (!session('user')){ //traduzindo "Se existe ou nao um usuario logado. Se não, redireciona pra login"
            return redirect('/login');
        }
        return $next($request);
    }
}
