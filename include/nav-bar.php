<!-- srart navv=bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container-md">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php"><?= lang('home') ?> <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="sections.php" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= lang("sections") ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="row">
                            <div class="col-6">
                                <?php
                                    $parent_categories = $con->query("SELECT * FROM parent_categories limit 6");
                                    while ($row = mysqli_fetch_array($parent_categories)) {
                                        $get_parent_category_id = $row['parent_category_id'];
                                        $parent_category_name = (lang('lang_key') == 'en' ? $row['parent_category_name'] : $row['parent_category_name_ar']);
                                        $count_sub_categories_by_category_id = count_sub_categories_by_category_id($get_parent_category_id);
                                        ?>
                                        <a class="dropdown-item text-<?= lang('align') ?>" href="products.php?parent_category_id=<?= $get_parent_category_id ?>"><?= $parent_category_name; ?></a>
                                    <?php } ?>
                                <a class="dropdown-item text-<?= lang('align') ?>" href="sections.php"><?= lang('all') ?></a>

                            </div>
                            <div class="col-6">

                                <?php
                                    $parent_categories = $con->query("SELECT * FROM parent_categories limit 6,20 ");
                                    while ($row = mysqli_fetch_array($parent_categories)) {
                                        $get_parent_category_id = $row['parent_category_id'];
                                        $parent_category_name = (lang('lang_key') == 'en' ? $row['parent_category_name'] : $row['parent_category_name_ar']);
                                        $count_sub_categories_by_category_id = count_sub_categories_by_category_id($get_parent_category_id);
                                        ?>
                                        <a class="dropdown-item text-<?= lang('align') ?>" href="products.php?parent_category_id=<?= $get_parent_category_id ?>"><?= $parent_category_name; ?></a>
                                    <?php } ?>


                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about-us.php"><?= lang('about_us'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact-us.php"><?= lang('contact_us'); ?></a>
                </li>
                <?php
                    if (empty($_COOKIE['client_id'])) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php"><?= lang('login'); ?></a>
                        </li>
                    <?php } ?>
                <?php
                    if (!empty($_COOKIE['client_id'])) {
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $_COOKIE['client_name'] ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-<?= lang('align') ?>" href="my-profile.php"><?= lang('my_profile'); ?></a>
                                <a class="dropdown-item text-<?= lang('align') ?>" href="my-favorite.php"><?= lang('my_favorite'); ?></a>
                                <a class="dropdown-item text-<?= lang('align') ?>" href="my-current-orders.php"><?= lang('my_orders'); ?></a>
                                <a class="dropdown-item text-<?= lang('align') ?>" href="my-address.php"><?= lang('my_addresses'); ?></a>
                                <a class="dropdown-item text-<?= lang('align') ?>" href="logout.php"><?= lang('logout'); ?></a>
                            </div>
                        </li>
                    <?php } ?>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownlang" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= lang('language') ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownlang">
                        <a class="dropdown-item text-<?= lang('align') ?>" href="?change_lang=ar">العربية</a>
                        <a class="dropdown-item text-<?= lang('align') ?>" href="?change_lang=en">Einglish</a>
                    </div>
                </li>
                <li class="nav-item">
                    <?php
                        $count = 0;
                        $client_id = (empty($_COOKIE['client_id']) ? '0' : $_COOKIE['client_id']);
                        $result = $con->query("SELECT * FROM `cart` WHERE `client_id`='$client_id' AND `status`=0") or die(mysqli_error());
                        $count = mysqli_num_rows($result);
                    ?>
                    <a class="nav-link " href="my-cart.php"><i class="fas fa-shopping-cart"></i><span class="cart-count"><?php echo $count; ?></span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>