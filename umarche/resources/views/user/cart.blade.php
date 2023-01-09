<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          cart
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                {{-- productsが0出なかった場合、一覧表示 --}}
                  @if(count($products) > 0)
                  @foreach ($products as $product)
                  {{-- タブレット幅になったらflex,画像がある場合items-centerで中央揃え,mb-2で間をあける --}}
                  <div class="md:flex md:items-center mb-2">
                    {{-- 横に並べる場合最大12分割 --}}
                    <div class="md:w-3/12">
                      @if ($product->imageFirst->filename !== null)
                      <img src="{{ asset('storage/products/' . $product->imageFirst->filename )}}">
                      @else
                      <img src="">
                      @endif
                    </div>
                    {{-- 商品名 --}}
                    <div class="md:w-4/12 md:ml-2">{{ $product->name }}</div>
                    <div class="md:w-3/12 flex justify-around">
                      {{-- 数量 --}}
                      <div>{{ $product->pivot->quantity }}</div>
                      {{-- 金額 --}}
                      <div>{{ number_format($product->pivot->quantity * $product->price )}}<span class="text-sm text-gray-700">円(税込)</span></div>
                    </div>
                    <div class="md:w-2/12">削除ボタン</div>
                  </div>
                  @endforeach
                  @else
                  カートに商品が入っていません。
                  @endif
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
