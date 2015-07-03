<div class="container">
    <ul class="list-unstyled video-list-thumbs row">
        <? foreach ($videos as $video) :
            // Parses URL variables from a Youtube link
            parse_str( parse_url( $video['link'], PHP_URL_QUERY ), $url_vars );
            ?>
            <li class="col-lg-3 col-sm-4 col-xs-6">
                <a href="<?= $video['link'] ?>" title="<?= $video['title'] ?>">
                    <img src="http://i.ytimg.com/vi/<?= $url_vars['v']?>/mqdefault.jpg" alt="Barca" class="img-responsive"
                         height="130px"/>
                    <h2><?= $video['title'] ?></h2>
                </a>
            </li>

        <? endforeach ?>
    </ul>
</div>