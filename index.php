<?php
// for terminal use
// $num = strip_tags(readline("input the contact's number ...")); 
// for web use
if (($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['sub']))) {
    $errs = [];
    $num = strip_tags($_POST['num']);
    if (((isset($num)) && ((strlen($num) !== 11))) || ((isset($num))) && (empty($num))) {
        $errs[] = "invalid number \n<br> make sure \n<br> 1. your number starts with '0' \n<br> 2. your number is 11 digits long \n<br> 3. your number is a number 🙄 \n<br> 4. number can't be left empty \n<br>" . strlen($num) . "\n<br>";
    }
    // for web use
    $name = strip_tags($_POST['name']);
    if (isset($name) && empty($name)) {
        $errs[] = "name can't be left empty";
    }
    // for terminal use
// $name = readline("input the contact's name ...");
    $file = fopen("contacts.vcf", "a+");
    while (!feof($file)) {
        $line = (explode(",", fgets($file)));
        if ($line[0] == $num) {
            $errs[] = 'contact already saved';
        }
        if ($line[1] == $name) {
            $errs[] = 'contact already saved';
        }
    }
    if (empty($errs)) {
        $message = "\n" . $num . "," . strtoupper($name);
        // echo " saving \n";
        echo '<div class="pros"> saving<br> </div>';
        fwrite($file, $message);
        echo '<div class="pros"> success<br> </div>';

        // echo " success \n";
    } else {
        foreach ($errs as $cellary) {

            echo '<div class="errs">' . $cellary . '</div>';
        }
    }
    fclose($file);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dist/style.css">
    <title>contacts</title>
</head>

<body>
    <div class="side">
        <i class="fa-brands fa-github"></i>
        <div class="line"></div>
    </div>
    <div class="form">
        <h3 >fill the form to save contact to the file</h3>
        <form action="" method="post">
            <input type="text" name="name" placeholder="name" value="<?php $name?>"><br>
            <input type="tel" name="num" placeholder="number" value="<?php $num?>"><br>
            <button type="submit" name="sub">SUBMIT</button>
        </form>
    </div>
    <div class="nums">
        <h3>saved contacts (click to call)</h3>
        <ol>
            <?php
            $file = fopen("contacts.vcf", "r");
            while (!feof($file)) {
                $line = fgetcsv($file);
                echo '<li><a href="tel:' . $line[0] . '">' . $line[1] . '</li></a>';
            }
            fclose($file);
            ?>
        </ol>
    </div>
</body>

</html>