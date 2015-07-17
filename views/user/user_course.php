<h1><strong><?= $course['course_name'] ?></strong></h1>
<form id="form" method="post">
    <input type="hidden" name="data[course_id]" value="<?=$course['course_id']?>">
    <table class="table table-bordered">
        <tr>
            <th>Pealkiri</th>
            <td><textarea class="form-control" name="data[course_name]"><?=$course['course_name']?></textarea></td>
        </tr>
        <tr>
            <th>Kirjeldus</th>
            <td><textarea class="form-control" name="data[course_desc]" rows="7"><?=$course['course_desc']?></textarea></td>
        </tr>
    </table>
</form>
<!-- BUTTONS -->
<div class="pull-right">

    <!-- CANCEL -->
    <button class="btn btn-default" onclick="window.location.href='user'">
        Tühista
    </button>

    <!-- DELETE -->
    <button class="btn btn-danger" onclick="delete_course()">
        Kustuta
    </button>

    <!-- SAVE -->
    <button class="btn btn-primary" onclick="$('#form').submit()">
        Salvesta
    </button>

</div>
<!-- END BUTTONS -->

<script>
function delete_course() {
    if (confirm("Oled kindel et soovid kursust kustutada?")) {
        $.post("user/course", {id: <?=$course['course_id']?>}, function (r) {
            console.log(r);
            //window.location.href = 'user';
        });
    }
}
</script>
