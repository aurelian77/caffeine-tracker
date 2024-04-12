<?php
declare(strict_types=1);
namespace nicotine;
use nicotine\Form;
$form = new Form();
?>
<h1>Edit User</h1>

<?php print $form->open()->method('post')->action(href('admin/users/update/'.$this->vars->user['id']))->autocomplete('off'); ?>
<?php print $form->csrf(); ?>

<table class="table">
    <tbody>
        <tr>
            <td>Username</td>
            <td><input type="text" /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type="email" /></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" /></td>
        </tr>
        <tr>
            <td>Confirm password</td>
            <td><input type="password" /></td>
        </tr>
        <tr>
            <td>Role</td>
            <td>
                <select><option value="2">Contributor</option></select>
            </td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" /></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" /></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" /></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" /></td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" /></td>
        </tr>

    </tbody>
</table>