<?php $class = ($data["count"] == 0) ? "active" : "" ?>
<div class="item <?php echo $class ?>">
  <img src="<?php echo $data["url"] ?>" alt="">
  <div class="carousel-caption">
    <?php echo $data["caption"] ?>
  </div>
</div>
