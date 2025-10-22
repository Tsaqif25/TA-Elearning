<script>
  function showTab(tab) {
    const tabs = ['materi', 'tugas', 'quiz'];
    tabs.forEach(t => {
      document.getElementById('content-' + t).classList.add('hidden');
      document.getElementById('tab-' + t).classList.remove('tab-active');
      document.getElementById('tab-' + t).classList.add('tab-inactive');
    });
    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.add('tab-active');
  }
</script>
