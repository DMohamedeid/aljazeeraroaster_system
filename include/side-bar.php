<aside class="wow bounceInDown" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offest="300">
    <form action="<?php echo $site_url; ?>products.php<?php
        if ($_GET["items"]) {
            echo "?items=" . $_GET["items"];
        } elseif ($_GET["page"]) {
            echo "&page=" . $_GET["page"];
        }
    ?>" method="POST" id="search_form">
        <div class="first-side">
            <h4><?= lang('search_by_name') ?></h4>
            <div class="input-group mb-2" style=" direction: ltr !important; ">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="fas fa-search"></i></div>
                </div>
                <input type="text" name="product_name" id="inlineFormInputGroup" value="<?php
                    if ($_GET['product_name']) {
                        echo $_GET['product_name'];
                    } elseif ($_POST['product_name']) {
                        echo $_POST['product_name'];
                    }
                ?>" class="form-control" placeholder="<?= lang('search_by_name') ?>">
            </div>
        </div>

        <div class="price-range-block">
            <h6 class="font-weight-bolder"><?= lang('price_range') ?></h6>
            <div id="slider-range" class="my-3 price-filter-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" name="rangeInput">
                <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
            </div>

            <div>
                <div class="price_range p-2"></div>
                <input name="price_from" type="hidden" step='0.1'value="<?php
                    if ($_GET['price_from']) {
                        echo $_GET['price_from'];
                    } elseif ($_POST['price_from']) {
                        echo $_POST['price_from'];
                    }
                ?>" max="9900" oninput="validity.valid||(value='0');" id="min_price" class="price-range-field">
                <input name="price_to" type="hidden" value="<?php
                    if ($_GET['price_to']) {
                        echo $_GET['price_to'];
                    } elseif ($_POST['price_to']) {
                        echo $_POST['price_to'];
                    } else {
                        echo 1000;
                    }
                ?>" max="10000" oninput="validity.valid||(value='10000');" id="max_price" class="price-range-field">
            </div>
        </div>
        <button type="submit" class="btn-lg d-block">Filter</button>
    </form>
</aside>

<script type="text/javascript">
        $(function () {
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 500,
                values: [75, 300],
                slide: function (event, ui) {
                    $('[name="price_from"]').val(ui.values[ 0 ]);
                    $('[name="price_to"]').val(ui.values[ 1 ]);
                    $('.price_range').text(ui.values[1] + ' : ' + ui.values[0]);
                }
            });
            $('[name="price_from"]').val("$" + $("#slider-range").slider("values", 0));
            $('[name="price_to"]').val("$" + $("#slider-range").slider("values", 1));
            $('.price_range').text($("#slider-range").slider("values", 1) + ' : ' + $("#slider-range").slider("values", 0));

        });
</script>