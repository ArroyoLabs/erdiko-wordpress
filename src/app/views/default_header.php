<?php 
if(empty($data->feat_image))
  $data->feat_image = '/themes/clean-blog/img/home-bg.jpg';
?>
<header class="intro-header" style="background-image: url('<?php echo $data->feat_image ?>')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?php echo $title = !empty($data->title) ? $data->title : "" ?></h1>
                    <?php if(!empty($data->subtitle)) : ?>
                    <span class="meta"><?php echo $data->subtitle ?></span>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>
