<h1>Users</h1>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Picture</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
            <th>Is banned</th>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->vars->users as $user) { ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2">
                    Edit
                    
                    Ban/Unban
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
