<div id="detailTitle" style="font-size: 1.5em;">
    <?php echo $data[0]->post_title;?>
</div>
<div id="detailContent">
    <?php
    if(isset($data[0]->post_content))
        $data[0]->post_content = apply_filters('the_content', $data[0]->post_content);
    echo $data[0]->post_content;
    ?>
</div>
<div id="detailDate">
    <?php echo $data[0]->post_date;?>
</div>