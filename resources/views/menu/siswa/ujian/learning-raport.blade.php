<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rapport Details</title>

  <!-- Bootstrap CSS -->
  {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      color: #0A090B;
      background-color: #fff;
    }
    .sidebar {
      width: 270px;
      min-height: 100vh;
      background: #FBFBFB;
      border-right: 1px solid #EEEEEE;
      padding: 30px;
    }
    .sidebar .nav-link {
      border-radius: 50px;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      color: #0A090B;
      font-weight: 600;
      transition: all 0.3s;
    }
    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: #2B82FE;
      color: #fff !important;
    }
    .notif {
      width: 20px;
      height: 20px;
      font-size: 10px;
      font-weight: 700;
      background: #F6770B;
      color: #fff;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .status-badge {
      padding: 14px 20px;
      border-radius: 10px;
      font-weight: 700;
      color: #fff;
      outline-offset: 7px;
    }
    .status-failed {
      background: #FD445E;
      outline: 3px dashed #FD445E;
    }
    .status-success {
      background: #06BC65;
      outline: 3px dashed #06BC65;
    }
    .btn-dark, .btn-primary {
      border-radius: 50px;
      padding: 14px 20px;
      font-weight: 600;
    }
    .question-card {
      border: 1px solid #EEEEEE;
      border-radius: 20px;
      padding: 16px;
    }
  </style>
</head>
<body>
  <section id="content" class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar d-none d-md-flex flex-column justify-content-between">
      <div>
        <div class="text-center mb-4">
          <img src="assets/images/logo/logo.svg" alt="logo" class="img-fluid" style="max-height:40px;">
        </div>
        <h6 class="text-uppercase text-secondary fw-bold small mb-2">Daily Use</h6>
        <ul class="nav flex-column mb-4">
          <li><a href="#" class="nav-link"><i class="bi bi-house"></i> Overview</a></li>
          <li><a href="#" class="nav-link active"><i class="bi bi-journal"></i> Courses</a></li>
          <li><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificates</a></li>
          <li class="d-flex align-items-center justify-content-between">
            <a href="#" class="nav-link"><i class="bi bi-chat"></i> Messages</a>
            <span class="notif">12</span>
          </li>
        </ul>
        <h6 class="text-uppercase text-secondary fw-bold small mb-2">Others</h6>
        <ul class="nav flex-column">
          <li><a href="#" class="nav-link"><i class="bi bi-gift"></i> Rewards</a></li>
          <li><a href="#" class="nav-link"><i class="bi bi-stars"></i> A.I Plugins</a></li>
          <li><a href="#" class="nav-link"><i class="bi bi-gear"></i> Settings</a></li>
          <li><a href="signin.html" class="nav-link"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
        </ul>
      </div>
    </div>

    <!-- Main Content -->
    <div id="menu-content" class="flex-grow-1">
      <!-- Navbar -->
      <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
        <form class="d-flex border rounded-pill px-3" style="width:400px; height:52px;">
          <input type="text" class="form-control border-0" placeholder="Search by report, student, etc" name="search">
          <button type="submit" class="btn btn-link"><i class="bi bi-search"></i></button>
        </form>
        <div class="d-flex align-items-center gap-3">
          <a href="#" class="btn border rounded-circle p-2"><i class="bi bi-receipt"></i></a>
          <a href="#" class="btn border rounded-circle p-2"><i class="bi bi-bell"></i></a>
          <div class="vr"></div>
          <div class="d-flex align-items-center gap-2">
            <div class="text-end">
              <p class="mb-0 small text-secondary">Howdy</p>
              <p class="mb-0 fw-semibold">Bondan Poro</p>
            </div>
            <img src="assets/images/photos/default-photo.svg" class="rounded-circle" style="width:46px; height:46px;">
          </div>
        </div>
      </div>

      <!-- Breadcrumb -->
      <div class="px-3 py-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="#" class="text-secondary">Home</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-secondary">My Courses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Rapport Details</li>
          </ol>
        </nav>
      </div>

      <!-- Header -->
      <div class="d-flex justify-content-between align-items-center mx-3 mx-md-5 my-4 flex-wrap">
        <div class="d-flex gap-4 align-items-center">
          <div class="position-relative" style="width:150px; height:150px;">
            <img src="assets/images/thumbnail/Web-Development.png" class="img-fluid rounded">
            <span class="position-absolute bottom-0 start-50 translate-middle badge bg-warning text-dark fw-bold">Product Design</span>
          </div>
          <div>
            <h1 class="fw-bold fs-3">Digital Marketing 101</h1>
            <div class="d-flex align-items-center gap-2">
              <i class="bi bi-clipboard-check-fill text-primary"></i>
              <span class="fw-semibold">6 of 6 correct</span>
            </div>
          </div>
        </div>
        <div class="mt-3 mt-md-0">
          <span class="status-badge status-failed">Not Passed</span>
        </div>
      </div>

      <!-- Results -->
     <section class="container py-5">
  <h2 class="fw-bold mb-4 text-center">Test Results</h2>
  @forelse ($studentAnswers as $answer)
    @php
        $correct = $answer->soalUjianMultiple->answer->firstWhere('is_correct', 1);
        $isCorrect = $correct && $answer->user_jawaban == $correct->jawaban;
    @endphp
    <div class="p-3 border rounded mb-3">
      <p class="fw-bold">{{ $answer->soalUjianMultiple->soal }}</p>
      <p>Your Answer: <strong>{{ $answer->user_jawaban }}</strong></p>
      <p>Correct Answer: <strong>{{ $correct ? $correct->jawaban : '-' }}</strong></p>
      <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }}">
        {{ $isCorrect ? 'Correct' : 'Wrong' }}
      </span>
    </div>
  @empty
    <p class="text-muted text-center">You haven’t answered any questions yet.</p>
  @endforelse
</section>


      <!-- Action Buttons -->
      <div class="d-flex gap-3 mx-3 mx-md-5 mb-5 flex-wrap">
        <a href="#" class="btn btn-dark"><i class="bi bi-arrow-repeat me-2"></i>Request Retake</a>
        <a href="#" class="btn btn-primary"><i class="bi bi-envelope me-2"></i>Contact Teacher</a>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
