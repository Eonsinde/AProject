<?php
    session_start();
    
    $msg = "";
    $msgClass = "";

    // if not authenticated
    if (!isset($_SESSION['user'])) {
        header("Location: /AProject/login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Edit Profile</title>
    <link rel="stylesheet" href="../static/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 overflow-hidden">
    <div class="app-container bg-neutral-900 h-[100vh]">
        <!-- include navbar component -->
        <?php include("../components/navbar.php") ?>
        <!-- main content -->
        <section class="mt-10 w-[85%] md:w-[70%] lg:w-[60%] xl:w-[55%] mx-auto">
            <h3 class="mb-5 text-white text-2xl font-bold text-center">Update Your Profile</h3> 
            <form class="flex flex-col space-y-4" action="" method="POST">
                <div>
                    <label class="block text-base text-white mb-2">Username</label>
                    <input name="username" class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" placeholder="" />
                </div>
                <div>
                    <label class="block text-base text-white mb-2">Email</label>
                    <input type="email" name="email" class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" placeholder="" />
                </div>
                <div>
                    <label class="block text-base text-white mb-2">Password</label>
                    <input type="password" name="password" class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" placeholder="" />
                </div>
                <div>
                    <label class="block text-base text-white mb-2">Confirm Password</label>
                    <input type="password" class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" placeholder="" />
                </div>
                <button type="submit" class="bg-rose-800 w-full text-white text-center py-3 px-4 text-base">Submit</button>
            </form>
        </section>
    </div>

    <script src="../static/index.js"></script>
</body>
</html>