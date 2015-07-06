<? parse_str( parse_url( $video['link'], PHP_URL_QUERY ), $url_vars );?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $url_vars['v']?>" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="col-md-4">
            <h2><?= $video['title']?></h2>
            <p><?= $video['description']?></p>
            <p>Posted by: <strong><?=$video['username']?></strong></p>
        </div>
    </div>
</div>