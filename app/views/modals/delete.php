<?php $primaryColumn = Models\Address::$primaryColumn ?>
<div id="deleteModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= PUBLIC_URL ?>">
                <div class="modal-header">
                    <h4 class="modal-title">Usuń adres: <span id="deleteId"></span></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <p>Na pewno chcesz usunąć ten adres?</p>
                    <p class="text-warning"><small>Ta akcja będzie nieodwracalna.</small></p>
                </div>
                <input type="hidden" id="<?= $primaryColumn ?>" name="<?= $primaryColumn ?>">
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Anuluj">
                    <input type="submit" class="btn btn-danger" value="Usuń">
                </div>
                <input type="hidden" name="model" value="Address">
                <input type="hidden" name="action" value="delete">
            </form>
        </div>
    </div>
</div>