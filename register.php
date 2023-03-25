<?php
    session_start();
    
    include "./config/db_connc.php";
    include "./config/utils.php";

    $msg = "";
    $msgClass = "";

    if (filter_has_var(INPUT_POST, 'submit')){
        // get form data
        $username = validate($_POST["username"]);
        $email = validate($_POST["email"]);
        $password = validate($_POST["password"]);
        $confirm_password = validate($_POST["confirm_password"]);

        if (!empty($username) && !empty($email) && !empty($password) && !empty($confirm_password)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
                // email not valid
                $msg = "Please enter a valid email address";
                $msgClass = "yellow";
            } else if ($password != $confirm_password){
                // passwords do not match
                $msg = "Passwords do not match";
                $msgClass = "yellow";
            } else if (strlen($password) < 8){
                // password is too short
                $msg = "Password must be greater than 8 characters";
                $msgClass = "yellow";
            } else { 
                // submit data to db and redirect to login page
                /* Secure password hash. */
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                /* Query template. */
                $query = "INSERT INTO user (username, email, password) VALUES('$username', '$email', '$hashed_password')";

                /* Execute the query. */
                if (mysqli_query($conn, $query)) {
                    $_SESSION['registration_success'] = true;
                    header("Location: /AProject/login.php");
                } else {
                    /* Query error. */
                    echo 'Error'.mysqli_error($conn);
                    die();
                }
            }  
        } 
        else {
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
    <title>AProject | Create Account</title>
    <link rel="stylesheet" href="./static/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 overflow-hidden">
    <div class="app-container  h-[100vh] flex justify-center items-center">
        <!-- main content -->
        <section class="bg-neutral-900 w-[85%] md:w-[70%] lg:w-[60%] xl:w-[55%] mx-auto p-10 shadow-lg">
            <div class="mb-5 text-white text-2xl font-bold text-center"><a href="index.php">AProject</a> | Create Account</div> 
            <!-- error msg output -->
            <?php if ($msg != ""): ?>
                <div class="bg-<?php echo $msgClass; ?>-800 text-white py-3 px-4 mb-4"><?php echo $msg; ?></div>
            <?php endif ?>    
            <!-- registration form -->
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
                    <label class="block text-base text-white mb-2">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" 
                        value="<?php echo isset($_POST['email']) ? $email : "" ?>" 
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
                <div>
                    <label class="block text-base text-white mb-2">Confirm Password</label>
                    <input 
                        type="password" 
                        name="confirm_password" 
                        class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" 
                        value="<?php echo isset($_POST['confirm_password']) ? $confirm_password : "" ?>" 
                    />
                </div>
                <button type="submit" name="submit" class="bg-rose-800 w-full text-white text-center py-3 px-4 text-base">Register</button>
                <div class="pt-4 flex justify-between items-center text-white">
                    <p>Already Regsitered?</p>
                    <a href="login.php" class="text-neutral-500">Login</a>
                </div>
            </form>
        </section>
    </div>
</body>
</html>