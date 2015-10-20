<style>

    .col-md-6 {
        padding: 0 100px 0 100px;
    }

    .row {
        padding-bottom: 50px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/sm7bkc1REUI" frameborder="0" allowfullscreen></iframe>
        </div>
        <div class="col-md-6">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortor mauris molestie elit, et lacinia ipsum quam nec dui. Quisque nec mauris sit amet elit iaculis pretium sit amet quis magna. Aenean velit odio, elementum in tempus ut, vehicula eu diam. Pellentesque rhoncus aliquam mattis. Ut vulputate eros sed felis sodales nec vulputate justo hendrerit. Vivamus varius pretium ligula, a aliquam odio euismod sit amet. Quisque laoreet sem sit amet orci ullamcorper at ultricies metus viverra. Pellentesque arcu mauris, malesuada quis ornare accumsan, blandit sed diam.</p>
        </div>
    </div>
    <div>
        <?
        $len = count($courses) - 1;
        for ($i = $len; $i >= 0; $i--) {
            $course = $courses[$i]; ?>
        <h2><?= $course['course_name']?></h2>
            <ul class="list-unstyled video-list-thumbs row">
                <? foreach ($videos as $video) {
                    if ($video['course_id'] == $course['course_id']) {?>
                    <li class="col-lg-3 col-sm-4 col-xs-6">
                        <a href="<?=BASE_URL?>videos/view/<?=$video['video_id']?>" title="<?= $video['description'] ?>">
                            <? if($video['linktype']) {//uploaded video TODO: uploaded video icon ?>
                                <img src="assets/img/thumb.png" alt="<?$video['description']?>" class="img-responsive"
                                     height="130px"/>
                            <? } else {//youtube video ?>
                                <img src="http://i.ytimg.com/vi/<?= $video['link']?>/mqdefault.jpg" alt="<?$video['description']?>" class="img-responsive"
                                     height="130px"/>
                            <? }?>
                            <h4><?= $video['title'] ?></h4>
                        </a>
                    </li>
                <? }
                }?>
            </ul>
        <? }?>
    </div>
</div>