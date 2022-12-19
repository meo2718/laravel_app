@props(['status' => 'info'])
@php
if(session('status') === 'info'){ $bgColor = 'bg-blue-300';} 
if(session('status') === 'alert'){$bgColor = 'bg-red-500';} 
@endphp
{{-- フラッシュメッセージ表示 --}}
@if(session('message'))
{{-- my-4で上下にマージン1文字分 --}}
  <div class="{{ $bgColor }} w-1/2 mx-auto p-2 my-4 text-white">
    {{ session('message' )}} 
  </div>
@endif