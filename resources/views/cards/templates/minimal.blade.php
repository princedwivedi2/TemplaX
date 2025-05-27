<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Business Card Template</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
    }

    .business-card {
      width: 700px;
      height: 350px;
      background: white;
      display: flex;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      overflow: hidden;
      position: relative;
      margin: 50px auto;
    }

    .left-section {
      flex: 1;
      background: black;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }

    .left-section h1 {
      font-size: 38px;
      margin: 0;
    }

    .left-section p {
      font-size: 18px;
      margin-top: 10px;
    }

    .right-section {
      flex: 2;
      padding: 30px;
      background: white;
      color: #5a4e4e;
      position: relative;
    }

    .contact-item {
      margin: 10px 0;
      display: flex;
      align-items: center;
      font-size: 18px;
    }

    .contact-item i {
      margin-right: 15px;
      color: #c0392b;
      font-size: 20px;
      width: 25px;
    }

    .curve {
      position: absolute;
      bottom: 0;
      left: 0;
      height: 80px;
      width: 100%;
      background: linear-gradient(to right, black, red, #d3b9b9);
      clip-path: ellipse(100% 100% at 50% 100%);
    }

    .dotted-line {
      position: absolute;
      left: 33%;
      top: 20px;
      bottom: 20px;
      width: 1px;
      border-left: 2px dotted #a44;
    }
  </style>
</head>
<body>

<div class="business-card">
  <div class="left-section">
    <h1>{{ $name }}</h1>
    <p>{{ $position }}</p>
  </div>

  <div class="dotted-line"></div>

  <div class="right-section">
    <div class="contact-item">
      <i class="fas fa-map-marker-alt"></i> {{ $address }}
    </div>
    <div class="contact-item">
      <i class="fas fa-phone"></i> {{ $phone }}
    </div>
    <div class="contact-item">
      <i class="fas fa-mobile-alt"></i> {{ $mobile }}
    </div>
    <div class="contact-item">
      <i class="fas fa-envelope"></i> {{ $email }}
    </div>
    <div class="contact-item">
      <i class="fas fa-globe"></i> {{ $website }}
    </div>

    <div class="curve"></div>
  </div>
</div>

</body>
</html>
