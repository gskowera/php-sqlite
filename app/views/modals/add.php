<?php $dataColumns = Models\Address::getDataColumns() ?>
<?php $rules = Models\Address::$rules ?>
<div id="addModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= PUBLIC_URL ?>">
                <div class="modal-header">
                    <h4 class="modal-title">Dodaj nowy adres</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($dataColumns as $column => $name) : ?>
                        <div class="form-group">
                            <label for="<?= $column ?>"><?= $name ?></label>
                            <input
                                type="text"
                                id="<?= $column ?>"
                                name="<?= $column ?>"
                                class="form-control"
                                <?= isset($rules[$column]) && in_array('require', $rules[$column]) ? 'required' : '' ?>
                            >
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Anuluj">
                    <input type="submit" class="btn btn-success" value="Zapisz">
                </div>
                <input type="hidden" name="model" value="Address">
                <input type="hidden" name="action" value="add">
            </form>
        </div>
    </div>
</div>