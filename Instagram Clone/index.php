<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <script src="validate.js"></script>
</head>
<body>
    <!-- Login or create new account -->
    <form id="Form" method="POST" class="red-fill">
        <div class="image-container">
            <img class="logo" src="./css/pic.png" alt="Logo">
        </div>

        <input type="submit" name="login" id="login" value="Login"/>
        <input type="submit" name="register" id="register" value="Create Account"/>
    </form>
    
    <!-- Basic introcuction text -->
    <section>
        <h1>Welcome to RPost!</h1>

        <h1>Join the online RPI community to keep up to date on current events!</h1>
    </section>

    <script>
        // redirects you to login.php
        document.getElementById("login").addEventListener("click", function() {
            document.getElementById("Form").action = "./pages/login/login.html";
        });

        // redirects you to register.php
        document.getElementById("register").addEventListener("click", function() {
            document.getElementById("Form").action = "./pages/register/register.html";
        });
    </script>

</body>
</html>