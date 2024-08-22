<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <link type="text/css" rel="stylesheet" href="<?= PUBLIC_URL ?>/assets/bootstrap/dist/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?= PUBLIC_URL ?>/assets/bootstrap-icons/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container mt-3">
        <?php if (isset($message)) : ?>
            <div class="alert <?= $message['type'] ?>" role="alert">
                <?= $message['text'] ?>
            </div>
        <?php endif ?>
        <h3 class="card-header d-flex justify-content-between align-items-center">
            <a class="link-dark link-underline link-underline-opacity-0 link-underline-opacity-50-hover" href="<?= PUBLIC_URL ?>">Książka adresowa</a>
            <div>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="bi-search"></i>
                </button>
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi-plus"></i>
                </button>
            </div>
        </h3>
        <hr />
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Imię i nazwisko</th>
                    <th scope="col">Telefon</th>
                    <th scope="col">Adres e-mail</th>
                    <th scope="col">Adres zamieszkania</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <th scope="row"><?= $lp++ ?></th>
                        <td><?= $row['firstname'] ?> <?= $row['lastname'] ?></td>
                        <td><?= $row['mobile'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['address'] ?></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row['id'] ?>">
                                <i class="bi-pen"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $row['id'] ?>">
                                <i class="bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <?php if ($pages > 1) : ?>
                <div class="hint-text"><b><?= $page ?></b> z <b><?= $pages ?></b> stron</div>
            <?php endif ?>
            <?php if ($pages > 0) : ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($page > 1) : ?>
                            <li class="page-item prev"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $page - 1 ?>">Poprzednia</a></li>
                        <?php endif ?>
                        <?php if ($page > 3) : ?>
                            <li class="page-item"><a class="page-link" href="<?= PUBLIC_URL ?>?page=1">1</a></li>
                            <li class="page-item">...</li>
                        <?php endif ?>
                        <?php if ($page - 2 > 0) : ?><li class="page-item page"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $page - 2 ?>"><?= $page - 2 ?></a></li><?php endif ?>
                        <?php if ($page - 1 > 0) : ?><li class="page-item page"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $page - 1 ?>"><?= $page - 1 ?></a></li><?php endif ?>
                        <li class="page-item active"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $page ?>"><?= $page ?></a></li>
                        <?php if ($page + 1 < $pages + 1) : ?><li class="page-item page"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $page + 1 ?>"><?= $page + 1 ?></a></li><?php endif ?>
                        <?php if ($page + 2 < $pages + 1) : ?><li class="page-item page"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $page + 2 ?>"><?= $page + 2 ?></a></li><?php endif ?>
                        <?php if ($page < $pages - 2) : ?>
                            <li class="page-item">...</li>
                            <li class="page-item"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $pages ?>"><?= $pages ?></a></li>
                        <?php endif ?>
                        <?php if ($page < $pages) : ?>
                            <li class="page-item next"><a class="page-link" href="<?= PUBLIC_URL ?>?page=<?= $page + 1 ?>">Następna</a></li>
                        <?php endif ?>
                    </ul>
                </nav>
            <?php endif ?>
        </div>
    </div>
    <?php
    // Attach modals
    include VIEWS_DIR . '/modals/add.php';
    include VIEWS_DIR . '/modals/edit.php';
    include VIEWS_DIR . '/modals/delete.php';
    include VIEWS_DIR . '/modals/search.php';
    ?>
    <script type="text/javascript" src="<?= PUBLIC_URL ?>/assets/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="<?= PUBLIC_URL ?>/assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= PUBLIC_URL ?>/assets/app.js"></script>
</body>

</html>