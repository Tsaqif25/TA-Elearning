<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Finish Test - Digital Marketing 101</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      color: #0A090B;
    }
    .btn-purple {
      background-color: #6436F1;
      color: #fff;
      font-weight: 700;
      border-radius: 50px;
      padding: 14px 30px;
      font-size: 14px;
    }
    .btn-purple:hover {
      box-shadow: 0 4px 15px rgba(100,54,241,.3);
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="border-bottom">
    <div class="container d-flex justify-content-between align-items-center py-3">
      <!-- Left: Course Info -->
      <div class="d-flex align-items-center gap-3">
        <div class="rounded-circle overflow-hidden" style="width:50px; height:50px;">
          <img src="assets/images/thumbnail/Digital-Marketing-101.png" class="img-fluid" alt="thumbnail">
        </div>
        <div>
          <p class="fw-bold mb-0">Digital Marketing 101</p>
          <small class="text-secondary">Beginners</small>
        </div>
      </div>
      <!-- Right: User Info -->
      <div class="d-flex align-items-center gap-3">
        <div class="text-end">
          <small class="text-secondary d-block">Howdy</small>
          <span class="fw-semibold">Bondan Poro</span>
        </div>
        <div class="rounded-circle overflow-hidden" style="width:46px; height:46px;">
          <img src="assets/images/photos/default-photo.svg" class="img-fluid" alt="photo">
        </div>
      </div>
    </div>
  </header>

  <!-- Congratulations Section -->
<section class="text-center py-5">
  <img src="/assets/images/thumbnail/Web-Development-big.png" width="200" class="mb-4">
  <h2 class="fw-bold mb-2">🎉 Congratulations! You’ve Finished the Test</h2>
  <p class="text-muted">See your results and improve for the next test.</p>
  <a href="{{ route('ujian.learning.rapport', $ujian->id) }}" class="btn btn-primary mt-3">View Test Result</a>
</section>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
