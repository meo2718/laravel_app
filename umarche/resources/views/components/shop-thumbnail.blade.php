<div>
  @if(empty($filename))
    <img src="{{ asset('images/no_images.jpg')}}">
  @else
  {{-- 画像アップロード先PATH --}}
    <img src="{{ asset('storage/shops/' . $filename)}}">
  @endif
</div>