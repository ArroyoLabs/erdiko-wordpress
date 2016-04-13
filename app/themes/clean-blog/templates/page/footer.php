<!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <ul class="list-inline text-center">
                        <?php
                        $menu = $data['menu']['footer'];
                        if ($menu) :
                            foreach ($menu as $item) : ?>
                                <li>
                                    <a href="<?php echo  $item["href"]; ?>">
                                        <?php echo  $item["title"]; ?>
                                        <!-- <span class="fa-stack fa-lg">
                                            <i class="fa fa-circle fa-stack-2x"></i>
                                            <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                        </span> -->
                                    </a>
                                </li>
                                <?php
                            endforeach;
                        endif; ?>
                    </ul>
                    <p class="copyright text-muted">Copyright &copy; <?php echo date('Y', time());?> All rights reserved 
                        <?php echo $data['site']['full_name']; ?></p>
                    <p class="copyright text-muted">Powered by <a href="http://erdiko.org">Erdiko</a></p>
                </div>
            </div>
        </div>
    </footer>
