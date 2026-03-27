<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Regulasi Internal Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #4e73df;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .content p {
            margin-bottom: 15px;
            font-size: 16px;
        }
        .policy-details {
            background-color: #f8f9fc;
            border-left: 4px solid #4e73df;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        .policy-details p {
            margin: 5px 0;
            font-size: 15px;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #4e73df;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            background-color: #eeeeee;
            color: #777777;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SK Portal - Regulasi Internal Baru</h1>
        </div>
        
        <div class="content">
            <p>Halo,</p>
            <p>Pemberitahuan bahwa terdapat <strong>Regulasi Internal (SK) baru</strong> yang telah diterbitkan dan diunggah ke dalam sistem SK Portal.</p>
            
            <div class="policy-details">
                <p><strong>Judul:</strong> {{ $policy->title }}</p>
                <p><strong>Kategori:</strong> {{ strtoupper($policy->category) }}</p>
                <p><strong>Tanggal Berlaku:</strong> {{ $policy->effective_date ? \Carbon\Carbon::parse($policy->effective_date)->format('d M Y') : 'Menyesuaikan' }}</p>
                <p><strong>Status:</strong> Berlaku</p>
            </div>
            
            <p>Silakan klik tombol di bawah ini untuk masuk ke Dashboard Anda dan membaca peraturan terbaru terkait:</p>
            
            <div class="btn-container">
                <a href="{{ url('/user/dashboard') }}" class="btn">Lihat Regulasi di Dashboard</a>
            </div>
            
            <p>Harap membaca dan memahami regulasi terbaru ini. Jika ada pertanyaan, jangan ragu untuk menghubungi tim terkait.</p>
            
            <p>Terima kasih,<br><strong>Tim Administrasi SK & SOP</strong></p>
        </div>
        
        <div class="footer">
            &copy; {{ date('Y') }} SK Portal - Created by R Anno Hendrawan. Email ini dibuat otomatis oleh sistem.
        </div>
    </div>
</body>
</html>
