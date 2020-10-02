    new WOW().init();
    var slideshowDuration = 4000;
    var slideshow = $('.main-content .slideshow');
    $(document).ready(function () {

        $('#price-range-submit').hide();

        $("#min_price,#max_price").on('change', function () {

            $('#price-range-submit').show();

            var min_price_range = parseInt($("#min_price").val());

            var max_price_range = parseInt($("#max_price").val());

            if (min_price_range > max_price_range) {
                $('#max_price').val(min_price_range);
            }

            $("#slider-range").slider({
                values: [min_price_range, max_price_range]
            });

        });

        $('.quantity-right-plus').click(function () {
            var index = $('.quantity-right-plus').index(this);
            var quantity = parseInt($('.input-number').eq(index).val());
            $('.input-number').eq(index).val(quantity + 1);
        });
        $('.quantity-left-minus').click(function () {
            var index = $('.quantity-left-minus').index(this);
            var quantity = parseInt($('.input-number').eq(index).val());
            if (quantity > 1) {
                $('.input-number').eq(index).val(quantity - 1);
            }
        });
        $("#min_price,#max_price").on("paste keyup", function () {

            $('#price-range-submit').show();

            var min_price_range = parseInt($("#min_price").val());

            var max_price_range = parseInt($("#max_price").val());

            if (min_price_range == max_price_range) {

                max_price_range = min_price_range + 100;

                $("#min_price").val(min_price_range);
                $("#max_price").val(max_price_range);
            }

            $("#slider-range").slider({
                values: [min_price_range, max_price_range]
            });

        });


        $(function () {
            $("#slider-range").slider({
                range: true,
                orientation: "horizontal",
                min: 0,
                max: 50000,
                values: [0, 50000],
                step: 100,
                slide: function (event, ui) {
                    if (ui.values[0] == ui.values[1]) {
                        return false;
                    }

                    $("#min_price").val(ui.values[0]);
                    $("#max_price").val(ui.values[1]);
                }
            });

            $("#min_price").val($("#slider-range").slider("values", 0));
            $("#max_price").val($("#slider-range").slider("values", 1));

        });

        $("#slider-range,#price-range-submit").click(function () {

            var min_price = $('#min_price').val();
            var max_price = $('#max_price').val();


        });

    });

    function slideshowSwitch(slideshow, index, auto) {
        if (slideshow.data('wait'))
            return;

        var slides = slideshow.find('.slide');
        var pages = slideshow.find('.pagination');
        var activeSlide = slides.filter('.is-active');
        var activeSlideImage = activeSlide.find('.image-container');
        var newSlide = slides.eq(index);
        var newSlideImage = newSlide.find('.image-container');
        var newSlideContent = newSlide.find('.slide-content');
        var newSlideElements = newSlide.find('.caption > *');
        if (newSlide.is(activeSlide))
            return;

        newSlide.addClass('is-new');
        var timeout = slideshow.data('timeout');
        clearTimeout(timeout);
        slideshow.data('wait', true);
        var transition = slideshow.attr('data-transition');
        if (transition == 'fade') {
            newSlide.css({
                display: 'block',
                zIndex: 2
            });
            newSlideImage.css({
                opacity: 0
            });

            TweenMax.to(newSlideImage, 1, {
                alpha: 1,
                onComplete: function () {
                    newSlide.addClass('is-active').removeClass('is-new');
                    activeSlide.removeClass('is-active');
                    newSlide.css({display: '', zIndex: ''});
                    newSlideImage.css({opacity: ''});
                    slideshow.find('.pagination').trigger('check');
                    slideshow.data('wait', false);
                    if (auto) {
                        timeout = setTimeout(function () {
                            slideshowNext(slideshow, false, true);
                        }, slideshowDuration);
                        slideshow.data('timeout', timeout);
                    }
                }});
        } else {
            if (newSlide.index() > activeSlide.index()) {
                var newSlideRight = 0;
                var newSlideLeft = 'auto';
                var newSlideImageRight = -slideshow.width() / 8;
                var newSlideImageLeft = 'auto';
                var newSlideImageToRight = 0;
                var newSlideImageToLeft = 'auto';
                var newSlideContentLeft = 'auto';
                var newSlideContentRight = 0;
                var activeSlideImageLeft = -slideshow.width() / 4;
            } else {
                var newSlideRight = '';
                var newSlideLeft = 0;
                var newSlideImageRight = 'auto';
                var newSlideImageLeft = -slideshow.width() / 8;
                var newSlideImageToRight = '';
                var newSlideImageToLeft = 0;
                var newSlideContentLeft = 0;
                var newSlideContentRight = 'auto';
                var activeSlideImageLeft = slideshow.width() / 4;
            }

            newSlide.css({
                display: 'block',
                width: 0,
                right: newSlideRight,
                left: newSlideLeft
                , zIndex: 2
            });

            newSlideImage.css({
                width: slideshow.width(),
                right: newSlideImageRight,
                left: newSlideImageLeft
            });

            newSlideContent.css({
                width: slideshow.width(),
                left: newSlideContentLeft,
                right: newSlideContentRight
            });

            activeSlideImage.css({
                left: 0
            });

            TweenMax.set(newSlideElements, {y: 20, force3D: true});
            TweenMax.to(activeSlideImage, 1, {
                left: activeSlideImageLeft,
                ease: Power3.easeInOut
            });

            TweenMax.to(newSlide, 1, {
                width: slideshow.width(),
                ease: Power3.easeInOut
            });

            TweenMax.to(newSlideImage, 1, {
                right: newSlideImageToRight,
                left: newSlideImageToLeft,
                ease: Power3.easeInOut
            });

            TweenMax.staggerFromTo(newSlideElements, 0.8, {alpha: 0, y: 60}, {alpha: 1, y: 0, ease: Power3.easeOut, force3D: true, delay: 0.6}, 0.1, function () {
                newSlide.addClass('is-active').removeClass('is-new');
                activeSlide.removeClass('is-active');
                newSlide.css({
                    display: '',
                    width: '',
                    left: '',
                    zIndex: ''
                });

                newSlideImage.css({
                    width: '',
                    right: '',
                    left: ''
                });

                newSlideContent.css({
                    width: '',
                    left: ''
                });

                newSlideElements.css({
                    opacity: '',
                    transform: ''
                });

                activeSlideImage.css({
                    left: ''
                });

                slideshow.find('.pagination').trigger('check');
                slideshow.data('wait', false);
                if (auto) {
                    timeout = setTimeout(function () {
                        slideshowNext(slideshow, false, true);
                    }, slideshowDuration);
                    slideshow.data('timeout', timeout);
                }
            });
        }
    }

    function slideshowNext(slideshow, previous, auto) {
        var slides = slideshow.find('.slide');
        var activeSlide = slides.filter('.is-active');
        var newSlide = null;
        if (previous) {
            newSlide = activeSlide.prev('.slide');
            if (newSlide.length === 0) {
                newSlide = slides.last();
            }
        } else {
            newSlide = activeSlide.next('.slide');
            if (newSlide.length == 0)
                newSlide = slides.filter('.slide').first();
        }

        slideshowSwitch(slideshow, newSlide.index(), auto);
    }

    function homeSlideshowParallax() {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > windowHeight)
            return;
        var inner = slideshow.find('.slideshow-inner');
        var newHeight = windowHeight - (scrollTop / 2);
        var newTop = scrollTop * 0.8;

        inner.css({
            transform: 'translateY(' + newTop + 'px)', height: newHeight
        });
    }

    $(document).ready(function () {
        $('.slide').addClass('is-loaded');

        $('.slideshow .arrows .arrow').on('click', function () {
            slideshowNext($(this).closest('.slideshow'), $(this).hasClass('prev'));
        });

        $('.slideshow .pagination .item').on('click', function () {
            slideshowSwitch($(this).closest('.slideshow'), $(this).index());
        });

        $('.slideshow .pagination').on('check', function () {
            var slideshow = $(this).closest('.slideshow');
            var pages = $(this).find('.item');
            var index = slideshow.find('.slides .is-active').index();
            pages.removeClass('is-active');
            pages.eq(index).addClass('is-active');
        });

        var timeout = setTimeout(function () {
            slideshowNext(slideshow, false, true);
        }, slideshowDuration);

        slideshow.data('timeout', timeout);
    });

    if ($('.main-content .slideshow').length > 1) {
        $(window).on('scroll', homeSlideshowParallax);
    }
