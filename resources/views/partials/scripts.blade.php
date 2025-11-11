<script>
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

    // update URL
    const url = new URL(window.location.href);
    url.searchParams.set('tab', tab);
    window.history.replaceState({}, '', url);
  }

  document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const currentTab = params.get('tab') || 'materi';
    showTab(currentTab);
  });
</script>
