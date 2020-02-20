<?php

namespace App\Http\Middleware;

use Closure;

class CheckUser
{
    /**
     * The Auth implementation.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     */
    public function __construct()
    {
        $this->auth = auth();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->user()->entity) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
