<?php
namespace App\Services\Owner;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Owner;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Throwable;


class OwnerService{

  public static function addByOwner($request){
    DB::beginTransaction();
    try {
      $owner = Owner::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), //Hash::makeで暗号化
    ]);
    Shop::create([
      'owner_id' => $owner->id,
      'name' => '店名を入力してください',
      'information' => '',
      'filename' => '',
      'is_selling' => true
    ]);
    } catch (\Exception $e) {
      Log::error($e);
      DB::rollback;
    }
    DB::commit();
  }
}