<?php
include("include/header.php");
include("include/nav-bar.php");
?>
<!--start breadcrumb-->
<div class="bread">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php"><?= lang('home') ?></a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= lang('sections') ?></li>
            </ol>
        </nav>
    </div>
</div>

<!--start card-2-->
<div class="card-b text-center">
    <div class="container">
        <!--start-one-->
        <div class="row">
            <?php
            $parent_categories = $con->query("SELECT * FROM parent_categories");
            while ($row = mysqli_fetch_array($parent_categories)) {
                $get_parent_category_id = $row['parent_category_id'];
                $parent_category_name = (lang('lang_key') == 'en' ? $row['parent_category_name'] : $row['parent_category_name_ar']);
                $parent_category_desc = (lang('lang_key') == 'en' ? $row['parent_category_desc'] : $row['parent_category_desc_ar']);
                $count_sub_categories_by_category_id = count_sub_categories_by_category_id($get_parent_category_id);
                ?>


                <div class="col-md-6 col-6 wow fadeInUpBig" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                    <div class="card">
                        <a href="products.php?parent_category_id=<?= $get_parent_category_id ?>"><img src="<?= GetDefaultImage($row["parent_category_image"], $payment_url . "assets/img/sections-img/coffeeOPP.jpeg"); ?>" class="card-img-top" alt="coffee"></a>
                        <div class="card-body">
                            <p class="card-text"><?= $parent_category_name ?></p>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>

    </div>
</div>


<?php include("include/footer.php"); ?>
