<div style="padding: 20px;">
    <ul class="btns horizontal">
        <li><a href="<?= Controller_Categories::url_new() ?>" class="btn btn-primary">Add Category</a></li>
    </ul>
</div>
<?php if ($models): ?>
<?= Pagination::instance('pagination')->render(); ?>
    <table class="table-rowcol table-inner">
        <thead>
            <tr>
                <th><a href=""><?= \Model_Categories::property('category_id')['label'] ?></a></th>
                <th><a href=""><?= \Model_Categories::property('title')['label'] ?></a></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($models as $category): ?>
                <tr>
                    <td><?= Html::anchor(Controller_Categories::url_view($category->category_id), $category->category_id) ?></td>
                    <td><?= Html::anchor(Controller_Categories::url_view($category->category_id), $category->title) ?></td>
                    <td>
                        <a href="<?= Controller_Categories::url_edit($category->category_id) ?>" class="btn-ico btn-ico-addmember">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= Pagination::instance('pagination')->render(); ?>
<?php else: ?>
    <p>No category </p>
<?php endif; ?>