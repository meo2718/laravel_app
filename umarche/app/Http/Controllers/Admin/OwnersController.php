<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner; //Eloquent
use Illuminate\Support\Facades\DB; //クエリビルダ
class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * laravelでデータを扱う際にはcollectionを使うことが多い
     * →support,eloquentの2種類あるddを使ってデータの型を見ていく
     */
    //コンストラクタでミドルウェアを設定しadminで認証していた場合実行する
    public function __construct()
    {
        $this->middleware('auth:admin'); 
    }

    public function index()
    {
        //Illuminate\Database\Eloquent\Collection
        $eloquent = Owner::all();

        //Illuminate\Support\Collection 
        $queryBuilder = DB::table('owners')->select('name')->get();

        //object(stdClass)#1516 (1) { ["name"]=> string(3) "meo" }
        $queryBuilder_first = DB::table('owners')->select('name')->first();

        //Illuminate\Support\Collection 
        $collection = collect([
            'name' => 'てすと'
        ]);

        var_dump($queryBuilder_first);
        dd($eloquent,$queryBuilder,$queryBuilder_first,$collection);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
