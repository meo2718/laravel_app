
@php
// 呼び出し元のコンポーネントのtype属性を判定し、画像アップロードさきのPATHをかえる
if($type === 'shops'){
  $path = 'storage/shops/';
}
if($type === 'products'){
  $path = 'storage/products/';
}
@endphp

<div>
  @if(empty($filename))
    <img src="{{ asset('images/no_images.jpg')}}">
  @else
  {{-- 画像アップロード先PATH --}}
    <img src="{{ asset($path . $filename)}}">
  @endif
</div>