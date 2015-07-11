<div class="container">
    <div class="row">
        <div class="col-md-8">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/sm7bkc1REUI" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="col-md-4">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortor mauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis magna. Aenean velit odio, elementum in tempus ut, vehicula eu diam. Pellentesque rhoncus aliquam mattis. Ut vulputate eros sed felis sodales nec vulputate justo hendrerit. Vivamus varius pretium ligula, a aliquam odio euismod sit amet. Quisque laoreet sem sit amet orci ullamcorper at ultricies metus viverra. Pellentesque arcu mauris, malesuada quis ornare accumsan, blandit sed diam.</p>
        </div>
    </div>
    <div>
        <h2>Kursus 1</h2>
        <ul class="list-unstyled video-list-thumbs row">
            <? foreach ($videos as $video) :
                // Parses URL variables from a Youtube link
                parse_str( parse_url( $video['link'], PHP_URL_QUERY ), $url_vars );
                ?>
                <li class="col-lg-3 col-sm-4 col-xs-6">
                    <a href="<?=BASE_URL?>videos/view/<?=$video['video_id']?> title="<?= $video['description'] ?>">
                        <img src="http://i.ytimg.com/vi/<?= $url_vars['v']?>/mqdefault.jpg" alt="<?$video['description']?>" class="img-responsive"
                             height="130px"/>
                        <h4><?= $video['title'] ?></h4>
                    </a>
                </li>

            <? endforeach ?>
        </ul>
    </div>
</div>