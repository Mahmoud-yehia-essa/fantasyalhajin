<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>فانتسي الهجن</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');

    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Tajawal', sans-serif;
      background: linear-gradient(135deg, #B03727, #7a251b);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      min-height: 100vh;
      text-align: center;
      overflow-x: hidden;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      width: 100%;
      animation: fadeIn 1.5s ease-in-out;
    }

    .logo {
      width: 180px;
      height: auto;
      margin-bottom: 25px;
      animation: float 3s ease-in-out infinite;
    }

    h1 {
      font-size: 2.2rem;
      margin-bottom: 15px;
      line-height: 1.6;
    }

    p {
      font-size: 1.1rem;
      opacity: 0.9;
      margin-bottom: 30px;
    }

    .stores {
      display: flex;
      gap: 15px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .stores img {
      width: 150px;
      max-width: 45%;
      transition: transform 0.3s ease;
      border-radius: 8px;
    }

    .stores img:hover {
      transform: scale(1.05);
    }

    footer {
      margin-top: 40px;
      font-size: 0.9rem;
      opacity: 0.8;
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0); }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive design */
    @media (max-width: 480px) {
      h1 {
        font-size: 1.6rem;
      }
      p {
        font-size: 1rem;
      }
      .logo {
        width: 140px;
      }
      .stores img {
        width: 130px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <img src="{{ asset('backend/assets/images/logo-icon.png') }}" alt="شعار فانتسي الهجن" class="logo" />
    <h1>قريباً تطبيق فانتسي الهجن</h1>
    <p>استعد لتجربة تفاعلية فريدة في عالم سباقات الهجن — متوفّر قريباً على المتاجر الرسمية</p>
    <div class="stores">
      <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
      <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store">
    </div>
    <footer>© 2025 جميع الحقوق محفوظة لتطبيق فانتسي الهجن</footer>
  </div>
</body>
</html>
