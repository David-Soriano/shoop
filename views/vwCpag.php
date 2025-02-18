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
                                        name="search" oninput="actualizarTabla2()">
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
                                <div class="row">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Más Opciones
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal2">Nueva Página</a></li>
                                            <li><a class="dropdown-item" href="#">Slider</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php $err = isset($_GET['error']) ? $_GET['error'] : NULL;
                                if ($err == 1) {
                                    echo "<div id='errorMessage' style='color: rgba(225, 75, 47, 1);font-weight: 500;'>No se logró guardar la página</div>";
                                } else if ($err == 2) {
                                    echo "<div id='errorMessage' style='color: rgb(47, 154, 225);font-weight: 500;'>Página guardada exitosamente</div>";
                                } elseif ($err == 3){
                                     echo "<div id='errorMessage' style='color: rgb(225, 75, 47, 1);font-weight: 500;'>Página Eliminada</div>";
                                } ?>
                            </div>
                            <div class="result-body">
                                <div class="table-responsive">
                                    <table class="table widget-26" id="productTable">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Lugar Página</th>
                                                <th>Ícono</th>
                                                <th></th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($dtPags) && count($dtPags) > 0) {
                                                foreach ($dtPags as $dtp) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="widget-26-job-starred">
                                                                <input class="product-checkbox" type="checkbox" name="" id=""
                                                                    value="<?= $dtp['ID Página'] ?>">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-emp-img">
                                                                <p class="text-muted m-0"><span
                                                                        class="location"><?= $dtp['ID Página']; ?></span></p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-title">
                                                                <p><?= $dtp['Nombre Página']; ?></p>
                                                                <a href="#"><?= $dtp['Ruta Página']; ?></a>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-info">
                                                                <p class="text-muted m-0"><span
                                                                        class="location"><?= $dtp['Lugar Página']; ?></span></p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-salary">
                                                                <i class="<?= $dtp['Ícono']; ?>"></i>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if ($dtp['Perfil']) { ?>
                                                                <div class="widget-26-job-category indicator-wrap bg-soft-success"
                                                                    style="<?php if ($dtp['Perfil'] == 'Administrador')
                                                                        echo "background-color: #ffce4aa6;"; ?>">
                                                                    <i class="indicator bg-success"
                                                                        style="<?php if ($dtp['Perfil'] == 'Administrador')
                                                                            echo "background-color: rgb(165, 128, 0)!important; "; ?>"></i>
                                                                    <span><?= $dtp['Perfil']; ?></span>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-info">
                                                                <?php if ($dtp['Ver Pagina'] == 1)
                                                                    echo "<p style='color: #00a650; font-weight: 600;'>Visible</p>";
                                                                else
                                                                    echo "<p style='color:rgb(166, 39, 0); font-weight: 600;'>Deshabilitada</p>" ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="6">No se encontraron páginas.</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="table-options-bar mt-3 d-flex justify-content-end">
                                        <button type="button" class="btn me-2" id="editButton30" title="Editar"><i
                                                class="bi bi-pen-fill"></i></button>
                                        <button class="" id="deleteButton30" title="Eliminar"><i
                                                class="bi bi-trash-fill"></i>
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
                            <a class="page-link no-border"
                                href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage - 1])) ?>"
                                aria-label="Anterior">
                                <span aria-hidden="true">«</span>
                                <span class="sr-only">Anterior</span>
                            </a>
                        </li>

                        <!-- Enlaces de páginas -->
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= ($currentPage === $i) ? 'active' : '' ?>">
                                <a class="page-link no-border"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Botón "Siguiente" -->
                        <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link no-border"
                                href="?<?= http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) ?>"
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
    <!-- <div class="dropdown">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Más Opciones
        </a>

        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalrg"
                    data-bs-whatever="@mdo">Nuevo Administrador</a></li>
            <li><a class="dropdown-item" href="#">Perfiles</a></li>
        </ul>
    </div> -->
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel2">Sin Página</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" id="formUpdatePag"
                    action="../controller/ceditpag.php">
                    <div class="row bx-cont-vsi">
                        <label for="actpag" class="col-form-label">Visibilidad</label>
                        <div class="col">
                            <label for="hab-act">Habilitar</label>
                            <input type="radio" name="actpag" value="1" id="hab-act">
                        </div>
                        <div class="col">
                            <label for="des-act">Deshabilitar</label>
                            <input type="radio" name="actpag" value="0" id="des-act">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="" name="idpag">
                        <input type="hidden" name="ope" value="edit">
                        <button class="btn btn-primary" type="submit">Actualizar</button>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col" id="detalle"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agrega una Nueva Página</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../controller/cpag.php" method="POST">
                    <div class="mb-3">
                        <label for="nompag" class="col-form-label">Nombre de la Página:</label>
                        <input type="text" class="form-control" id="nompag" name="nompag" required>
                    </div>
                    <div class="mb-3">
                        <label for="icopag" class="col-form-label">Ícono (Bootstrap class):</label>
                        <input type="text" class="form-control" id="icopag" name="icopag">
                    </div>
                    <div class="mb-3">
                        <label for="lugpag" class="col-form-label">Lugar donde aparecerá:</label>
                        <select class="form-control" id="lugpag" name="lugpag">
                            <option value="">General</option>
                            <option value="1">Menú Header</option>
                            <option value="2">Panel de Control Proveedor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Perfil que puede acceder:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="idpef" id="cliente" value="1" checked>
                            <label class="form-check-label" for="cliente">Cliente</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="idpef" id="admin" value="2">
                            <label class="form-check-label" for="admin">Administrador</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="ope" value="savePg">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Página</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>