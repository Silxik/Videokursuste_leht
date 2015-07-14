<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php if($video['linktype']) {//uploaded video ?>
                <video width="560" height="315">
                    <source src="uploads/<?= $video['link'] ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            <?php } else {//youtube video ?>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video['link']?>" frameborder="0" allowfullscreen></iframe>
            <?php } ?>
        </div>
        <div class="col-md-4">
            <h2><?= $video['title']?></h2>
            <p><?= $video['description']?></p>
            <?foreach($tags as $tag):?>
                <a href="tags/view/<?=$tag['tag_id']?>"><span class="label label-info"><?=$tag['tag_name']?></span></a>
            <?endforeach?>
            <p>Posted by: <strong><?=$video['username']?></strong></p>
        </div>
        <?php if ($auth->active): ?>
            <div class="col-md-12">
                <h3>Lisa kommentaar</h3>
                <form method="POST">
                    <textarea class="form-control" id="comment" name="data[comment]" placeholder="Kirjuta kommentaar" rows="2" ></textarea>
                    <button type="submit" class="btn btn-primary btn-sm" name="submit">Postita</button>
                </form>
            </div>
        <?php endif; ?>
        <div class="col-md-12">
            <ul class="list-group">
                <h3>Kommentaarid</h3>
                <? foreach ($comments as $comment): ?>
                    <li class="list-group-item">
                        <p><?= $comment['comment']?></p>
                        <p>Posted by <strong><?= $comment['username']?></strong> on <?= $comment['date_added']?></p>
                    </li>
                <? endforeach ?>
            </ul>
        </div>
    </div>
</div>