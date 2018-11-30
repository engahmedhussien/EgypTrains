<?php
include("database.php");
session_start();
$db = new database();
$classes = $db->getRows("select type from class ORDER by id");
$stations = $db->getRows("select station from trainsandstations GROUP BY station ORDER BY station")
?>
<!Doctype html>
<head>
    <title>Egypt trains</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<div id="header">
قطارات مصر
</div>
<div id="main">
<form id="form" action="trains.php" method="POST">
    <div title="تبديل" id="swap" onclick="swap()">↓↑</div>
    <select id="start_list" name="start_list">
        <option value="0">اختر محطة القيام</option>
        <?php
        foreach ($stations as $station){
            echo "<option value=\"$station[0]\">$station[0]</option>";
            $i++;
        }
        ?>
    </select>
    <br>
    <select id="end_list" name="end_list">
        <option value="0">اختر محطة الوصول</option>
        <?php
        foreach ($stations as $station){
            echo "<option value=\"$station[0]\">$station[0]</option>";
            $i++;
        }
        ?>
    </select>
    <br>
    <select name="classes_list">
        <option value = '0'>كل الدرجات</option>
        <?php
        $i=1;
        foreach ($classes as $class){
            echo "<option value='$i'>$class[0]</option>";
            $i++;
        }
        ?>
    </select>
    <br>
    <div id="submit" onclick="submit()">

        مواعيد القطارات
    </div>
</form>
</div>
<script>
    function submit() {
        var s = document.getElementById("start_list");
        var e = document.getElementById("end_list");
        if(s.value=="0")
            alert("الرجاء اختيار محطة القيام");
        else if(e.value=="0")
            alert("الرجاء اختيار محطة الوصول");
        else if(s.value==e.value)
            alert("الرجاء اختيار محطتين مختلفتين");
        else {
            var form = document.getElementById("form");
            form.submit();
        }
    }
    function swap() {
        var s = document.getElementById("start_list");
        var e = document.getElementById("end_list");
        var temp;
        if(s.value != "0" && e.value != "0"){
            temp = s.value;
            s.value = e. value;
            e.value = temp;
        }
    }
</script>
</body>