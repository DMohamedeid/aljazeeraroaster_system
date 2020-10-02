<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="index.php" class="logo">Aljazeera Roastery </a>
        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                <div class="pull-left">
                    <button class="button-menu-mobile open-left">
                        <i class="ion-navicon"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>

                <!-- Refresh Notification For (Orders Count) -->
                <ul class="nav navbar-nav navbar-right pull-right">
                    <div id="ordersViewed"></div>
                    <li class="dropdown top-menu-item-xs">
                        <?php
                        $count = 0;
                        $query = $con->query("SELECT * FROM `orders` where  `order_status`=0 and `order_follow`=0");
                        $count_orders = mysqli_num_rows($query);
                        $count+=$count_orders;
                        $query_1 = $con->query("SELECT * FROM `sub_category_comments` where  `viewed`=0");
                        $count_comments = mysqli_num_rows($query_1);
                        $count+=$count_comments;
                        $query_2 = $con->query("SELECT * FROM `messages` where  `type`=1 and `is_read`=0");
                        $count_messages = mysqli_num_rows($query_2);
                        $count+=$count_messages;
                        ?>
                        <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                            <i class="icon-bell"></i>

                        <?php
                        if($count>0){

                        ?>
                        <div class="media">
                            <div class="badge badge-xs badge-danger"><?php echo $count; ?>
                            </div>
                        </div>
                        <?php }?>

                        </a>

                        <ul class="dropdown-menu dropdown-menu-lg">
                            <li class="notifi-title">

                                <span class="label label-default pull-right">New <?php echo $count; ?></span>Notifications
                            </li>
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 230px;">
                                <li class="list-group slimscroll-noti notification-list" style="overflow: hidden; width: auto; height: 230px;">
                                    <!-- list item-->
                                    <?php
                                    $query = $con->query("SELECT * FROM `orders` where  `order_status`=0 and `order_follow`=0");
                                    $count_orders = mysqli_num_rows($query);
                                    if ($count_orders > 0) {
                                        ?>
                                        <a href="order_view.php" class="list-group-item">
                                            <div class="pull-left p-r-10">
                                                <em class="fa fa-bell-o noti-custom">
                                                <div class="label label-default pull-right">   <?php echo $count_orders; ?></div>
                                                </em>
                                            </div>
                                            <div class="media">
                                                <div class="media-body">
                                                    <h1 class="media-heading"> There are new orders   </h1>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                    <?php
                                    $query_1 = $con->query("SELECT * FROM `sub_category_comments` where  `viewed`=0");
                                    $count_comments = mysqli_num_rows($query_1);
                                    if ($count_comments > 0) {
                                        while ($row_1 = mysqli_fetch_assoc($query_1)) {
                                            $comment_id = $row_1['comment_id'];
                                            $sub_category_id = $row_1['sub_category_id'];
                                            ?>
                                            <a href="subcat_comments_view.php?sub_category_id=<?php echo $sub_category_id; ?>" class="list-group-item">
                                                <div class="pull-left p-r-10">
                                                    <em class="fa fa-bell-o noti-custom"></em>
                                                </div>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h1 class="media-heading"> There is a new comment   </h1>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    $query_2 = $con->query("SELECT * FROM `messages` where  `type`=1 and `is_read`=0");
                                    $count_messages = mysqli_num_rows($query_2);
                                    if ($count_messages > 0) {
                                        while ($row_2 = mysqli_fetch_assoc($query_2)) {
                                            $complaint_id = $row_2['complaint_id'];
                                            ?>
                                            <a href="complaints_details.php?complaintId=<?php echo $complaint_id; ?>" class="list-group-item">
                                                <div class="pull-left p-r-10">
                                                    <em class="fa fa-bell-o noti-custom"></em>
                                                </div>
                                                <div class="media">
                                                    <div class="media-body">
                                                        <h1 class="media-heading"> There are new messages</h1>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </li>
                            </div>

                        </ul>
                        <?php
                        $query = $con->query("SELECT * FROM `users` WHERE `user_id`='" . $_SESSION['user_id'] . "' ORDER BY `user_id` DESC");
                        $x = 1;

                        $row = mysqli_fetch_assoc($query);

                        $user_name = $row['user_name'];
                        $user_image = $row['user_image'];
                        $get_image_ext = explode('.', $user_image);
                        $image_ext = strtolower(end($get_image_ext));
                        $user_id = $row['user_id'];
                        ?>

                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light">
                            <i class="icon-size-fullscreen"></i>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="../uploads/users/<?php echo $user_id . "." . $image_ext; ?>" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu">
                            <li><a href="user_edit.php?userID=<?php echo $_SESSION["user_id"]; ?>"><i class="ti-user m-r-5"></i> Personal Profile </a></li>
                            <li><a href="logout.php"><i class="ti-power-off m-r-5"></i> Sign Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

