<?php
    include("include/header.php");
    include("include/nav-bar.php");
?>
<!-- Start Contact Area -->
<div id="map" class="map row mb-4" style="height: 500px; width: 100%;">
</div>

<!-- start breadcrumb -->
<div class="container" style="display:none;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="Aljazeera.html"><?= lang('home') ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= lang('contact_us') ?></li>
        </ol>
    </nav>
</div>

<div class="contact" style="display:none;">
    <div class="lay-map">
        <div class="container">



            <div class="leave text-center" style="display:none;">
                <div class="row">
                    <div class="col-md-6 col-12 wow fadeInRight" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                        <div class="mess">
                            <div class="title-info">
                                <h3><?= lang('contact_info') ?></h3>
                                <div class="phone-info">
                                    <span><i class="fas fa-mobile mr-3"></i><?= $phone; ?></span>
                                </div>
                                <div class="send-info">
                                    <span><i class="fas fa-envelope mr-3"></i><?= $email; ?></span>
                                </div>
                                <div class="site-info">
                                    <span><i class="fas fa-map-marked-alt mr-3"></i><?= $address; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
                        <div class="message mt-5">
                            <form class="" required="" action="#" method="post" id="contact-site-form">
                                <div class="form-row">
                                    <div class="col">
                                        <input required="" minlength="2" maxlength="100" id="edit-name" name="name" value="" type="text" class="form-control" placeholder="<?= lang('name') ?>">
                                    </div>
                                    <div class="col">
                                        <input required="" id="edit-mail" name="email" value="" type="email" class="form-control" placeholder="<?= lang('email') ?>">
                                    </div>
                                    <div class="col">
                                        <input required=""  minlength="2" maxlength="100" id="title" name="title" value="" type="text" type="title" class="form-control" placeholder="<?= lang('title') ?>">
                                    </div>
                                    <input required="" type="text" required="" name="subject" value="" minlength="2" maxlength="300" class="form-control mt-4" placeholder="<?= lang('subject') ?>">
                                </div>
                                <button   type="button"  id="contact-site-submit" class="btn-lg d-block mt-4"><?= ucwords(lang('send')) ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
        var map;

        function initMap() {
            map = new google.maps.Map(
                    document.getElementById('map'),
                    {center: new google.maps.LatLng(26.2342353, 50.5284394), zoom: 12.5});

            var features = [
                {
                    position: new google.maps.LatLng(26.2462638, 50.5669433),
                    label: 'فرع عراد',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2487346, 50.5752816),
                    label: 'فرع المحرق',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2086306, 50.5192847),
                    label: 'فرع مدينة عيسى',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2342353, 50.5284394),
                    label: 'فرع مُجمع البحرين',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.1887022, 50.4998247),
                    label: 'فرع الرفاع',
                    type: 'info'
                }, {
                    position: new google.maps.LatLng(26.2462638, 50.5669433),
                    label: 'فرع قلالي',
                    type: 'info'
                }
            ];

            // Create markers.
            for (var i = 0; i < features.length; i++) {
                var marker = new google.maps.Marker({
                    position: features[i].position,
                    title: features[i].label,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    icon: 'http://aljazeeraroastery.com/assets/img/marker.png',
                    map: map
                });
            }
        }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjmF9nneXiMC3LujPbx-sA12RujVhESAw&callback=initMap"></script>

<?php include ('include/footer.php'); ?>

<script>
        $("#subscribe").on('click', function () {
            var ths_form = $('#subscribe-form');
            var action = site_url + 'functions/ajax.php';
            var email = $("#email_subscribe").val();
            var dataString = 'email_subscribe=' + email;
            if (ths_form.valid()) {
                $.ajax({
                    type: "POST",
                    url: action,
                    data: dataString,
                    dataType: 'json',
                    cache: false,
                    success: function (data) {
                        if (data.success == 1)
                        {
                            $.toast({
                                heading: data.message,
                                text: data.message,
                                showHideTransition: 'slide',
                                icon: 'success'
                            });
                            $("#email_subscribe").val("");
                        } else if (data.success == 0)
                        {
                            $.toast({
                                heading: data.message,
                                text: data.message,
                                showHideTransition: 'slide',
                                icon: 'error'
                            });
                        }

                    }

                });
            }

        });
</script>

<script type="text/javascript">
        $(document).ready(function () {
            $(".carousel").carousel({
                interval: 8000,
                pause: false
            });
        });
</script>


<script src="js/contact.js" type="text/javascript"></script>
