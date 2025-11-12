@extends('layout.template.mainTemplate')

@section('container')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-2xl shadow-sm font-poppins mt-10">

  <h2 class="text-lg font-semibold mb-4">🔔 Notifikasi</h2>

  <div class="space-y-4">
    @foreach ($notifications as $notif)
      <div class="p-4 rounded-xl border 
                  @if(!$notif->is_read) bg-blue-50 border-blue-200 
                  @else bg-gray-50 border-gray-200 @endif">

        <div class="flex justify-between">
          <p class="text-sm text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>

          @if(!$notif->is_read)
          <form method="POST" action="{{ route('notifications.read', $notif->id) }}">
            @csrf
            @method('PATCH')
            <button class="text-xs text-blue-600 hover:underline">Tandai dibaca</button>
          </form>
          @endif
        </div>

        <p class="font-semibold text-gray-800 mt-1">{{ $notif->title }}</p>
        <p class="text-gray-600 text-sm mt-1">{{ $notif->message }}</p>

        @if($notif->type)
          <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full
              @if($notif->type == 'materi') bg-blue-100 text-blue-700
              @elseif($notif->type == 'tugas') bg-yellow-100 text-yellow-700
              @elseif($notif->type == 'ujian') bg-red-100 text-red-700
              @else bg-gray-100 text-gray-700 @endif">
              {{ ucfirst($notif->type) }}
          </span>
        @endif
      </div>
    @endforeach

    @if ($notifications->isEmpty())
      <p class="text-center text-gray-400 text-sm py-6">Tidak ada notifikasi</p>
    @endif
  </div>
</div>
@endsection
