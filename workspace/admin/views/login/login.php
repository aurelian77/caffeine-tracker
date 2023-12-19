<?php
declare(strict_types=1);
namespace nicotine;
use nicotine\Form;
$form = new Form();
?>
<fieldset>
    <legend>Login</legend>

    <?php print $form->open()->method('post')->action(href('admin/login/check')); ?>
        <?php print $form->csrf(); ?>
        <p>
            <?php print $form->input()->type('email')->name('email')->value(transient('email'))->required(true)->placeholder('Email'); ?>
        </p>
        <p>
            <?php print $form->input()->type('password')->name('password')->value(transient('password'))->minlength(6)->placeholder('Password'); ?>
        </p>
        <p>
            <?php print $form->input()->type('submit')->name('login')->value('Login')->class('float-left'); ?>
            <?php print $form->input()->type('submit')->name('forgot')->value('I forgot my password')->class('float-right'); ?>
        </p>
    <?php print $form->close(); ?>
</fieldset>
