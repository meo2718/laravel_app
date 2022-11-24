<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                  eloquent
                  @foreach ($eloquent as $eloquent_owner)
                  {{ $eloquent_owner->name }}
                  {{-- created_atはeloquentのcarbonインスタンスなのでつなげてかける --}}
                  {{ $eloquent_owner->created_at->diffForHumans() }}
                  @endforeach
                  <br>
                  クエリビルダ
                  @foreach ($queryBuilder as $queryBuilder_owner)
                      {{ $queryBuilder_owner->name }}
                      {{-- クエリビルダの場合は一旦parseを通す必要がある --}}
                      {{ Carbon\Carbon::parse($queryBuilder_owner->created_at)->diffForHumans() }}
                  @endforeach
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
