<!DOCTYPE html>
<html>
    <head>
        <title>Tailwebs</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                font-family: Arial, sans-serif;
            }
            .center {
                border: 1px solid #ccc;
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 300px;
                background-color: #f9f9f9;
                /* margin: 0 auto; */
            }
            .center h2 {
                margin-top: 0;
            }
            .center label {
                display: block;
                margin-bottom: 5px;
            }
            .center input {
                width: 100%;
                padding: 8px;
                margin-bottom: 10px;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
            }
            .center button {
                width: 100%;
                padding: 10px;
                border: none;
                border-radius: 4px;
                background-color: black;
                color: white;
                font-size: 16px;
                cursor: pointer;
            }
            .center button:hover {
                background-color: #606870;
            }
            .error {
                color: red;
            }
        </style>
    </head>
<body>

    <div class="center">
        <h2>Login</h2>

        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('teacher.login') }}">
            @csrf
            <label>Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label>Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>
