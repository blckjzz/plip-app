<?php

namespace App\Http\Middleware;

use App\Analysis;
use Auth;
use Closure;

class AnalysisVerifyAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route()->parameter('id') == null || $request->only('analysis_id') == null) {
            if ($request->route()->parameter('id')) {
                $analise = Analysis::find($request->route()->parameter('id'));
            } else {
                $analise = Analysis::find($request->only('analysis_id'));
                $analise = $analise[0];
            }

            if (isset($analise)) {
                if ($analise->analista->id == Auth::user()->volunteer->id) { // refactor para um middleware
                    return $next($request);
                }
            } else {
                return redirect()->back()->with('error', 'Parece que algo deu errado!');
            }
        }
        abort('200', 'Você não tem autorização para realizar essa operação.');
    }
}
