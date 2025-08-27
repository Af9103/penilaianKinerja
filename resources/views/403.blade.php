<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Forbidden</title>
    <link href="../asset/img/k-logo.jpg" rel="icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: #ffffff;
            color: #000;
            text-align: center;
        }

        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            color: #000;
        }

        .icon-lock {
            font-size: 80px;
        }

        h1 {
            font-size: 2.5em;
            margin: 15px 0;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 1.1em;
            font-weight: bold;
            text-decoration: none;
            background: #ff5e62;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn:hover {
            background: #e04852;
            color: #fff;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="icon-lock">🔒</div>
        <h1>Access Denied</h1>
        <p>Sorry, you don't have permission to access this page.</p>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="btn">Back to Home</button>
        </form>
    </div>
</body>

</html>
