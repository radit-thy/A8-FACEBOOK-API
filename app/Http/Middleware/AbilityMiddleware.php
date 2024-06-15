<*/?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbilityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $ability
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $ability)
    {
        $user = Auth::user();
        
        // Implement your logic to check the user's ability
        if (!$user || !$user->tokenCan($ability)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
