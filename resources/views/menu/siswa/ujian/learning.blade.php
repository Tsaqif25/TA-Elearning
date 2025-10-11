<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Marketing Quiz</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      color: #0A090B;
    }
    
    .navbar-custom {
      height: 92px;
      border-bottom: 1px solid #EEEEEE;
    }
    
    .thumbnail-img {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
    }
    
    .course-title {
      font-weight: 700;
      font-size: 18px;
      margin-bottom: 2px;
    }
    
    .course-level {
      color: #7F8190;
      font-size: 14px;
    }
    
    .user-greeting {
      font-size: 14px;
      color: #7F8190;
    }
    
    .user-name {
      font-weight: 600;
    }
    
    .user-photo {
      width: 46px;
      height: 46px;
    }
    
    .quiz-title {
      font-weight: 800;
      font-size: 46px;
      line-height: 69px;
      max-width: 821px;
      margin: 50px auto 50px;
    }
    
    .answer-option {
      border: 1px solid #EEEEEE;
      border-radius: 50px;
      padding: 18px 20px;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 30px;
    }
    
    .answer-option:hover {
      border-color: #6436F1;
    }
    
    .answer-option input[type="radio"] {
      display: none;
    }
    
    .answer-option input[type="radio"]:checked + .answer-content {
      border-color: #0A090B;
      border-width: 2px;
    }
    
    .answer-option.selected {
      border: 2px solid #0A090B;
    }
    
    .answer-text {
      font-weight: 600;
      font-size: 20px;
      line-height: 30px;
      margin: 0;
    }
    
    .check-icon {
      display: none;
      width: 24px;
      height: 24px;
    }
    
    .answer-option.selected .check-icon {
      display: block;
    }
    
    .arrow-icon {
      width: 24px;
      height: 24px;
      margin-right: 14px;
    }
    
    .btn-submit {
      background-color: #6436F1;
      color: white;
      font-weight: 700;
      font-size: 14px;
      padding: 14px 40px;
      border-radius: 50px;
      border: none;
      transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
      box-shadow: 0 4px 15px 0 rgba(100, 54, 241, 0.3);
      background-color: #6436F1;
      color: white;
    }
    
    .options-container {
      max-width: 750px;
      margin: 0 auto;
    }
    
    @media (max-width: 768px) {
      .quiz-title {
        font-size: 32px;
        line-height: 48px;
      }
      
      .answer-text {
        font-size: 16px;
      }
    }
  </style>
</head>
<body>
  <!-- Navigation -->
 

  <!-- Quiz Content -->
<section class="container py-5">
  <form action="{{ route('ujian.answer.store', ['ujian' => $ujian->id, 'soal' => $soal->id]) }}" method="POST">
    @csrf
    <h3 class="text-center mb-4 fw-bold">{{ $soal->soal }}</h3>

    @foreach ($soal->answer as $answers)
      <label class="d-flex justify-content-between align-items-center border p-3 rounded mb-2">
        <span>{{ $answers->jawaban }}</span>
        <input type="radio" name="answer_id" value="{{ $answers->id }}" required>
      </label>
    @endforeach

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-primary">Save & Next</button>
    </div>
  </form>
</section>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Tambah efek styling saat pilih jawaban
    document.querySelectorAll('.answer-option').forEach(option => {
        option.addEventListener('click', function() {
            // reset semua option
            document.querySelectorAll('.answer-option').forEach(opt => opt.classList.remove('selected'));

            // aktifkan yg dipilih
            this.classList.add('selected');

            // centang radio
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
</script>
<style>
    /* styling biar terlihat jelas saat dipilih */
    .answer-option.selected {
        border: 2px solid #6436F1;
        background-color: #f5f3ff;
    }
</style>
</body>
</html>