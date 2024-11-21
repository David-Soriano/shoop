<div class="container">
    <div class="row">
        <div class="col-lg-12 card-margin">
            <div class="card search-form">
                <div class="card-body p-0">
                    <form id="search-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-lg-8 col-md-6 col-sm-12 p-0">
                                        <input type="text" placeholder="Buscar..." class="form-control" id="search"
                                            name="search" oninput="actualizarTabla()">
                                    </div>
                                    <div class="col-lg-1 col-md-3 col-sm-12 p-0">
                                        <div class="btn btn-base">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-search">
                                                <circle cx="11" cy="11" r="8"></circle>
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-margin">
                <div class="card-body">
                    <div class="row search-body">
                        <div class="col-lg-12">
                            <div class="search-result">
                                <div class="result-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="records"><?php echo $recordsMessage; ?></div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="result-actions">
                                                <div class="result-sorting">
                                                    <span>Ordenar Por:</span>
                                                    <select class="form-control border-0" id="exampleOption">
                                                        <option value="1">Fecha</option>
                                                        <option value="2">Nombre (A-Z)</option>
                                                        <option value="3">Nombre (Z-A)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="result-body">
                                    <div class="table-responsive">
                                        <table class="table widget-26" id="productTable">
                                            <tbody>
                                                <?php
                                                if (isset($dtAllPrd) && count($dtAllPrd) > 0) {
                                                    foreach ($dtAllPrd as $dtp) { ?>
                                                        <tr>
                                                            <td>
                                                                <div class="widget-26-job-starred">
                                                                    <input class="product-checkbox" type="checkbox" name="" id=""
                                                                        value="<?= $dtp['idpro'] ?>">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="widget-26-job-emp-img">
                                                                    <img src="../<?= $dtp['imgpro']; ?>"
                                                                        alt="<?= $dtp['nomimg']; ?>">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="widget-26-job-title">
                                                                    <a href="#"><?= $dtp['nompro']; ?></a>
                                                                    <p class="m-0"><a href="#"
                                                                            class="employer-name"><?= $dtp['nomval']; ?></a>
                                                                        <span
                                                                            class="text-muted time"><?= $dtp['productvend']; ?>
                                                                            vendidos</span>
                                                                    </p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="widget-26-job-info">
                                                                    <p class="type m-0">Stock</p>
                                                                    <p class="text-muted m-0"><span
                                                                            class="location"><?= $dtp['cantidad']; ?></span></p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="widget-26-job-salary">
                                                                    <p class="type m-0">Precio</p>
                                                                    <?php echo "$" . number_format($dtp['precio'], 0, ',', '.') ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php if ($dtp['pordescu'] > 0) { ?>
                                                                    <div
                                                                        class="widget-26-job-category indicator-wrap bg-soft-success">
                                                                        <i class="indicator bg-success"></i>
                                                                        <span>En oferta</span>
                                                                    </div>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                } else { ?>
                                                    <tr>
                                                        <td colspan="6">No se encontraron productos.</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <div class="table-options-bar mt-3 d-flex justify-content-end">
                                            <button class=" me-2" id="editButton" title="Editar" disabled><i class="bi bi-pen-fill"></i></button>
                                            <button class="" id="deleteButton" title="Eliminar" disabled><i class="bi bi-trash-fill"></i>
                                                </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav class="d-flex justify-content-center">
                        <ul class="pagination pagination-base pagination-boxed pagination-square mb-0">
                            <!-- Botón "Anterior" -->
                            <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link no-border" href="?page=<?= $currentPage - 1 ?>"
                                    aria-label="Anterior">
                                    <span aria-hidden="true">«</span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                            </li>

                            <!-- Enlaces de páginas -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($currentPage === $i) ? 'active' : '' ?>">
                                    <a class="page-link no-border" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Botón "Siguiente" -->
                            <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link no-border" href="?page=<?= $currentPage + 1 ?>"
                                    aria-label="Siguiente">
                                    <span aria-hidden="true">»</span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</div>

