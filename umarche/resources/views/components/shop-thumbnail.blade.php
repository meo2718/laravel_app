<div>
  @if(empty($shop->filename))
    <img src="{{ asset('images/no_images.jpg')}}">
  @else
  {{-- 画像アップロード先PATH --}}
    <img src="{{ asset('storage/shops/' . $shop -> filename)}}">
  @endif
</div>