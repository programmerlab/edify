(function ($) {
    $.fn.inView = function (options) {
        var settings = $.extend({
                scOffset: 50,
                toggleViewClass: true,
                viewport: window
            }, options),
            $this = this,
            $viewport = $(settings.viewport).length > 1 ? $(settings.viewport).eq(0) : $(settings.viewport),
            wh = $viewport.height(),
            wt = $viewport.scrollTop(),
            del = 0,
            ivRun = function () {
                var $it = $(this),
                    oTop = $it.position().top;

                if ((+(wt + wh) > (oTop + settings.scOffset)) && (+(oTop + wh) > (wt + settings.scOffset))) {
                    $it.addClass("iv-active");
                    $it.trigger("inView");
                    del++;
                } else {
                    $it.trigger("outView");
                    settings.toggleViewClass && $it.removeClass("iv-active");
                    del = 0;
                }
                $it.trigger('ivScroll', [del]);
            },
            onViewportScroll = function () {
                wt = $viewport.scrollTop();
                $this.each(ivRun);
            };

        $this.each(ivRun);
        $viewport.on('scroll', onViewportScroll);
        return $this;
    };
}(jQuery));

$(document).ready(function () {
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 40) {
            $("header").addClass('fixed')
        } else {
            $('header').removeClass('fixed')
        }
    });
    $('.passField span').on('click', togglePass);
    $('.signinbtn').on('click', function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        $('#signup').off('show.bs.modal').on('show.bs.modal', function () {
            $('#signup .nav-tabs li:eq(' + Number(target == '#signin') + ') a').tab('show')
        })
        $('#signup').modal('show');
    })
    $('.flexi .items img').on('click', function () {
        var src = $(this).attr('src');
        $('#lbImg').attr('src', src);
        $('#lightbox').modal('show');
    })

    function togglePass() {
        if ($(this).siblings().eq(0).attr('type') == 'password') {
            $(this).siblings().eq(0).attr('type', 'text');
            $(this).text('hide')
        } else {
            $(this).siblings().eq(0).attr('type', 'password');
            $(this).text('show')
        }
    }

    $('.section').inView();
    $(".form-upload").change(function () {
        readURL(this);
    });
    $('.preview').on('click', function () {

    })
})

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(input).next().css('background-image', 'url(' + e.target.result + ')');
            console.log($(this).next(), 'ss', e.target.result)
        }
        reader.readAsDataURL(input.files[0]);
    }
}