<?php 
// @todo figure out better way to inject a default
if(empty($data->feat_image))
  $data->feat_image = '/themes/clean-blog/img/home-bg.jpg';

// Get author info @todo move to the model
$author = \get_user_by( 'ID', $data->post_author ); // get_user_by('slug', $id)
?>
<header class="intro-header" style="background-image: url('<?php echo $data->feat_image ?>')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <div class="post-heading">
                    <h1><?php echo $data->post_title ?></h1>
                    <?php if($data->post_type == 'post') : ?>
                    <span class="meta">Posted by <a href="/author/<?php echo $author->user_nicename ?>"><?php echo $author->display_name ?></a> on <?php echo date('n/j/Y', strtotime($data->post_date)) ?></span>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</header>
