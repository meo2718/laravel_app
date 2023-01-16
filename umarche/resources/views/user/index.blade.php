<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          商品一覧
      </h2>
      <div>
        <form method="get" action="{{ route('user.items.index')}}">
          <div class="flex">
            <div>
              <span class="text-sm">表示順</span><br>
              <select id="sort" name="sort" class="mr-4">
                <option value="{{ \Constant::SORT_ORDER['recommend']}}"
                    @if(\Request::get('sort') === \Constant::SORT_ORDER['recommend'] ) 
                    selected 
                    @endif>おすすめ順
                </option>
                <option value="{{ \Constant::SORT_ORDER['higherPrice']}}" 
                    @if(\Request::get('sort') === \Constant::SORT_ORDER['higherPrice'] ) 
                    selected 
                    @endif>料金の高い順
                </option>
                <option value="{{ \Constant::SORT_ORDER['lowerPrice']}}"
                    @if(\Request::get('sort') === \Constant::SORT_ORDER['lowerPrice'] ) 
                    selected 
                    @endif>料金の安い順    
                </option>
                <option value="{{ \Constant::SORT_ORDER['later']}}"
                    @if(\Request::get('sort') === \Constant::SORT_ORDER['later'] ) 
                    selected 
                    @endif>新しい順
                </option>
                <option value="{{ \Constant::SORT_ORDER['older']}}"
                    @if(\Request::get('sort') === \Constant::SORT_ORDER['older'] ) 
                    selected 
                    @endif>古い順
                </option>
              </select>
            </div>
            {{-- ページネーション --}}
            <span class="text-sm">表示件数</span><br>
            <select id="pagination" name="pagination">
              <option value="20" 
              {{-- getパラメータのvalueが同じならselectedをつける --}}
              @if(\Request::get('pagination') === '20')
               selected
              @endif>20件
              </option>
              <option value="50" 
              @if(\Request::get('pagination') === '50')
               selected
              @endif>50件
              </option>
              <option value="100" 
              @if(\Request::get('pagination') === '100')
               selected
              @endif>100件
              </option>
            </select>
          </div>
         
        </form>
      </div>
    </div>
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
                {{-- apendsでリクエストを取ることでページネーション後も表示順を引き継ぐ --}}
                {{ $products->appends([
                  'sort'=>\Request::get('sort'),
                  'pagination'=>\Request::get('pagination')
                ])->links() }}
              </div>
          </div>
      </div>
  </div>
  <script>
    const select = document.getElementById('sort')
    select.addEventListener('change', function(){
    this.form.submit() })
  </script>
  <script>
    const paginate = document.getElementById('pagination') 
    paginate.addEventListener('change', function(){
    this.form.submit() })
    </script>
</x-app-layout>