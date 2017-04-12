  <?php 
    if (empty($data->title))
      $data->title = "Bookmarks";
    echo $this->getView('default_header', $data);
  ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
              <?php foreach($data->collection as $index => $bookmark): ?>
                <h4><a href="<?= $bookmark->link_url ?>" target="<?= $bookmark->link_target ?>"><?= $bookmark->link_name ?></a></h4>
                <?php endforeach ?>
            </div>
        </div>
    </div>

<!--
            [link_id] => 22
            [link_url] => http://arroyolabs.com/
            [link_name] => Arroyo Labs
            [link_image] => 
            [link_target] => _blank
            [link_category] => 0
            [link_description] => 
            [link_visible] => Y
            [link_owner] => 2
            [link_rating] => 0
            [link_updated] => 1000-01-01 00:00:00
            [link_rel] => 
            [link_notes] => 
            [link_rss] => 
-->