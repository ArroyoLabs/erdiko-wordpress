<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php echo $data->getMetaMarkup(); // Spit out meta tags ?>

    <title><?php echo $data->getPageTitle() ?></title>

    <?php
    /** Spit out CSS **/
    foreach ($data->getCss() as $css) {
        if ($css['active']) {
            echo "<link rel='stylesheet' href='".$css['file']."' type='text/css' />\n";
        }
    }
    ?>
</head>
<body>

    <?php echo $data->getTemplateHtml('header'); ?>
    <div class="content-main">
        <?php echo $this->getContent(); ?>
    </div>
    <hr>
    <?php echo $data->getTemplateHtml('footer'); ?>

    <?php
        // Spit out JS below the footer
    foreach ($this->getJs() as $js) {
        if ($js['active']) {
            echo "<script src='".$js['file']."'></script>\n";
        }
    }
    ?>
    <script type="text/javascript">/* <![CDATA[ */
    $(document).ready(function() {

    });
    /* ]]> */</script>

    <?php echo $data->getTemplateHtml('analytics') ?>

</body>
</html>
