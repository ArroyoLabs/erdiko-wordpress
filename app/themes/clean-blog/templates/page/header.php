<!-- Navigation -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/"><?php echo $data['site']['name']; ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                    $menu = $data['menu']['main'];
                    if ($menu) :
                        foreach ($menu as $item) : ?>
                            <?php if(empty($item["submenu"])) : ?>
                            <li>
                                <a href="<?php echo $item["href"]; ?>"><?php echo $item["title"]; ?></a>
                            </li>
                            <?php else : ?>
                            <li class="dropdown">
                                <a href="<?php echo $item["href"]; ?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $item["title"]; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($item["submenu"] as $subitem): ?>
                                        <li><a href="<?php echo $subitem["href"]; ?>"><?php echo $subitem["title"]; ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                            <?php endif ?>
                            
                            <?php
                        endforeach;
                    endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
