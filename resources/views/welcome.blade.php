<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Send Test</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        p {
            font-size: 18px;
            color: #202124;
            margin: 0 0 20px;
        }

        button {
            background-color: #1a73e8;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        button a {
            color: #fff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Connect Gmail Account</p>
        <button type="button"><a href="/login">CONNECT</a></button>
        <button type="button"><a href="/test-page">send page</a></button>
        <button type="button"><a href="/token-list">token list</a></button>
        <button type="button"><a href="/drop-list">drop list</a></button>
    </div>
</body>
</html>
