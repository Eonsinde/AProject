<?php
    session_start();

    include "../config/db_connc.php";
    include "../config/utils.php";

    $user = null;

    if (isset($_SESSION['user'])) {
        $user = unserialize($_SESSION['user']);
    } else {
        header("Location: /AProject/login.php");
    }
    
    $user_id = $user['id'];

    $msg = "";
    $msgClass = "";

    // handke submit of project
    if (filter_has_var(INPUT_POST, 'submit')) {
        // Get form data
        $title = validate($_POST["title"]);
        $description = validate($_POST["description"]);
        $start_date = validate($_POST["start_date"]);
        $end_date = validate($_POST["end_date"]);
        $phase = validate($_POST["phase"]);

        // format the date
        $formatted_start_date = date("Y/m/d", strtotime($start_date));
        $formatted_end_date = date("Y/m/d", strtotime($end_date));
        echo $formatted_start_date;
        echo $formatted_end_date;

        if (!empty($title) && !empty($description) && !empty($start_date) && !empty($end_date) && !empty($phase)) {
            if ($formatted_start_date > $formatted_end_date) {
                // Passwords do not match
                $msg = "Start and End date must be lower than End";
                $msgClass = "yellow";
            } else if ($formatted_start_date == $formatted_end_date) {
                $msg = "Start and End date must be different";
                $msgClass = "yellow";
            } else { 
                // Submit data to db and redirect to login page
                $query = "INSERT INTO project (title, description, start_date, end_date, user_id, phase) VALUES('$title', '$description', '$start_date', '$end_date', '$user_id', '$phase')";

                // Execute the query
                if (mysqli_query($conn, $query)) {
                    $msg = "Successfully created project";
                    $msgClass = "green";
                } else {
                    $msg = "Failed to create project";
                    $msgClass = "rose";
                    // Query error
                    echo 'Error '.mysqli_error($conn);
                    die();
                }
            }  
        } 
        else {
            // Failed to submit
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
    <title>Dashboard | Add Project</title>
    <link rel="stylesheet" href="../static/index.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-neutral-800 overflow-hidden">
    <div class="app-container bg-neutral-900 h-[100vh]">
        <!-- include navbar component -->
        <?php include("../components/navbar.php") ?>
        <!-- main content -->
        <section class="mt-10 w-[85%] md:w-[70%] lg:w-[60%] xl:w-[55%] mx-auto">
            <h3 class="mb-3 text-white text-2xl font-bold text-center">Add Project</h3>
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
                <button type="submit" name="submit" class="bg-rose-800 w-full text-white text-center py-3 px-4 text-base">Submit</button>
            </form>
        </section>
    </div>

    <script src="../static/index.js"></script>
</body>
</html>