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
<form id="form" method="post">
    <table class="table table-bordered">
        <tr>
            <th>Pealkiri</th>
            <td><textarea class="form-control" id="desc" name="data[desc]"><?=$video['title']?></textarea></td>
        </tr>
        <tr>
            <th>Kirjeldus</th>
            <td><textarea class="form-control" id="desc" name="data[desc]" rows="7"><?=$video['desc']?></textarea></td>
        </tr>
        <tr>
            <th>Avalik</th>
            <td><input type="checkbox" name="data[public]" <?= $video['public'] != 0 ? 'checked="checked"' : '' ?>/></td>
        </tr>
        <tr>
            <th>Märksõnad</th>
            <td>
                <textarea class="form-control" id="desc" name="data[desc]" rows="5"><?foreach($tags as $tag) {
                        $taggin[]=$tag['tag_name'];
                    }
                    echo(implode(', ', $taggin));?></textarea>
            </td>
        </tr>
        <tr>
            <th>Kursus</th>
            <td><select name="data[course_id]">
                    <option value="0"></option>
                    <?foreach($courses as $course):?>
                        <option value="<?=$course['course_id']?>" <?if($course['course_id']==$video_course['course_id']){echo("selected");}?> > <?=$course['course_name']?></option>
                    <? endforeach?>
                </select>
            </td>
        </tr>
    </table>
</form>
    <!-- BUTTONS -->
    <div class="pull-right">

        <!-- CANCEL -->
        <button class="btn btn-default" onclick="window.location.href='user/view/<?=$video['video_id']?>'">
            Tühista
        </button>

        <!-- DELETE -->
        <button class="btn btn-danger" onclick="delete_video(<?= $video['person_id'] ?>)">
            Kustuta
        </button>

        <!-- SAVE -->
        <button class="btn btn-primary" onclick="$('#form').submit()">
            Salvesta
        </button>

    </div>
    <!-- END BUTTONS -->

    <script>
        function delete_video(user_id) {
            $.post("user/delete", {video_id: <?=$video['video_id']?>}, function (data) {
                if (data == '1') {
                    window.location.href = 'user';
                } else {
                    alert('Fail');
                }
            });
        }
    </script>
