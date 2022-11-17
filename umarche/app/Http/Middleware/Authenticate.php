<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{   //RouteServiceProviderのasでuser.などは定義済
    protected $user_route = 'user.login';
    protected $owner_route = 'owner.login';
    protected $admin_route = 'admin.login';
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *もし認証されていない場合、リダイレクトする処理を書く
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {   //もしリクエストはjsonじゃなかったら
        if (! $request->expectsJson()) {
            //もしowner関連のURLじゃなかったら$owner_routeへ飛ばす
            if(Route::is('owner.*')){
                //$this->で上のプロパティ呼び出し
                return route($this->owner_route);
                //admin関連のURLでなかったらadminへ飛ばす
            } elseif(Route::id('admin*')){
                return route($this->admin_route);
                //ownerでもadminでもなかったらユーザーへ飛ばす
            } else {
                return route($this->user_route);
            }
        }
    }
}
