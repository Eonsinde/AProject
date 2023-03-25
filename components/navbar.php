<?php 
    include "../config/constants.php";

    $user = null;
    
    if (isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
    } 
?>

<!-- the nav bar for the website -->
<nav class="m-nav w-[85%] md:w-[70%] lg:w-[60%] xl:w-[55%] mx-auto">
    <div class="py-5 flex justify-between items-center">
        <div class="basis-full md:basis-auto flex items-center justify-between">
            <a href="<?php echo ROOT_URL ?>index.php" class="text-white text-3xl font-bold">AProject</a>
            <button type="button" id="m-nav-toggler" class="text-white block md:hidden text-3xl">
                <i class="fa-solid fa-bars-staggered"></i>
            </button>
        </div>
        <main class="hidden md:flex space-x-6">
            <a href="<?php echo ROOT_URL ?>index.php" class="text-white text-lg">Projects</a>
            <?php if (isset($user)): ?>
                <a href="<?php echo ROOT_URL ?>user/dashboard.php" class="text-white text-white text-lg">Dashboard</a>
                <a href="<?php echo ROOT_URL ?>logout.php" class="text-white text-white text-lg">Logout</a>
            <?php else: ?>
                <a href="<?php echo ROOT_URL ?>login.php" class="text-white text-white text-lg">Login</a>
                <a href="<?php echo ROOT_URL ?>register.php" class="text-white text-white text-lg">Register</a>
            <?php endif ?>
        </main>
        <main id="mobile-nav" class="bg-neutral-800 z-20 fixed top-0 right-0 px-6 h-screen w-[380px] flex flex-col justify-center space-y-10 translate-x-full transition ease-in-out shadow-md">
            <button type="button" id="close-btn" class="absolute top-10 right-10 text-white text-3xl">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <a href="<?php echo ROOT_URL ?>index.php" class="text-white text-[3rem] font-bold">Projects</a>
            <?php if (isset($user)): ?>
                <a href="<?php echo ROOT_URL ?>user/dashboard.php" class="text-white text-[3rem] font-bold">Dashboard</a>
                <a href="<?php echo ROOT_URL ?>logout.php" class="text-white text-[3rem] font-bold">Logout</a>
            <?php else: ?>
                <a href="<?php echo ROOT_URL ?>login.php" class="text-white text-[3rem] font-bold">Login</a>
                <a href="<?php echo ROOT_URL ?>register.php" class="text-white text-[3rem] font-bold">Register</a>
            <?php endif ?>
        </main>
    </div>
</nav>