<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('home') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-wrap">
                  {{-- 商品一覧表示 --}}
                   @foreach($products as $product)
                  {{-- 1/4で表示 レスポンシブでスマホの場合p-2,タブレットだったらp-4--}}
                  <div class="w-1/4 p-2 md:p-4">
                  {{-- クリックしたら商品詳細画面に飛ぶようにする --}}
                   <a href="{{route('user.items.show',['item'=>$product->id])}}">
                    {{-- 角をとったパディング上下左右4方向にボーダーをいれる --}}
                   <div class="border rounded-md p-2 md:p-4">
                    
                      {{-- 画像アップロードのサムネイルのコンポーネント→productフォルダの中に保存するのでtypeで属性をつける --}}
                      {{-- :filename="$product->filename"とすることで画像名がとれる --}}
                      <x-thumbnail filename="{{$product->filename ?? ''}}" type="products" />
                        {{-- productsテーブル内のカラム表示 --}}
                        <div class="mt-4">
                          {{-- $product->categoryなどはItemControllerのasで設定してる --}}
                          <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category }}</h3>
                          <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                          <p class="mt-1">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円(税込)</span></p>
                        </div>
                   </div>
                   </a>
                  </div>
                   @endforeach
               
                </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>