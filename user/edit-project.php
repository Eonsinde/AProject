<?php
    include "../config/db_connc.php";
    include "../config/utils.php";

    session_start();

    $msg = "";
    $msgClass = "";

    // if not authenticated
    if (!isset($_SESSION['user'])) {
        header("Location: /AProject/login.php");
    }
    
    // submitting form to edit project 
    if (filter_has_var(INPUT_POST, 'submit')){
        // query string
        $update_query = "UPDATE project SET ";

        // Get form data
        $title = validate($_POST["title"]);
        $description = validate($_POST["description"]);
        $start_date = validate($_POST["start_date"]);
        $end_date = validate($_POST["end_date"]);
        $phase = validate($_POST["phase"]);
        $update_id = validate($_POST["update_id"]);

        // check to see that some field is set
        if (!empty($title) || !empty($description) || !empty($start_date) || !empty($end_date) || !empty($phase)) {
            // used to know where one is at
            $counter = 0;
            // update query string based on form data that are set
            if (!empty($title)) {
                $update_query .= "title='$title'";
                $counter += 1;
            } else if (!empty($description)) {
                if ($counter > 0){
                    $update_query .= ", description='$description'";
                } else {
                    $update_query .= "description='$description'";
                }
                $counter += 1;
            } else if (!empty($start_date)) {
                $formatted_start_date = date("d/m/Y", strtotime($start_date));
                if ($counter > 0) {
                    $update_query .= ", start_date='$formatted_start_date'";
                } else {
                    $update_query .= "start_date='$formatted_start_date'";
                }
                $counter += 1;
            } else if (!empty($end_date)) {
                $formatted_end_date = date("d/m/Y", strtotime($end_date));
                if ($counter > 0) {
                    $update_query .= ", end_date='$formatted_end_date'";
                } else {
                    $update_query .= "end_date='$formatted_end_date'";
                }
                $counter += 1;
            } else if(!empty($phase)) {
                if ($counter > 0) {
                    $update_query .= ", phase='$phase'";
                } else {
                    $update_query .= "phase='$phase'";
                }
                $counter += 1;
            }

            // finay, set the id of the project to update
            $update_query .= " WHERE id={$update_id}";

            // die($update_query);
            if (mysqli_query($conn, $update_query)) {
                $msg = "Successfully updated project";
                $msgClass = "green";
            } else {
                $msg = "Failed to update project";
                $msgClass = "rose";
                // Query error
                echo 'Error '.mysqli_error($conn);
                die();
            }
        } else {
            $msg = "Please fill in a field";
            $msgClass = "rose";
        }
    }

    // get the project to be updated from the db
    $project_id = "";

    if (isset($_SESSION['project_id'])) { // after a refresh 
        $project_id = $_SESSION['project_id'];
    } else { // when u come to the page newly
        $_SESSION['project_id'] = $_GET['id']; 
        $project_id = $_GET['project_id'];
    }

    if (isset($project_id)) {
        // crete queries
        $project_query = "SELECT * FROM project WHERE id = $project_id";

        // get result
        $result = mysqli_query($conn, $project_query);
        // fetch data
        $project = mysqli_fetch_all($result, MYSQLI_ASSOC);
        // free result
        mysqli_free_result($result);
        // close conn 
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Edit Project</title>
    <link rel="stylesheet" href="../static/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 overflow-hidden">
    <div class="app-container bg-neutral-900 h-[100vh]">
        <!-- include navbar component -->
        <?php include("../components/navbar.php") ?>
        <!-- main content -->
        <section class="mt-10 w-[85%] md:w-[70%] lg:w-[60%] xl:w-[55%] mx-auto">
            <h3 class="mb-3 text-white text-2xl font-bold text-center">Edit Project: <?php echo $project[0]["title"]." (".$project_id.")" ?></h3> 
            <!-- error msg output -->
            <?php if ($msg != ""): ?>
                <div class="bg-<?php echo $msgClass; ?>-800 text-white py-3 px-4 mb-4"><?php echo $msg; ?></div>
            <?php endif ?>     
            <form class="flex flex-col space-y-4" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div>
                    <label class="block text-base text-white mb-2">Title</label>
                    <input 
                        name="title" 
                        class="bg-neutral-800 w-full py-3 px-4 text-white outline-none" 
                    />
                </div>
                <div>
                    <label class="block text-base text-white mb-2">Description</label>
                    <textarea 
                        name="description" 
                        class="bg-neutral-800 h-52 w-full py-3 px-4 text-white outline-none" 
                    ></textarea>
                </div>
                <div class="flex justify-between items-center">
                    <div class="basis-6/12 mr-4">
                        <label class="block text-base text-white mb-2">Start Date</label>
                        <input type="date" name="start_date" class="bg-neutral-800 w-full py-3 px-4 text-white outline-none"/>
                    </div>
                    <div class="basis-6/12">
                        <label class="block text-base text-white mb-2">Finish Date</label>
                        <input type="date" name="end_date" class="bg-neutral-800 w-full py-3 px-4 text-white outline-none"/>
                    </div>
                </div>
                <div>
                    <label class="block text-base text-white mb-2">Phase</label>
                    <select name="phase" class="w-full bg-neutral-800 py-3 px-4 text-white outline-none">
                        <option value="">Select a phase</option>
                        <option value="o">On Going</option>
                        <option value="c">Completed</option>
                        <option value="a">Abandoned</option>
                    </select>
                </div>
                <input type="hidden" name="update_id" value="<?php echo $project_id ?>" />
                <button type="submit" name="submit" class="bg-rose-800 w-full text-white text-center py-3 px-4 text-base">Submit</button>
            </form>
        </section>
    </div>

    <script src="../static/index.js"></script>
</body>
</html>