/**
 * Created by direction on 8/6/2015.
 */
$(document).ready(function(){
    $("#videoplaylist li").on("click", function() {
        $("#videoplayarea").attr({
            "src": $(this).attr("url"),
            "autoplay": "autoplay"
        })
    })
    $("#videoplayarea").attr({
        "src": $("#videoplaylist li").eq(0).attr("url")
    })
    $('video').on('ended',function(){
        var nextURL = "";
        $( "li" ).each(function() {
            if($(this).attr("url") ==
                $("#videoplayarea").attr("src")){
                nextURL = $(this).next().attr("url");
            }
        })
        $("#videoplayarea").attr({
            "src":nextURL,
            "autoplay": "autoplay"
        })
    });
});
