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
        <div class="col-md-12">
            <h3>Lisa kommentaar</h3>
            <form method="POST">
                <textarea class="form-control" id="comment" name="data[comment]" placeholder="Kirjuta kommentaar" rows="2" ></textarea>
                <select class="dropdown" name="data[person_id]">
                    <? foreach ($persons as $person): ?>
                        <option value="<?=$person['person_id']?>"><?=$person['username']?></option>
                        </li>
                    <? endforeach ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm" name="submit">Postita</button>
            </form>
        </div>
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