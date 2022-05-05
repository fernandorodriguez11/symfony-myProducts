$(function(){

    $("#menu").click(function(){
        $(".menu").css('display', "block");
        $("#menu").css('display', "none");
        $("#close").css('display', "inline");
    });

    $("#close").click(function(){
        $(".menu").css('display', "none");
        $("#menu").css('display', "inline");
        $("#close").css('display', "none");
    });
})