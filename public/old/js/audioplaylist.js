/**
 * Created by direction on 8/6/2015.
 */
$(document).ready(function(){
    $("#audioplaylist li").on("click", function() {
        $("#audioplayarea").attr({
            "src": $(this).attr("url"),
            "autoplay": "autoplay"
        })
    })
    $("#audioplayarea").attr({
        "src": $("#audioplaylist li").eq(0).attr("url")
    })
    $('audio').on('ended',function(){
        var nextURL = "";
        $( "li" ).each(function() {
            if($(this).attr("url") ==
                $("#audioplayarea").attr("src")){
                nextURL = $(this).next().attr("url");
            }
        })
        $("#audioplayarea").attr({
            "src":nextURL,
            "autoplay": "autoplay"
        })
    });
});