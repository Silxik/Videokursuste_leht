<h1><strong><?=$tag?></strong> videod</h1>
<ul class="list-unstyled video-list-thumbs row">
    <? foreach($videos as $video) {?>
        <li class="col-lg-3 col-sm-4 col-xs-6">
            <a href="<?=BASE_URL?>videos/view/<?=$video['video_id']?>" title="<?= $video['description'] ?>">
                <? if($video['linktype']) {//uploaded video ?>
                    <img src="assets/img/thumb.png" alt="<?$video['description']?>" class="img-responsive"
                         height="130px"/>
                <? } else { ?>

                <img src="http://i.ytimg.com/vi/<?= $video['link']?>/mqdefault.jpg" alt="<?$video['description']?>" class="img-responsive"
                                          height="130px"/>
                <? }?>
                <h4><?= $video['title'] ?></h4>
            </a>
        </li>
    <? }?>
</ul>