  <?php 
    $data->title = $data->user->display_name;
    echo $this->getView('default_header', $data);
  ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
              <div class="well well-lg">
                <div class="media">
                  <div class="media-left">
                    <img class="media-object" src="<?php echo $data->gravitar ?>" alt="<?php echo $data->user->display_name ?>">
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading"><?php echo $data->meta['first_name'][0] ?> <?php echo $data->meta['last_name'][0] ?></h4>
                    <p><?php echo $data->meta['description'][0] ?>
                      <br /><a href="<?php echo $data->user->user_url ?>" target="_blank"><?php echo $data->user->user_url ?></a></p>
                  </div>
                </div>
              </div>
              <?php // echo "<pre>Data: ".print_r($data, true)."</pre>"; ?>
            </div>
        </div>
    </div>
