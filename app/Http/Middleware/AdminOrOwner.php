<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrOwner
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
    // Get the authenticated user
    $user = Auth::user();

    // Check if the user is an admin
    if ($user) {
      // Allow access if the user is an admin
      if ($user->type !== "admin") {
        // dd(($request->routeIs('deliverymen.parcels') || $request->routeIs("parcel.update")));
        if (($request->routeIs('deliverymen.parcels') || $request->routeIs("deliverymen.local_parcels"))  && $request->id == $user->delivery->id) {
          return $next($request);
        }else if( $request->routeIs("parcel.update") ||$request->routeIs("parcel_local.store")||$request->routeIs("parcel_local.delete") ){
          return $next($request);

        }else{
          Auth::logout();
          $request->session()->invalidate();
          $request->session()->regenerateToken();
          return redirect('/login');
        }
       

      }
      return $next($request);
    } else {
      // Deny access if neither condition is met
      return redirect('/login');
    }
  }
}
