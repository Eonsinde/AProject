<?php
    session_start();

    include "../config/db_connc.php";
    include "../config/utils.php";

    $user = null;
    $msg = "";
    $msgClass = "";

    if (isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
    } else {
        header("Location: /AProject/login.php");
    }

    // delete project 
    if (filter_has_var(INPUT_POST, 'delete')) {
        // get form data
        $delete_id = validate($_POST["delete_id"]);
        // delete query
        $delete_query = "DELETE FROM project WHERE id={$delete_id}";

        // Execute the query
        if (mysqli_query($conn, $delete_query)) {
            $msg = "Successfully Deleted project";
            $msgClass = "green";
        } else {
            $msg = "Failed to delete project";
            $msgClass = "rose";
            // Query error
            echo 'Error '.mysqli_error($conn);
            die();
        }
    }
    
    $user_id = $user['id'];

    // crete queries
    $project_query = "SELECT * FROM project WHERE user_id = $user_id";

    // get result
    $result = mysqli_query($conn, $project_query);
    // fetch data
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <title>Dashboard | Student 1</title>
    <link rel="stylesheet" href="../static/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 overflow-hidden">
    <div class="app-container bg-neutral-900 h-[100vh]">
        <!-- include navbar component -->
        <?php include("../components/navbar.php") ?>
        <!-- main content -->
        <section class="mt-5 w-[85%] md:w-[70%] lg:w-[60%] xl:w-[55%] mx-auto"> 
            <div class="flex flex-col space-y-3 bg-neutral-800 p-3">
                <div class="flex flex-col space-y-3 bg-neutral-800 p-3">
                    <h3 class="text-white text-2xl font-bold">Welcome, <?php echo $user["username"] ?></h3>
                    <p class="text-neutral-500"><?php echo $user["email"] ?></p>
                    <div class="flex flex-col space-y-2 text-white">
                        <p>Number of projects: <?php echo count($projects) ?></p>
                        <p>Number of projects completed: <?php echo getProjectDetails($projects, "c") ?></p>
                        <p>Number of projects abandoned: <?php echo getProjectDetails($projects, "a") ?></p>
                        <p>Number of projects on-going: <?php echo getProjectDetails($projects, "o") ?></p>
                    </div>
                </div>
                <hr class="bg-neutral-100/5 h-[0.1px] w-full border-0" />
                <div class="flex items-center justify-between p-3">
                    <p class="text-white">Actions:</span></p>
                    <div class="flex space-x-2">
                        <a href="<?php echo ROOT_URL ?>user/add-project.php" class="bg-rose-800 text-white py-1 px-4">Add Project</a>
                        <a href="<?php echo ROOT_URL ?>user/edit-profile.php" class="bg-neutral-900 text-white py-1 px-4">Edit Profile</a>
                    </div>
                </div>
            </div>
            <!-- manage projects here: editing and deleting -->
            <main class="mt-6">
                <h3 class="mb-3 text-white text-2xl font-bold">Your Projects</h3>
                <!-- error msg output -->
                <?php if ($msg != ""): ?>
                    <div class="bg-<?php echo $msgClass; ?>-800 text-white py-3 px-4 mb-4"><?php echo $msg; ?></div>
                <?php endif ?>   
                  <!-- region for projects render  -->
                <div id="project-viewport" class="py-2 pr-2 h-[40vh] flex flex-col space-y-4 mx-auto overflow-y-auto">
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
                                <div class="flex items-center justify-between py-1 px-3">
                                    <p class="text-white">Actions:</span></p>
                                    <div class="flex space-x-2">
                                        <a href="<?php echo ROOT_URL ?>user/edit-project.php?id=<?php echo $project["id"] ?>" class="bg-rose-800 text-white py-1 px-4">Edit</a>
                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                            <input type="hidden" name="delete_id" value="<?php echo $project["id"] ?>" />
                                            <button type="submit" name="delete" class="bg-neutral-900 text-white py-1 px-4 outline-none">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <!-- if empty: display a message -->
                    <?php else: ?>
                        <h3 class="bg-neutral-800 py-4 px-3 text-white text-left text-lg font-bold">You have not create any projects yet</h3>
                    <?php endif ?>
                </div>
            </main>
            
        </section>
    </div>

    <script src="../static/index.js"></script>
</body>
</html>