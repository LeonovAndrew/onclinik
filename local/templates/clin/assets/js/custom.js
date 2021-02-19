$(document).on("keyup","#servicesSearch",function () {
    if($(this).val()==""){
        $(".clean_search").css("display","none");
    }else{
        $(".clean_search").css("display","block");
    }
})
$(document).on("focus","#servicesSearch",function () {
    if($(this).val()==""){
        $(".clean_search").css("display","none");
    }else{
        $(".clean_search").css("display","block");
    }
})
$(document).on("click",".clean_search",function () {
    $("#servicesSearch").val("");
    $(".costsection-search-wrap.search__inner button[type='submit']").click();
    $(".clean_search").css("display","none");
})