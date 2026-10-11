<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account</title>
<link rel="stylesheet" href="galaxy.css">
</head>

<body>

<div class="sky" aria-hidden="true">
    <div class="milky"></div>
    <div class="stars s1"></div>
    <div class="stars s2"></div>
    <div class="stars s3"></div>
    <div class="comet"></div>
</div>

<main class="card wide">

    <div class="planet" aria-hidden="true"><i></i></div>

    <h1>Create your account</h1>
    <p class="subtitle">Join the community and start exploring.</p>

    <form action="registration.php" method="POST">

        <div class="input-group">
            <label for="fullname">Full name</label>
            <input type="text" id="fullname" name="fullname" autocomplete="name" required>
        </div>

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" maxlength="25" autocomplete="username" required>
        </div>

        <div class="input-group">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" placeholder="example@email.com" autocomplete="email" required>
        </div>

        <div class="row">
            <div class="input-group">
                <label for="age">Age</label>
                <input type="number" id="age" name="age" min="1" placeholder="18" required>
            </div>

            <div class="input-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="City, Province" autocomplete="street-address" required>
            </div>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="new-password" required>
        </div>

        <div class="input-group">
            <label for="confirm_password">Confirm password</label>
            <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password" required>
        </div>

        <button type="submit" name="register">Create account</button>

    </form>

    <div class="footer">
        Already have an account?
        <a href="login.php">Sign in</a>
    </div>

</main>

</body>
</html>