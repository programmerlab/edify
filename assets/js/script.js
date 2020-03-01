$(document).ready(function(){
    $(window).on('scroll', function(){
        if($(window).scrollTop() > 40){
            $("header").addClass('fixed')
        }else{
            $('header').removeClass('fixed')
        }
    });
    $('.passField span').on('click',togglePass);
    $('.signinbtn').on('click', function(e){
        e.preventDefault();
        var target = $(this).attr('href');
        $('#signup').off('show.bs.modal').on('show.bs.modal', function(){
            $('#signup .nav-tabs li:eq('+Number(target =='#signin')+') a').tab('show')
        })
        $('#signup').modal('show');
    })
    $('.flexi .items img').on('click', function(){
        var src = $(this).attr('src');
        $('#lbImg').attr('src', src);
        $('#lightbox').modal('show');
    })
    function togglePass(){
        if($(this).siblings().eq(0).attr('type')=='password'){
            $(this).siblings().eq(0).attr('type', 'text');
            $(this).text('hide')
        }else{
            $(this).siblings().eq(0).attr('type','password');
            $(this).text('show')
        }
    }
})

// modal

// modal