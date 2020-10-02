<?php

// View Sub Category Table
function view_payments() {

    global $con;

    $query = $con->query("SELECT * FROM `payment` ORDER BY `id` DESC");

    $x = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $id = $row['id'];
        $order_id = $row['order_id'];
        $payment_id = $row['payment_id'];
        $result = $row['result'];
        $value = $row['value'];
        $date = $row['date'];
        $client_id = $row['client_id'];
        $client_name = clientName($client_id);
        ?>
        <tr class="gradeX">
            <td><?php echo $x; ?></td>
            <td><?php echo $client_name; ?></td>
            <td><?php echo $order_id; ?></td>
            <td><?php echo $payment_id; ?></td>
            <td><?php echo $value; ?></td>
            <td><?php echo $result; ?></td>

            <td><?php echo $date; ?></td>
                <!--            <td class="actions">
                        <a href="<?php echo $complaint_id; ?>" class="on-default remove-row" id="deleteParent"><i class="fa fa-trash-o"></i></a>

                    </td>-->
        </tr>		
        <?php
        $x++;
    }

    return mysqli_insert_id($con);
}
?>