<!DOCTYPE html>
<html>
<head>
  <title>TrendyOne</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body.landing {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: DarkSeaGreen;
      font-family: 'Segoe UI', sans-serif;
      background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
    }

    .center-box {
      text-align: center;
      background: cornsilk;
      padding: 100px 80px;
      border-radius: 16px;
      box-shadow: 0 6px 30px rgba(0, 0, 0, 1.08);
      max-width: 500px;
      width: 100%;
      
    }

    .brand-name {
      font-size: 48px;
      font-weight: bold;
      color: #2D2E32;
      letter-spacing: 1px;
      font-family: papyrus;
    }

    .tagline {
      font-size: 18px;
      font-weight: bold;
      color: #7F5AF0;
      margin-top: 10px;
      margin-bottom: 30px;
      font-family: Javanese Text;
    }

    .btn {
      background-color: #28a745;
      color: white;
      padding: 12px 28px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background-color: #6845e3;
    }
  </style>
</head>
<body class="landing">
  <div class="center-box">
    <div class="brand-name">TrendyOne</div>
    <div class="tagline">Your Trend Begins Here</div>
    <a href="login.php" class="btn">Let's Shop</a>
  </div>
</body>
</html>
