{{-- resources/views/partials/scripts.blade.php --}}
<script>
  //  Sidebar toggle logic
  function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('hidden');
    document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
  }

  //  Reset sidebar state saat window diperbesar
  window.addEventListener('resize', () => {
    if (window.innerWidth > 1024) {
      document.getElementById('sidebar').classList.remove('active');
      document.getElementById('overlay').classList.add('hidden');
      document.body.style.overflow = '';
    }
  });

  //  Tab Navigation Handler (materi, tugas, quiz)
  function showTab(tab) {
    const tabs = ['materi', 'tugas', 'quiz'];
    
    tabs.forEach(t => {
      const content = document.getElementById('content-' + t);
      const button = document.getElementById('tab-' + t);
      if (content && button) {
        content.classList.add('hidden');
        button.classList.remove('tab-active');
        button.classList.add('tab-inactive');
      }
    });

    const activeContent = document.getElementById('content-' + tab);
    const activeButton = document.getElementById('tab-' + tab);
    if (activeContent && activeButton) {
      activeContent.classList.remove('hidden');
      activeButton.classList.add('tab-active');
      activeButton.classList.remove('tab-inactive');
    }

    //  Update URL tanpa reload
    const url = new URL(window.location.href);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);
  }

  //  Saat reload halaman, buka tab sesuai URL
  document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const currentTab = params.get('tab') || 'materi';
    showTab(currentTab);
  });
</script>
