<?= Form::open(array('method' => 'post')) ?>
<h1 class="heading-01"><?= __("New Category") ?></h1>
<?= Form::csrf() ?>

<?php $errors = $fieldset->validation()->error(); ?>
<div class="panel">
    <table class="table-row">
        <tr>
            <th><?= $fieldset->field('title')->label ?><span class="required">※</span></th>
            <td>
                <?= Form::input('title', $fieldset->field('title')->value, array('required')); ?>
                <?php if (isset($errors['title'])) : ?>
                    <span><?= $errors['title']->get_message() ?></span>
                <?php endif ?>
            </td>
        </tr>
        <tr>
            <th><?= $fieldset->field('search_text')->label ?><span class="required">※</span></th>
            <td><?= Form::input('search_text', $fieldset->field('search_text')->value, array('required')); ?>
                <?php if (isset($errors['search_text'])) : ?>
                    <span><?= $errors['search_text']->get_message() ?></span>
                <?php endif ?>
            </td>
        </tr>
    </table>
</div>
<div class="form-footer">
    <ul class="btns horizontal">
        <li><button type="submit" class="btn btn-primary">Save</button></li>
    </ul>
</div>
<?= Form::close() ?>