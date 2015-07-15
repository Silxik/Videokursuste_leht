
<div class="list-group">
<?foreach($tags as $tag):?>
        <a href="tags/view/<?=$tag['tag_id']?>"><?=$tag['tag_name']?></a>
<?endforeach ?>
    </div>