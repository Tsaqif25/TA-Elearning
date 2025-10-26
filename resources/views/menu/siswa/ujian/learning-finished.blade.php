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



  <!-- Congratulations Section -->
  <section class="d-flex flex-column align-items-center justify-content-center text-center mt-5 mb-4 px-3">
    <div class="mb-4" style="width:200px; height:200px;">
      <img src="{{ asset('images/thumbnail/Web-Development-big.png') }}" 
     alt="icon" 
     class="img-fluid">

    </div>
    <div class="mb-3" style="max-width:374px;">
      <h1 class="fw-bold fs-3 mb-2">🎉 Congratulations! <br>You Have Finished Test</h1>
      <p class="text-secondary">Hopefully you will get a better result to prepare your great future career soon enough</p>
    </div>
    <a href="{{ route('ujian.learning.raport', $ujian->id) }}" class="btn btn-purple">View Test Result</a>
  </section>

</body>
</html>
