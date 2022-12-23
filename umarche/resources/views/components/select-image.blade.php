@php 
//create側のname属性でimage1~4をとってくるので変数で設定する
//modal-1というのはid="modal-1"のこと(1~4まで使い回せる)
if($name === 'image1'){ $modal = 'modal-1'; }
if($name === 'image2'){ $modal = 'modal-2'; }
if($name === 'image3'){ $modal = 'modal-3'; }
if($name === 'image4'){ $modal = 'modal-4'; }
if($name === 'image5'){ $modal = 'modal-5'; }
@endphp
{{-- id=“modal-1” となっている箇所を {{ $modal }} に置き換える --}}
<div class="modal micromodal-slide" id="{{ $modal }}" aria-hidden="true">
  <div class="modal__overlay z-50" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="{{ $modal }}-title">
      <header class="modal__header">
        <h2 class="text-xl text-fuchsia-700" id="{{ $modal }}-title">
          ファイルを選択してください。
        </h2>
        <button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="{{ $modal }}-content">
        {{-- //image一覧 --}}
        <div class="flex flex-wrap">
          @foreach ($images as $image)
          <div class="w-1/4 p-2 md:p-4">
           <div class="border rounded-md p-2 md:p-4">
               {{-- JSで画像をクリックしたら画像を選択しつつモーダルを閉じる動きをつける
               JSで操作できるよう共通のCSS(今回はimage)と個別のidや属性をつける
               data-○○ とつけるとPHPの変数をJS側で取得できる --}}
                <img class="image"
                data-id="{{ $name }}_{{ $image->id }}"
                data-file="{{ $image->filename }}"
                data-path="{{ asset('storage/products/') }}"
                data-modal="{{ $modal }}"
                src="{{ asset('storage/products/' . $image->filename)}}">
              {{-- imageのタイトル表示 --}}
              <div class="text-gray-700">{{ $image->title }}</div>
           </div>
          </div>
          @endforeach
        </div>

      </main>
      <footer class="modal__footer">
        {{-- `button`はそのままだとsubmitになってpost通信してしまうので`type="button"`を追加 --}}
        <button type="button" class="modal__btn" data-micromodal-close aria-label="閉じる">閉じる</button>
      </footer>
    </div>
  </div>
</div>
{{-- モーダルを表示するためのボタンを追加 --}}
<div class="flex justify-around items-center mb-4">
  <a class="py-2 px-4 bg-gray-200" data-micromodal-trigger="{{ $modal }}" href='javascript:;'>ファイルを選択</a>
  <div class="w-1/4">
    {{-- $nameにimage1,2,3,4 がはいってくる --}}
    <img id="{{$name}}_thumbnail" src="">
  </div>
</div>
<input id="{{$name}}_hidden" type="hidden" name="{{$name}}" value="">