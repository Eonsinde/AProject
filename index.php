<?php
    session_start();

    include "./config/db_connc.php";
    include "./config/utils.php";

    // crete query 
    $query = "SELECT * FROM project ORDER BY id DESC";
    // get result
    $result = mysqli_query($conn, $query);
    // fetch data
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // check to see if data exists
    // var_dump($projects);
    // free result
    mysqli_free_result($result);
    // close conn 
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | All Projects</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./static/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 overflow-hidden">
    <div class="app-container bg-neutral-900 h-[100vh]">
        <?php include("components/sec-navbar.php") ?>
        <!-- main content -->
        <section class="mt-5 w-[85%] md:w-[70%] lg:w-[60%] xl:w-[55%] mx-auto"> 
            <!-- search form -->
            <form class="flex items-center justify-between space-x-2" method="GET">
                <input name="name" class="flex-grow bg-neutral-800 py-3 px-4 text-white outline-none" placeholder="Search for project" />
                <button type="submit" class="bg-rose-800 text-white py-3 px-4 text-base"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <!-- Project preview -->
            <main id="project-viewport" class="mt-4 pr-2 h-[77vh] flex flex-col space-y-4 overflow-y-auto">
                <!-- check to see if the projects array has data -->
                <?php if (count($projects) > 0): ?>
                    <?php foreach($projects as $project): ?>
                        <div class="flex flex-col space-y-3 bg-neutral-800 p-3">
                            <div class="flex justify-between items-center">
                                <h3 class="text-white text-xl font-bold"><?php echo $project["title"] ?></h3>
                                <p class="bg-<?php echo getColor($project["phase"]) ?>-700 text-white text-xs py-2 px-2 rounded-lg"><?php echo getCategoryName($project["phase"]) ?></p>
                            </div>
                            <p class="text-neutral-500"><?php echo $project["description"] ?></p>
                            <div class="flex items-center justify-between">
                                <p class="text-white">Start: <span class="text-neutral-500"><?php echo $project["start_date"] ?></span></p>
                                <p class="text-white">End: <span class="text-neutral-500"><?php echo $project["end_date"] ?></span></p>
                            </div>
                            <hr class="bg-neutral-100/5 h-[0.1px] w-full border-0" />
                            <p class="text-right text-white">Publisher: <span class="text-neutral-500">Student <?php echo $project["user_id"] ?></span></p>
                        </div>
                    <?php endforeach ?>
                <!-- if empty: display a message -->
                <?php else: ?>
                    <h3 class="mt-4 text-white text-center text-2xl font-bold">No Projects Created Yet</h3>
                <?php endif ?>
            </main>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" integrity="sha512-2bMhOkE/ACz21dJT8zBOMgMecNxx0d37NND803ExktKiKdSzdwn+L7i9fdccw/3V06gM/DBWKbYmQvKMdAA9Nw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./static/index.js"></script>
</body>
</html>