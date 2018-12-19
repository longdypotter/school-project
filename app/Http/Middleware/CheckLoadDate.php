<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoadDate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();
        if ($user->hasAnyRole('Student')) {
            $download = \App\Models\DownloadCenter::findOrFail($request->id);
            if($download->public_date > date('Y-m-d')){
                abort(403);
            }
        }
        return $next($request);
    }
}
