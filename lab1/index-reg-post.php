<?php
    $PAGE_TITLE = "Регистрация";
    $PAGE_JS = Array();  
    include "include/header.php";

    function getVariable($varName, $varValue = "") 
    {
        $var = $varValue;
        if(($_SERVER ['REQUEST_METHOD'] == 'POST') && isset($_POST[$varName]))
        {
            $var = $_POST[$varName];
        }
        $var = stripslashes($var);
        $var = str_replace("\"", "&quot;", $var);
        return $var;
    }

    function validateName($name, $errName = "")
    {
        if(!preg_match("/^[a-zA-Zа-яёА-ЯЁ]+$/u",$name))
            $errName = "Incorrect name.";
        return $errName;
    }

    function validateDate($day, $month, $year, $errDate = "")
    {
        if (!preg_match("/^[0-2]\d|3[01]$/",$day) || !preg_match("/^0[1-9]|1[012]$/",$month) || !preg_match("/^\d{4}$/",$year))
            $errDate = "Incorrect date";
        return $errDate;
    }

    function validateGender($gender, $day, $month, $year, $errGender = "")
    {
        if(!empty($gender))
        {
            $yDiff  = date("Y") - $year;
            $mDiff = date("m") - $month;
            $dDiff   = date("d") - $day;
            if (($mDiff < 0 ) || ($mDiff == 0 && $dDiff < 0))
                $yDiff--; 
            if($yDiff < 21 && $gender == "man")
                $errGender = "Age of the man must be over 21.";
            else if($yDiff < 18 && $gender == "woman")
                $errGender = "Age of the woman must be over 18.";
        }
        else
            $errGender = "Select gender.";
        return $errGender;
    }

    $action = getVariable("action","");
    $name = getVariable("name","");
    $gender = getVariable("gender","");
    $day = getVariable("day","");
    $month = getVariable("month","");
    $year = getVariable("year","");

    $name = trim($name);
    $day = trim($day);
    $month = trim($month);
    $year = trim($year);

    $showForm = true;

    if($action == "check-post")
    {
        $errName = validateName($name);
        $errDate = validateDate($day, $month, $year);
        if($errName == "" && $errDate == "")
        {
            $errGender = validateGender($gender, $day, $month, $year);
            if($errGender == "")
                $showForm = false;
        }
    }
?>
            <div>Registration</div>
<?php
    if($showForm) 
    {
?>
            <form id="reg-form" name="registration" method="post" action="index-reg-post.php">
                <input type="hidden" name="action" value="check-post">
                <label>
                    Name:
                    <input type="text" name="name" id="input-name" title="Only letters." value="<?=$name;?>">
                    <span class="error" id="errorName"><?=$errName;?></span>
                </label>
                <br>
                <label>
                    Gender:
                    <input type="radio" id="sex-man" name="gender" value="man" <?=($gender == "man"? checked: "");?> title="Only number.">
                    <label for="sex-man">male</label>
                    <input type="radio" id="sex-woman" name="gender" value="woman" <?=($gender == "woman"? checked: "");?> title="Only number.">
                    <label for="sex-woman">female</label>
                    <span class="error"><?=$errGender;?></span>
                </label>
                <br>
                <label>
                    Birth date:
                    <input type="text" name="day" size="2" placeholder="DD" title="Only number." value="<?=$day;?>">
                    <input type="text" name="month" size="2" placeholder="ММ" title="Only number." value="<?=$month;?>">
                    <input type="text" name="year" id="input-year" size="4" placeholder="YYYY" title="Only number." value="<?=$year;?>">
                    <span class="error"><?=$errDate;?></span>
                </label>
                <br>
                <input type="submit" class="reg-button" name="reg-ok" value="Register">
            </form>
<?php
    }
    else
        echo '<br><p style="font-weight: bold; color: #20207e; text-align: center;>">Registration completed successfully!<p>';
    if(!empty($_POST))
    {
        echo '<div style="margin: 0 0 0 10px;"><br><b>Variable $_POST:</b><br>';
        foreach ($_POST as $index => $value) {
            echo "$index = $value<br>";
        }
        echo "</><br>";
    }
    include "include/footer.php";
?>