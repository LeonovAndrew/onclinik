$(document).on("click",".show_level",function () {
    let lev = $(this).data("lev");
    if($(this).hasClass("active")){
        $(".map-level-1[data-mapl='"+lev+"']").css("display","none");
        $(this).removeClass("active")
    }else{
        $(".map-level-1[data-mapl='"+lev+"']").css("display","block");
        $(this).addClass("active")
    }

})