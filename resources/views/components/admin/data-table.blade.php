@props(['headers', 'rows' => [], 'actions' => true])

<div class="admin-table">
  <table class="w-full">
    <thead>
      <tr>
        @foreach($headers as $header)
        <th class="text-left">{{ $header }}</th>
        @endforeach
        @if($actions)
        <th class="text-center">Thao tác</th>
        @endif
      </tr>
    </thead>
    <tbody>
      {{ $slot }}
    </tbody>
  </table>
</div>