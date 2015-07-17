<h1><strong><?= $video['title'] ?></strong></h1>
<div class="col-md-12" align="center">
    <?php if($video['linktype']) {//uploaded video ?>
        <video width="560" height="315" controls>
            <source src="uploads/<?= $video['link'] ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <?php } else {//youtube video ?>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video['link']?>" frameborder="0" allowfullscreen></iframe>
    <?php } ?>
</div>
<table class="table table-bordered">
    <tr>
        <th>Pealkiri</th>
        <td><?= $video['title'] ?></td>
    </tr>
    <tr>
        <th>Kirjeldus</th>
        <td><?= $video['desc'] ?></td>
    </tr>
    <tr>
        <th>Avalik</th>
        <td><input type="checkbox" name="data[public]" <?= $video['public'] != 0 ? 'checked="checked"' : '' ?>
                   disabled="disabled"/></td>
    </tr>
    <tr>
        <th>Märksõnad</th>
        <td>
            <?foreach($tags as $tag) {
                $taggin[]=$tag['tag_name'];
            }
            echo(implode(', ', $taggin));?>
        </td>
    </tr>
    <tr>
        <th>Kursus</th>
        <td><?= $course['course_name']?></td>
    </tr>
</table>

<!-- EDIT BUTTON -->
<? if ($auth->is_admin): ?>
    <form action="user/edit/<?= $video['video_id'] ?>">
        <div class="pull-right">
            <button class="btn btn-primary">
                Edit
            </button>
        </div>
    </form>
<? endif; ?>