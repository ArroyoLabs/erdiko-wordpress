<?php
function getExcerpt($str, $startPos=0, $maxLength=150) {
    if(strlen($str) > $maxLength) {
        $excerpt   = substr($str, $startPos, $maxLength-3);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt   = substr($excerpt, 0, $lastSpace);
        $excerpt  .= '...';
    } else {
        $excerpt = $str;
    }
    return $excerpt;
}

foreach($data as $key=>$array) {
    $url = get_permalink($array->ID);
    $newurl = str_replace( home_url(), "", $url );

    echo '<div id="listTitle">';
    echo '<ul><li><a href=page'.$newurl.'>' . $array->post_title . '</a></li></ul>';
    echo '</div>';
    //   echo $array->post_content;
    echo '<div id="listExcerpt">';
    $my_excerpt = getExcerpt($array->post_content);
    echo $my_excerpt;
    echo '</div>';
}
?>