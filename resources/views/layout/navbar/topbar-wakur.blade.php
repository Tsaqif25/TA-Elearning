@php
    use App\Models\Notification;
    use Illuminate\Support\Facades\Auth;

  $notifCount = Notification::where('user_id',Auth::id())
  ->where('is_read',false)
  ->count();
@endphp

<nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-6">
    <div class="flex justify-between items-center h-16">

      {{-- 🧭 TITLE KHUSUS WAKUR --}}
      <div class="flex flex-col">
        <h1 class="text-xl font-extrabold text-gray-800">Dashboard Wakil Kurikulum</h1>
        <p class="text-xs text-gray-500 mt-1">SMK 2 Padang - Monitoring & Management</p>
      </div>

      {{-- 🔍 Search Bar --}}
      <div class="flex items-center gap-3">
        {{-- <div class="hidden md:block">
          <input
            type="text"
            placeholder="Cari guru, materi, atau kelas..."
            class="w-72 px-4 py-2 text-sm border rounded-xl bg-gray-50 focus:ring-2 focus:ring-blue-400"
          />
        </div> --}}

        {{-- 🔔 Notifikasi --}}
      <div class="relative" id="notif-wrapper">
  <!-- tombol  dan badge -->
  <div id="notif-button" class="cursor-pointer">
    <div class="w-9 h-9 rounded-full flex items-center justify-center bg-slate-100 hover:bg-slate-200 transition shadow-sm">
      <i class="fa-regular fa-bell text-gray-600 text-[16px]"></i>
    </div>
    @if($notifCount > 0)
      <span class="absolute top-1 right-1 bg-red-500 text-white text-[10px] font-bold px-[5px] py-[1px] rounded-full shadow">
        {{ $notifCount }}
      </span>
    @endif
  </div>

<!-- Dropdown Notifikasi -->
<div id="notif-dropdown"
     class="hidden sm:absolute sm:right-0 sm:top-12 fixed inset-x-0 top-14 mx-auto w-[92vw] sm:w-80 max-w-[92vw] sm:max-w-sm bg-white border border-gray-200 rounded-2xl shadow-xl z-50 sm:mx-0 sm:inset-x-auto sm:right-2">
  <div class="max-h-[70vh] overflow-y-auto p-3 sm:p-4 text-sm text-gray-700">
    Tidak ada notifikasi
  </div>
</div>



</div>

        {{-- 👤 Profil --}}
      <div class="relative group">
          <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-green-600 to-green-400 flex items-center justify-center text-white font-bold uppercase cursor-pointer shadow-sm">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
          </div>
          <div
            class="absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 group-hover:visible invisible transition-all duration-200 z-50">
          <a href="{{ route('profile.edit') }}"
   class="block px-4 py-2 border-b text-sm text-gray-700 font-medium hover:bg-[#F9FAFB] transition">
    Edit Profile
</a>

            <form action="{{ route('logout') }}" method="POST" class="block w-full">
              @csrf
              <button type="submit"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-[#F9FAFB] transition">
                Logout
              </button>
            </form>
          </div>
        </div>

      </div>

    </div>
  </div>
</nav>

<script>
  const btn = document.getElementById('menuBtn');
  const menu = document.getElementById('mobileMenu');
  btn.addEventListener('click', () => menu.classList.toggle('hidden'));
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById('notif-button');
  const dropdown = document.getElementById('notif-dropdown');
  let open = false;

  btn.onclick = async () => {
    if (!open) {
      const res = await fetch('{{ route('notifications.latest') }}');
      dropdown.innerHTML = await res.text();
      dropdown.classList.remove('hidden');
    } else {
      dropdown.classList.add('hidden');
    }
    open = !open;
  };

  document.addEventListener('click', e => {
    if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.add('hidden');
      open = false;
    }
  });
});
</script>
