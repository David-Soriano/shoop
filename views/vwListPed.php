<div class="container">
    <div class="row">
    <h5 class="title-items-panel">Pedidos Hechos Por Tus Clientes</h5>
        <div class="col-lg-12 card-margin">
            <div class="card search-form">
                <div class="card-body p-0">
                    <form id="search-form">
                        <div class="row">
                            <div class="col-12">
                                <div class="row no-gutters">
                                    <div class="col-lg-8 col-md-6 col-sm-12 p-0">
                                        <input type="text" placeholder="Buscar..." class="form-control" id="search"
                                            name="search" oninput="actualizarTabla4()">
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
                                            <div class="records"><?php echo $recordsMessage2; ?></div>
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
                                                if (isset($dtAllPedidos) && count($dtAllPedidos) > 0) {
                                                    foreach ($dtAllPedidos as $dtp) { ?>
                                                        <tr>
                                                            <td>
                                                                <div class="widget-26-job-starred">
                                                                    <input class="product-checkbox" type="checkbox" name="idped"
                                                                        id="" value="<?= $dtp['idped'] ?>">
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
                                                                            class="employer-name"><?php echo "$" . number_format($dtp['total'], 0, ',', '.') ?></a>
                                                                    </p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="widget-26-job-info">
                                                                    <p class="type m-0">Fecha</p>
                                                                    <p class="text-muted m-0"><span
                                                                            class="location"><?= $dtp['fecha']; ?></span></p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="widget-26-job-salary">
                                                                    <p class="type m-0">Cantidad</p>
                                                                    <?php echo $dtp['cantidad'] ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="widget-26-job-category indicator-wrap bg-soft-success"
                                                                    style="<?php if ($dtp['estped'] == 'Aprobado') {
                                                                        echo "background-color: #91f3657a;";
                                                                    } elseif ($dtp['estped'] == 'Enviado') {
                                                                        echo "background-color: #A6D8FF;";
                                                                    } elseif ($dtp['estped'] == 'En Tránsito') {
                                                                        echo "background-color: #FFC285;";
                                                                    } elseif ($dtp['estped'] == 'En Reparto') {
                                                                        echo "background-color: #FFED95;";
                                                                    } elseif ($dtp['estped'] == 'Recibido') {
                                                                        echo "background-color: #ffcde7;";
                                                                    } elseif ($dtp['estped'] == 'Cancelado'){
                                                                        echo "background-color:rgba(160, 158, 158, 0.69);";
                                                                   }
                                                                    ?>">
                                                                    <i class="indicator" style="<?php if ($dtp['estped'] == 'Aprobado') {
                                                                        echo "background-color: #198754;";
                                                                    } elseif ($dtp['estped'] == 'Enviado') {
                                                                        echo "background-color: #1E90FF;";
                                                                    } elseif ($dtp['estped'] == 'En Tránsito') {
                                                                        echo "background-color: #FF8C00;";
                                                                    } elseif ($dtp['estped'] == 'En Reparto') {
                                                                        echo "background-color: #FFD700;";
                                                                    } elseif ($dtp['estped'] == 'Recibido') {
                                                                        echo "background-color: #cd323b;";
                                                                    } elseif ($dtp['estped'] == 'Cancelado'){
                                                                         echo "background-color: #636363;";
                                                                    }
                                                                    ?>"></i>
                                                                    <span><?= $dtp['estped']; ?></span>
                                                                </div>
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
                                            <button type="button" class="btn me-2" id="editButton2" title="Editar"><i
                                                    class="bi bi-pen-fill"></i></button>
                                            <button class="" id="deleteButton2" title="Cancelar" name="ope" value="cancel"><i
                                                    class="bi bi-x-circle-fill"></i>
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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Sin artículo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" id="formUpdatePed" action="../controller/cped.php">
                    <div class="row bx-st-ped">
                        <div class="col bx-st-ped_st">
                            <div>
                                <i class="bi bi-send"></i>
                                <label for="estped">Enviar</label>
                                <input type="radio" name="estped" id="Enviar" value="Enviado">
                            </div>
                            <div>
                                <i class="bi bi-truck"></i>
                                <label for="estped">En Tránsito</label>
                                <input type="radio" name="estped" id="Transito" value="En Tránsito">
                            </div>
                            <div>
                                <i class="bi bi-person-walking"></i>
                                <label for="estped">En Reparto</label>
                                <input type="radio" name="estped" id="Reparto" value="En Reparto">
                            </div>
                        </div>
                        <p id="msj-ped"></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" name="idped2">
                        <input class="btn" type="submit" value="Actualizar">
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col" id="detalle"></div>
            </div>
        </div>
    </div>
</div>