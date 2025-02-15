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
                                        name="search" oninput="actualizarTabla3()">
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
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Estado</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($dtUsu) && count($dtUsu) > 0) {
                                                foreach ($dtUsu as $dtu) { ?>
                                                    <tr>
                                                        <td>
                                                            <div class="widget-26-job-starred">
                                                                <input class="product-checkbox" type="checkbox" name="" id=""
                                                                    value="<?= $dtu['idusu'] ?>">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-emp-img">
                                                                <p class="text-muted m-0"><span
                                                                        class="location"><?= $dtu['idusu']; ?></span></p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-title">
                                                                <p><?= $dtu['nomusu']; ?>         <?= $dtu['apeusu']; ?> -
                                                                    <?= $dtu['genusu']; ?>
                                                                </p>
                                                                <p class="text-muted m-0"><span
                                                                        class="location"><?= $dtu['tipdoc']; ?> -
                                                                        <?= $dtu['docusu']; ?></span></p>

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-info">
                                                                <p class="text-muted m-0"><span
                                                                        class="location"><?= $dtu['emausu']; ?></span></p>
                                                                <p><?= $dtu['celusu']; ?></p>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="widget-26-job-category indicator-wrap bg-soft-success"
                                                                style="<?php if ($dtu['estusu'] == 'Inactivo')
                                                                    echo "background-color: #ff96967a;"; ?>">
                                                                <i class="indicator bg-success"
                                                                    style="<?php if ($dtu['estusu'] == 'Inactivo')
                                                                        echo "background-color: rgb(224, 67, 46)!important; "; ?>"></i>
                                                                <span><?= $dtu['estusu']; ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php if ($dtu['nompef']) { ?>
                                                                <div class="widget-26-job-category indicator-wrap bg-soft-success"
                                                                    style="<?php if ($dtu['nompef'] == 'Administrador')
                                                                        echo "background-color: #ffce4aa6;"; ?>">
                                                                    <i class="indicator bg-success"
                                                                        style="<?php if ($dtu['nompef'] == 'Administrador')
                                                                            echo "background-color: rgb(165, 128, 0)!important; "; ?>"></i>
                                                                    <span><?= $dtu['nompef']; ?></span>
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
                                        <button type="button" class="btn me-2" id="editButton" title="Editar"><i
                                                class="bi bi-pen-fill"></i></button>
                                        <button class="" id="deleteButton" title="Eliminar"><i
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
                        <?php for ($i = 1; $i <= $totalUsers; $i++): ?>
                            <li class="page-item <?= ($currentPage === $i) ? 'active' : '' ?>">
                                <a class="page-link no-border"
                                    href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Botón "Siguiente" -->
                        <li class="page-item <?= ($currentPage >= $totalUsers) ? 'disabled' : '' ?>">
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
    <div class="dropdown">
        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Más Opciones
        </a>

        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalrg"
                    data-bs-whatever="@mdo">Nuevo Administrador</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalperf"
                    data-bs-whatever="@mdo">Perfiles</a></li>
        </ul>
    </div>
</div>

<div class="modal fade" id="exampleModalrg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <?php include "../controller/cubi.php"; ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar Administrador</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="../controller/cusu.php" id="form-rg-adm">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="nomusu" class="col-form-label">Nombre</label>
                                <input type="text" class="form-control" name="nomusu" id="nomusu" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="apeusu" class="col-form-label">Apellido</label>
                                <input type="text" class="form-control" name="apeusu" id="apeusu" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="tipdoc" class="col-form-label">Tipo Documento</label>
                                <select class="form-control" id="tipdoc" name="tipdoc" required>
                                    <option value="">Seleccione</option>
                                    <option value="CC">C.C</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="docusu" class="col-form-label">No. Documento</label>
                                <input type="number" class="form-control" name="docusu" id="docusu" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="emausu" class="col-form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" name="emausu" id="emausu" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="celusu" class="col-form-label">Teléfono</label>
                                <input type="number" class="form-control" name="celusu" id="celusu" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Sexo</label>
                                <div class="row">
                                    <div class="col bx_rgadm-rad-sex">
                                        <label for="genmas">M</label>
                                        <input type="radio" name="genusu" id="genmas" value="M" required>
                                    </div>
                                    <div class="col bx_rgadm-rad-sex">
                                        <label for="genfem">F</label>
                                        <input type="radio" name="genusu" id="genfem" value="F" required>
                                    </div>
                                    <div class="col bx_rgadm-rad-sex">
                                        <label for="genoth">Otro</label>
                                        <input type="radio" name="genusu" id="genoth" value="O" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="depart" class="col-form-label">Departamento</label>
                                <select name="depart" id="depart" class="form-control" required>
                                    <option value="">Seleccione</option>
                                    <?php if ($dtDtp) {
                                        foreach ($dtDtp as $dtD) { ?>
                                            <option value="<?= $dtD['idubi']; ?>"><?= $dtD['nomubi']; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="ciudad" class="col-form-label">Ciudad</label>
                                <select name="ciudad" id="ciudad" class="form-control" required>
                                    <option value="">Seleccione un departamento</option>
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="dirrecusu" class="col-form-label">Dirección</label>
                                <input type="text" name="dirrecusu" id="dirrecusu" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="pasusu" class="col-form-label">Contraseña</label>
                                <input type="password" class="form-control" name="pasusu" id="pasusu"
                                    placeholder="Mínimo 6 caracteres" required>
                                <p><i class="bi bi-question-circle-fill"></i> El usuario es su correo electrónico.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="idpef" value="2">
                        <input type="hidden" name="ope" value="save">
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalperf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Control de Permisos - Perfiles</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    title="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <h5 for="recipient-name" class="col-form-label">Cliente - Proveedor</h5>
                            </div>
                            <div class="bx-pagi-client">
                                <div class="mb-3">
                                    <input type="checkbox" name="" id="">
                                    <label for="">Página</label>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <h5 for="message-text" class="col-form-label">Administrador</h5>
                            </div>
                            <div class="bx-pagi-admin">
                                <div class="mb-3">
                                    <input type="checkbox" name="" id="">
                                    <label for="">Página</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="guardarPermisos">Guardar</button>
                    </div>
                </form>
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
                <form enctype="multipart/form-data" method="POST" id="formUpdatePrd" action="../controller/cpancon.php">
                    <div class="row">
                        <div class="col">
                            <input type="text" name="nompro" placeholder="Nombre del artículo" required>
                        </div>
                        <div class="col">
                            <textarea name="descripcion" placeholder="Añade una descripción" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="number" name="cantidad" placeholder="Cantidad disponible" required>
                        </div>
                        <div class="col">
                            <select name="idval" required>
                                <option value="">Categoría</option>
                                <?php if (!empty($dtCatego)) {
                                    foreach ($dtCatego as $dtcat) { ?>
                                        <option value="<?= $dtcat['idval'] ?>"><?= $dtcat['categoria'] ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row bx-subprd_valor">
                        <div class="col">
                            <i class="bi bi-question-circle-fill"
                                title="Valor unitario: Es el precio por unidad antes de aplicar descuentos o recargos."></i>
                            <input type="number" id="valorunitario" name="valorunitario" placeholder="Valor Unitario"
                                required>
                        </div>
                        <div class="col">
                            <i class="bi bi-question-circle-fill"
                                title="Precio: Es el costo final que paga el cliente, incluyendo descuentos o recargos."></i>
                            <input type="number" id="precio" name="precio" placeholder="Precio del producto" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h6>¿Algún descuento en especial?</h6>
                        </div>
                        <div class="col">
                            <input type="number" id="pordescu" name="pordescu" oninput="mostrarFechaFin()"
                                placeholder="Valor. Ej: 5%">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="fechaInicio">Fecha de inicio de la oferta:</label>
                            <input type="date" id="fechaInicio" name="fechiniofer">
                        </div>
                    </div>
                    <div class="row" id="fechaOferta">
                        <div class="col">
                            <label for="fechaFin">Fecha fin de la oferta:</label>
                            <input type="date" id="fechaFin" name="fechfinofer">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <Label>Características del producto</Label>
                            <i class="bi bi-question-circle-fill" title="Cantidad de característica a registrar"></i>
                            <input type="number" name="" id="cantcr" placeholder="Cantidad" oninput="cantCr()">
                        </div>
                        <div class="col" id="descar">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="imgpro">Selecciona imágenes:</label>
                            <input type="file" name="imgpro[]" id="imgpro" multiple accept=".jpg, .jpeg, .png, .webp"
                                onchange="actualizarOrden()">
                        </div>
                    </div>
                    <div class="row" id="orden-imagenes">
                        <!-- Aquí se mostrarán las imágenes con su orden -->
                    </div>
                    <div class="row" id="image_exist">

                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="idpro">
                            <input type="hidden" name="ope" value="edit">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input class="btn" type="submit" onclick="actualizarOrdenImagenes()" value="Actualizar">
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col" id="detalle"></div>
            </div>
        </div>
    </div>
</div>