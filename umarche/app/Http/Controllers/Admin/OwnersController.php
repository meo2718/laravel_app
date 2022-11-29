<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner; //Eloquent
use Illuminate\Support\Facades\DB; //クエリビルダ
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
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
        // $date_now = Carbon::now()->year;
        // $date_parse = Carbon::parse(now());
        // echo $date_now;
        // echo $date_parse;

        //Illuminate\Database\Eloquent\Collection
        // $eloquent = Owner::all();

        //Illuminate\Support\Collection 
        // $queryBuilder = DB::table('owners')->select('name','created_at')->get();

        //object(stdClass)#1516 (1) { ["name"]=> string(3) "meo" }
        // $queryBuilder_first = DB::table('owners')->select('name')->first();

        //Illuminate\Support\Collection 
        // $collection = collect([
        //     'name' => 'てすと'
        // ]);

        // var_dump($queryBuilder_first);
        // dd($eloquent,$queryBuilder,$queryBuilder_first,$collection);
        $owners = Owner::all();
        // $owners = Owner::select('name','email','created_at','id')->get();
        return view('admin.owners.index', compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.owners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * フォームで入力された値がRequestクラスとなってそれをインスタンス化$requestする
     * （メソッドインジェクション
     * controllers/admin.auth/registerUserControllerからコピペ
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ]);
        Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), //Hash::makeで暗号化
        ]);
        return redirect()->route('admin.owners.index')->with('message', 'オーナーを登録できました。');
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
        // $owner = Owner::findOrFail($id);
        // return view('admin.owners.edit', compact('owner'));

        $this->viewData['owner'] = Owner::findOrFail($id);
        return view('admin.owners.edit', $this->viewData);
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
