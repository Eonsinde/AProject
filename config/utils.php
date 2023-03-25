<?php
    function validate($data){
        $data = trim($data);
    
        $data = stripslashes($data);
    
        $data = htmlspecialchars($data);
    
        return $data;
    }

    function getCategoryName($str) {
        if ($str == "o"){
            return "On-Going";
        } else if ($str == "c") {
            return "Completed";
        } else {
            return "Abandoned";
        }
    }   

    function getColor($str) {
        if ($str == "o"){
            return "cyan";
        } else if ($str == "c") {
            return "green";
        } else {
            return "rose";
        }
    }  
    
    function getProjectDetails($projects, $phase) {
        $count = 0;

        foreach ($projects as $project) {
            if ($project["phase"] == $phase) {
                $count += 1;
            }
        }

        return $count;
    }
?>
