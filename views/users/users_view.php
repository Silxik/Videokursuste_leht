<h1>User '<?= $person['username'] ?>'</h1>
<table class="table table-bordered">
    <tr>
        <th>Username</th>
        <td><?= $person['username'] ?></td>
    </tr>
    <? if ($auth->is_admin): ?>
        <tr>
            <th>Password</th>
            <td><?= $person['password'] ?></td>
        </tr>
    <? endif; ?>
    <tr>
        <th>Active</th>
        <td><input type="checkbox" name="data[active]" <?= $person['active'] != 0 ? 'checked="checked"' : '' ?>
                   disabled="disabled"/></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= $person['email'] ?></td>
    </tr>
</table>

<!-- EDIT BUTTON -->
<? if ($auth->is_admin): ?>
    <form action="users/edit/<?= $person['person_id'] ?>">
        <div class="pull-right">
            <button class="btn btn-primary">
                Edit
            </button>
        </div>
    </form>
<? endif; ?>