// sidbar //
    function openNav() {
        document.getElementById("mySidenav").style.display = "block";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.display = "none";
    }
// Price //
    $(function () {
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 300,
            isRTL: false,
            values: [75, 3000],
            slide: function (event, ui) {
                $("#amount").val("$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ]);
            }
        });
        $("#amount").val("$" + $("#slider-range").slider("values", 0) +
                " - $" + $("#slider-range").slider("values", 1));
    });
// Product details //
    $('.carousel .vertical .carousel-item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i = 1; i < 2; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
        }
    });



    $(document).ready(function () {
        $('.close_gallery_preview').on('click', function () {
            $('.gallery_preview').removeClass('gallery_show');
        });
        $('.show_gallery_preview').on('click', function () {
            var $this = $('.show_gallery_preview').eq($('.show_gallery_preview').index(this));
            $('.gallery_preview img').attr({'src': $this.attr('src')});
            $('.gallery_preview').addClass('gallery_show');
        });
        $('body').on('keyup', function (e) {
            if (e.keyCode == 27) {
                $('.gallery_preview').removeClass('gallery_show');
            }
        });
        $('[data-toggle="tooltip"]').tooltip();


        $('.nav-item.dropdown > .nav-link').on('mouseover', function () {
            var _index = $('.nav-item.dropdown > .nav-link').index(this);
            $('.dropdown-toggle').eq(_index).dropdown('show');
        });
        $('.nav-item.dropdown').on('mouseleave', function () {
            $('.dropdown-toggle').dropdown('hide');
        });

        $('.cart.dropdown').on('mouseover', function () {
            $('#cartdropdown').dropdown('show');
        });
        $('.cart.dropdown').on('mouseleave', function () {
            $('#cartdropdown').dropdown('hide');
        });
    });