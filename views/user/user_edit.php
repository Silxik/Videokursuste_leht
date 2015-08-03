<style>
    #file-input {
        position: absolute;
        top: -1200px;
    }
</style>

<h1><strong><?= $video['title'] ?></strong></h1>
<div class="col-md-12" align="center">
    <?php if ($video['linktype']) {//uploaded video ?>
        <video width="560" height="315" controls>
            <source src="uploads/<?= $video['link'] ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    <?php } else {//youtube video ?>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video['link'] ?>" frameborder="0"
                allowfullscreen></iframe>
    <?php } ?>
</div>
<div class="col-md-12">
    <form id="form" method="post" enctype="multipart/form-data">
        <table class="table table-bordered">
            <tr>
                <th>Pealkiri</th>
                <td><textarea class="form-control" id="desc" name="data[title]"><?= $video['title'] ?></textarea></td>
            </tr>
            <tr>
                <th>Kirjeldus</th>
                <td><textarea class="form-control" id="desc" name="data[video_desc]" rows="7"><?= $video['video_desc'] ?></textarea>
                </td>
            </tr>
            <tr>
                <th>Avalik</th>
                <td><input type="checkbox" name="data[public]" <?= $video['public'] != 0 ? 'checked="checked"' : '' ?>/>
                </td>
            </tr>
            <tr>
                <th>Märksõnad</th>
                <td>
                    <textarea class="form-control" id="desc" name="tags[tags]" rows="5"><? foreach ($tags as $tag) {
                            $taggin[] = $tag['tag_name'];
                        }
                        echo(implode(', ', $taggin)); ?></textarea>
                </td>
            </tr>
            <tr>
                <th>Kursus</th>
                <td><select name="data[course_id]">
                        <? foreach ($courses as $course): ?>
                            <option
                                value="<?= $course['course_id'] ?>" <? if ($course['course_id'] == $video_course['course_id']) {
                                echo("selected");
                            } ?> > <?= $course['course_name'] ?></option>
                        <? endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Subtiitrid</th>
                <td>
                    <span id="sub-file"><?= ($s = $video['subs']) ? "<a href='uploads/$s'>$s</a>" : 'Puuduvad'?></span>
                    <!-- sets the filesize limit to 40MB -->
                    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="40000000"/>
                    <input type="file" id="file-input" name="upload" accept=".srt"/>
                    <button type="button" class="btn btn-default" onclick="$('#file-input').trigger('click');">
                        Muuda
                    </button>
                </td>
            </tr>
        </table>
    </form>
</div>

<!-- BUTTONS -->
<div class="pull-right">

    <!-- CANCEL -->
    <button class="btn btn-default" onclick="window.location.href='user/view/<?= $video['video_id'] ?>'">
        Tühista
    </button>

    <!-- DELETE -->
    <button class="btn btn-danger" onclick="delete_video(<?= $video['video_id'] ?>)">Kustuta video</button>

    <!-- SAVE -->
    <button class="btn btn-primary" onclick="$('#form').submit()">
        Salvesta
    </button>

</div>
<!-- END BUTTONS -->

<script>

function delete_video(video_id) {
    $.post("user/delete", {video_id: <?=$video['video_id']?>}, function (data) {
        if (data == '1') {
            window.location.href = 'user';
        } else {
            console.log(data);
        }
    });
}
window.onload = function() {
    var fileinput = $('#file-input');
    fileinput.on('change', function (e) {
        //e.preventDefault();
        var file = this.files[0];
        $('#sub-file')[0].innerHTML = file.name;
    });
}
</script>
