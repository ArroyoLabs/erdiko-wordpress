<?php echo $this->getView('default_header', $data) ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php 
                foreach($data->collection as $key => $array) {
                    $url = get_permalink($array->ID);
                    $newUrl = str_replace( home_url(), "", $url ); // strip domain (since it's headless)
                    ?>
                <div class="post-list-item">
                    <h3><a href="<?php echo $newUrl ?>"><?php echo $array->post_title ?></a></h3>
                    <p class="post-teaser">
                        <?php echo $this->getBodyExcerpt($array->post_content) ?>
                    </p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
