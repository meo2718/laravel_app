<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          商品の詳細
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">

                 <div class="md:flex md:justify-around">
                     {{-- 商品画像表示 --}}
                     <div class="md:w-1/2">
                         <!-- Slider main container -->
                     <div class="swiper-container">
                         <!-- Additional required wrapper -->
                         <div class="swiper-wrapper">
                         <!-- Slides 画像がある場合とない場合-->
                         <div class="swiper-slide">
                            @if ($product->imageFirst->filename !== null)
                            <img src="{{ asset('storage/products/' . $product->imageFirst->filename )}}">
                            @else
                            <img src="">
                            @endif
                         </div>
                         <div class="swiper-slide">
                            @if ($product->imageSecond->filename !== null)
                            <img src="{{ asset('storage/products/' . $product->imageSecond->filename )}}">
                            @else
                            <img src="">
                            @endif
                         </div>
                         <div class="swiper-slide">
                            @if ($product->imageThird->filename !== null)
                            <img src="{{ asset('storage/products/' . $product->imageThird->filename )}}">
                            @else
                            <img src="">
                            @endif
                         </div>
                         <div class="swiper-slide">
                            @if ($product->imageFourth->filename !== null)
                            <img src="{{ asset('storage/products/' . $product->imageFourth->filename )}}">
                            @else
                            <img src="">
                            @endif
                         </div>
                         <div class="swiper-slide">
                            @if ($product->imageFifth->filename !== null)
                            <img src="{{ asset('storage/products/' . $product->imageFifth->filename )}}">
                            @else
                            <img src="">
                            @endif
                         </div>
                         ...
                         </div>
                         <!-- If we need pagination -->
                         <div class="swiper-pagination"></div>
                         <!-- If we need navigation buttons -->
                         <div class="swiper-button-prev"></div>
                         <div class="swiper-button-next"></div>
                         <!-- If we need scrollbar -->
                         <div class="swiper-scrollbar"></div>
                    </div>
                    </div>
                     {{-- カテゴリー名、商品名、商品情報表示 --}}
                     <div class="md:w-1/2 ml-4">
                         <h2 class="mb-4 text-sm title-font text-gray-500 tracking-widest">{{ $product->category->name}}</h2>
                         <h1 class="mb-4 text-gray-900 text-3xl title-font font-medium">{{ $product->name }}</h1>
                         <p class="mb-4 leading-relaxed">{{ $product->information }}</p>
                     {{-- 金額、数量、カートボタン表示 items-center(縦方向中央揃え)--}}
                         <div class="flex justify-around items-center">
                            {{-- number_formatで価格にコロンいれる --}}
                            <div>
                              <span class="title-font font-medium text-2xl text-gray-900">{{ number_format($product->price) }}</span><span class="text-sm text-gray-700">円(税込)</span>
                            </div>
                            <div class="flex items-center">
                              {{-- 数量表示 --}}
                              <span class="mr-3">数量</span>
                              <div class="relative">
                                  <select class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-500 text-base pl-3 pr-10">
                                    <option>SM</option>
                                     <option>M</option>
                                     <option>L</option>
                                     <option>XL</option>
                                  </select>
                              </div>
                            </div>
                            <button class="flex ml-auto text-white bg-pink-500 border-0 py-2 px-6 focus:outline-none hover:bg-pink-600 rounded">カートに入れる</button>
                         </div>

                     </div>
                 </div>
                 <div class="border-t border-gray-400 my-8"></div>
                 <div class="mb-4 text-center">この商品を販売しているショップ</div>
                 <div class="mb-4 text-center">{{ $product->shop->name }}</div>
                 <div class="mb-4 text-center">
                    @if ($product->shop->filename !== null)
                    {{-- object-cover rounded-full比率を維持して丸く表示 --}}
                    <img class="mx-auto w-40 h-40 object-cover rounded-full" src="{{ asset('storage/shops/' . $product->shop->filename )}}">
                    @else
                    <img src="">
                    @endif
                 </div>
                 <div class="mb-4 text-center">
                    {{-- type="button"とすることでpost通信にしない --}}
                    <button type="button" class="text-white bg-pink-500 border-0 py-2 px-6 focus:outline-none hover:bg-pink-600 rounded">ショップの詳細を見る</button>
                 </div>
              </div>
          </div>
      </div>
  </div>
  {{-- sliderの読み込み --}}
  <script src="{{ mix('js/swiper.js') }}"> </script>
</x-app-layout>