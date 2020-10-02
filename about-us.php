<?php
include("include/header.php");

include("include/nav-bar.php");
?>
<!-- start bread -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php"><?= lang('home') ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= lang('about_us') ?></li>
        </ol>
    </nav>
</div>

<!--start About us-->
<div class="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12 candy wow backInLeft" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                <img src="<?= $image; ?>" class="w-100" alt="about"/>
            </div>
            <div class="col-md-6 col-12 teact">
                <div class="decs">
                    <p> <?= $content; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include ('include/footer.php'); ?>