<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Payment Page</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .payment-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-details {
            background-color: #007bff;
            color: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .card-details h5 {
            margin: 0 0 10px 0;
        }
        .card-details p {
            margin: 5px 0;
        }
        .btn-pay {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-pay:hover {
            background-color: #0056b3;
        }
        .instruction {
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        .service-pricing {
            margin-bottom: 20px;
        }
        .service-pricing p {
            margin: 5px 0;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h3 class="text-center mb-4">To'lov Sahifasi</h3>
        
        <div class="card-details">
            <h5>Karta ma'lumotlari</h5>
            <p><strong>Karta egasi:</strong> ECOURSES</p>
            <p><strong>Karta raqami:</strong> 8600 1234 5678 9012</p>
        </div>

        <div class="service-pricing">
            <h5>Xizmat narxlari</h5>
            <p>✅ 1 oylik foydalanish: <strong>30 000 so'm</strong></p>
            <p>✅ 2 oylik foydalanish: <strong>60 000 so'm</strong></p>
        </div>
        
        <a target="_blank" href="https://t.me/ozodbek_shodiboyev" class="btn btn-pay btn-block">Chekni yuborish</a>
        
        <div class="instruction">
            <p>Istalgan bank orqali kartaga to'lov qilib, chekni yuborish tugmasini bosing va telegram administratorga chekni yuboring!</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
