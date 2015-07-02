<div class="container">
    <ul class="list-unstyled video-list-thumbs row">
        <? foreach ($videos as $video) : ?>
            <li class="col-lg-3 col-sm-4 col-xs-6">
                <?= $video['title'] ?>
                <a href="#" title="Claudio Bravo, antes su debut con el Barça en la Liga">
                    <img src="http://i.ytimg.com/vi/ZKOtE9DOwGE/mqdefault.jpg" alt="Barca" class="img-responsive"
                         height="130px"/>

                    <h2>Claudio Bravo, antes su debut con el Barça en la Liga</h2>
                    <span class="glyphicon glyphicon-play-circle"></span>
                    <span class="duration">03:15</span>
                </a>
            </li>

        <? endforeach ?>
    </ul>
</div>