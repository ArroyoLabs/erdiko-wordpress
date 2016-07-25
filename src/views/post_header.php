<?php 
// @todo figure out better way to inject a default
if(empty($data->feat_image))
  $data->feat_image = '/themes/clean-blog/img/post-bg.jpg';
?>
<header class="intro-header" style="background-image: url('<?php echo $data->feat_image ?>')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?php echo $data->post_title ?></h1>
                    <?php if($data->post_type == 'post') : ?>
                    <span class="meta">Posted by <a href="<?php echo $data->author->profile_url ?>"><?php echo $data->author->display_name ?></a> on <?php echo date('n/j/Y', strtotime($data->post_date)) ?></span>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>
