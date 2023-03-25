<?php
    session_start(); 

    include "./config/db_connc.php";
    include "./config/utils.php";

    $msg = "";
    $msgClass = "";

    // see if user already logged in
    if (isset($_SESSION['user'])) {
        header("Location: /AProject/user/dashboard.php");
    } 

    // show success message to user upon successful registration
    if (isset($_SESSION['registration_success'])) {
        $msg = "Registration successful! login to proceed to dashboard";
        $msgClass = "green";
        unset($_SESSION['registration_success']);
    }

    if (filter_has_var(INPUT_POST, 'submit')) {
        // get form data
        $username = validate($_POST["username"]);
        $password = validate($_POST["password"]);

        if (!empty($username) && !empty($password)) {
            // make request to database for username and check the password
            $query = "SELECT * FROM user WHERE username='$username'";
            // get result
            $result = mysqli_query($conn, $query);
            // fetch data
            $user = mysqli_fetch_assoc($result);

            if (!(mysqli_num_rows($result) == 1)) {
                // see if username wasn't found
                $msg = "Account not found";
                $msgClass = "yellow";
            } else {
                if (password_verify($password, $user['password'])) {
                    /* The password is correct. */
                    $_SESSION['user'] = serialize($user);
                    // redirect to dashboard on successful verification
                    header("Location: /AProject/user/dashboard.php");
                } else {
                    // incorrect password
                    $msg = "Password is incorrect";
                    $msgClass = "yellow";
                }
            }
            
            // free result
            mysqli_free_result($result);
            // close connection
            mysqli_close($conn);
        } else {
            // failed to submit
            $msg = "Please fill in all fields";
            $msgClass = "rose";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AProject | Login</title>
    <link rel="stylesheet" href="./static/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 overflow-hidden">
    <div class="app-container  h-[100vh] flex justify-center items-center">
        <!-- main content -->
        <section class="bg-neutral-900 w-[90%] md:w-[60%] lg:w-[55%] xl:w-[45%] mx-auto p-10 shadow-lg">
            <div class="mb-5 text-white text-2xl font-bold text-center"><a href="index.php">AProject</a> | Sign In</div> 
            <!-- error msg output -->
            <?php if ($msg != ""): ?>
                <div class="bg-<?php echo $msgClass; ?>-800 text-white py-3 px-4 mb-4"><?php echo $msg; ?></div>
            <?php endif ?>    
            <form class="flex flex-col space-y-4" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div>
                    <label class="block text-base text-white mb-2">Username</label>
                    <input 
                        name="username" 
                        class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" 
                        value="<?php echo isset($_POST['username']) ? $username : "" ?>" 
                    />
                </div>
                <div>
                    <label class="block text-base text-white mb-2">Password</label>
                    <input 
                        type="password"
                        name="password" 
                        class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" 
                        value="<?php echo isset($_POST['password']) ? $password : "" ?>" 
                    />
                </div>
                <button type="submit" name="submit" class="bg-rose-800 w-full text-white text-center py-3 px-4 text-base">Login</button>
                <div class="pt-4 flex justify-between items-center text-white">
                    <p>Not Yet Registered?</p>
                    <a href="register.php" class="text-neutral-500">Register</a>
                </div>
            </form>
        </section>
    </div>
</body>
</html>