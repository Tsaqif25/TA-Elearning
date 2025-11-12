<div class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-xl shadow-lg z-50">
  @if ($notifications->count() > 0)
    <ul class="divide-y divide-gray-100 max-h-64 overflow-y-auto">
      @foreach ($notifications as $notif)
        <li class="p-4 hover:bg-gray-50 transition">
          <div class="flex justify-between">
            <span class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
            @if(!$notif->is_read)
              <span class="text-[10px] text-blue-500 font-medium">Baru</span>
            @endif
          </div>
          <p class="text-sm font-semibold text-gray-800 mt-1">{{ $notif->title }}</p>
          <p class="text-xs text-gray-600 mt-1">{{ $notif->message }}</p>
          @if($notif->type)
            <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full
                @if($notif->type == 'materi') bg-blue-100 text-blue-700
                @elseif($notif->type == 'tugas') bg-yellow-100 text-yellow-700
                @elseif($notif->type == 'ujian') bg-red-100 text-red-700
                @else bg-gray-100 text-gray-700 @endif">
                {{ ucfirst($notif->type) }}
            </span>
          @endif
        </li>
      @endforeach
    </ul>
  @else
    <div class="p-4 text-center text-gray-500 text-sm">
      Tidak ada notifikasi
    </div>
  @endif
  <div class="p-3 border-t text-center">
    <a href="{{ route('notifications.index') }}" class="text-xs text-blue-600 hover:underline font-medium">
      Lihat Semua Notifikasi
    </a>
  </div>
</div>
