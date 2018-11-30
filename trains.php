<?php
include("database.php");
$db = new database();
if ($_POST['classes_list'] == '0')
    $starts = $db->getRows("select * from trainsandstations where Station='" . $_POST['start_list'] . "' and Train_Number in(select Train_Number from trainsandstations where Station='" . $_POST['end_list'] . "') order by time");
else
    $starts = $db->getRows("select * from trainsandstations where Station='" . $_POST['start_list'] . "' and class_id ='" . $_POST['classes_list'] . "' and Train_Number in(select Train_Number from trainsandstations where Station='" . $_POST['end_list'] . "') order by time");
?>
<!Doctype html>
<head>
    <title>Egypt trains</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body style="overflow-y: visible">
<div id="header">
    قطارات مصر
</div>
<div id="maint">
    <h1>القطارات من <?php echo $_POST['start_list'] ?> الي <?php echo $_POST['end_list'] ?> </h1>
    <table>
        <tr>
            <td class="td_head">رقم القطار</td>
            <td class="td_head">ميعاد القيام</td>
            <td class="td_head">ميعاد الوصول</td>
            <td class="td_head">الدرجه</td>
            <td class="td_head">السرعه</td>
            <td class="td_head">الخط</td>
            <td class="td_head">يمر على</td>
        </tr>
        <?php
        foreach ($starts as $start) {
            $time = $db->getRow("select Time from trainsandstations where train_number = '$start[0]' and station = '" . $_POST['end_list'] . "'")[0];
            $id = $db->getRow("select id from trainsandstations where train_number = '$start[0]' and station = '" . $_POST['end_list'] . "'")[0];
            if (($id > $start[6])) {
                echo "<tr>
            <td>$start[0]</td>
            <td>" . $start['Time'] . "</td>
            ";

                if ($time <= $start[2])
                    echo "<td>" . $db->getRow("select Time from trainsandstations where train_number = '$start[0]' and station = '" . $_POST['end_list'] . "'")[0] . " اليوم التالي</td>";
                else
                    echo "<td>" . $db->getRow("select Time from trainsandstations where train_number = '$start[0]' and station = '" . $_POST['end_list'] . "'")[0] . "</td>";
                $betweens = $db->getRows("select station from trainsandstations where id > $start[6] and id < $id and train_number = '$start[0]' group by station order by id");
                echo "
                    <td>" . $db->getRow("select type from class where id = '$start[3]'")[0] . "</td>
                    <td>" . $db->getRow("select km from speed where id = '$start[5]'")[0] . "</td>
                    <td>" . $db->getRow("select name from line where id = '$start[4]'")[0] . "</td>
            
            <td><select style='width: 70px;height: 30px;font-size: 18px;margin-bottom: 4px;margin-top:0;background-color: #e8403e;'>";
             foreach ($betweens as $between){
                 echo"<option>$between[0]</option>";
             }
            echo "</select>
            </td>
            </tr>";
            }
        }
        ?>
    </table>
</div>