<? if (!$auth->is_admin): ?>
    <div class="alert alert-danger fade in">
        <button class="close" data-dismiss="alert">×</button>
        You are not an administrator.
    </div>
    <? exit(); endif; ?>
<h1>User '<?= $person['username'] ?>'</h1>
<form id="form" method="post">
    <table class="table table-bordered">
        <tr>
            <th>Username</th>
            <td><input type="text" name="data[username]" value="<?= $person['username'] ?>"/></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input type="text" name="data[password]" value="<?= $person['password'] ?>"/></td>
        </tr>
        <tr>
            <th>Active</th>
            <td><input type="checkbox" name="data[active]" <?= $person['active'] != 0 ? 'checked="checked"' : '' ?>/></td>
        </tr>
        <tr>
            <th>Admin</th>
            <td><input type="checkbox" name="data[is_admin]" <?= $person['is_admin'] != 0 ? 'checked="checked"' : '' ?>/></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><input type="text" name="data[email]" value="<?= $person['email'] ?>"></td>
        </tr>
    </table>
</form>

<!-- BUTTONS -->
<div class="pull-right">

    <!-- CANCEL -->
    <button class="btn btn-default"
            onclick="window.location.href = 'users/view/<?= $person['person_id'] ?>/<?= $person['username'] ?>'">
        Cancel
    </button>

    <!-- DELETE -->
    <button class="btn btn-danger" onclick="delete_user(<?= $person['person_id'] ?>)">
        Delete
    </button>

    <!-- SAVE -->
    <button class="btn btn-primary" onclick="$('#form').submit()">
        Save
    </button>

</div>
<!-- END BUTTONS -->

<script>
    function delete_user(user_id) {
        $.post("users/delete", {person_id: <?=$person['person_id']?>}, function (data) {
            if (data == '1') {
                window.location.href = 'users';
            } else {
                alert('Fail');
            }
        });
    }
</script>