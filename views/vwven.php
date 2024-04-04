    <h1 class="txtven">
        <div class="es1"><i class="fa-solid fa-truck-field"></i></div>
        Mis productos de venta
    </h1>
    <i class="fa-solid fa-circle-plus fa-2x btnadd" id="btnadd"></i>
    <div id="formven">
        <form name="frm1" action="#" method="POST">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Producto</label>
                    <input type="text" class="form-control form-control" required>
                </div>
                <div class="form-group col-md-8">
                    <label>Descripción</label>
                    <textarea class="form-control form-control"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label>Existencias</label>
                    <input type="number" class="form-control form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Precio</label>
                    <input type="number" class="form-control form-control" required>
                </div>
                <div class="mb-3">
                    <label for="formFileMultiple" class="form-label">Sube las imagenes del producto</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple>
                </div>
                <div class="form-group col-md-4">
                    <br>
                    <input type="submit" class="btn btn-primary" id="venpro" value="Enviar">
                </div>
            </div>
        </form>
    </div>
    <div class="myline"></div>
    <div class="container">
        <table id="tpro" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Existencias</th>
                    <th>Precio</th>
                    <th>Visitas</th>
                    <td>Configuración</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Silla</td>
                    <td>Comoda silla</td>
                    <td>95</td>
                    <td>$320,800</td>
                    <td>61</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Mesa</td>
                    <td>Mesa negra</td>
                    <td>102</td>
                    <td>$170,750</td>
                    <td>63</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Audifonos</td>
                    <td>Audifonos inalámpricos</td>
                    <td>110</td>
                    <td>$86,000</td>
                    <td>66</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Disco Duro Ssd</td>
                    <td>1TB de espacio</td>
                    <td>95</td>
                    <td>$433,060</td>
                    <td>22</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Hoodie</td>
                    <td>Hoodie de AC</td>
                    <td>102</td>
                    <td>$162,700</td>
                    <td>33</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Colchon</td>
                    <td>Colchon de espuma rosada</td>
                    <td>80</td>
                    <td>$372,000</td>
                    <td>61</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Mouse pad</td>
                    <td>Mouse pad de Sub-zero</td>
                    <td>110</td>
                    <td>$137,500</td>
                    <td>59</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Tenis</td>
                    <td>Tenis Adidas</td>
                    <td>102</td>
                    <td>$327,900</td>
                    <td>55</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Maquina de coser</td>
                    <td>Portatil</td>
                    <td>110</td>
                    <td>$205,500</td>
                    <td>39</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Trapero</td>
                    <td>Con exprimidor</td>
                    <td>95</td>
                    <td>$103,600</td>
                    <td>23</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Proteina</td>
                    <td>SMART</td>
                    <td>92</td>
                    <td>$90,560</td>
                    <td>30</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Caja juego de copas</td>
                    <td>52 piezas</td>
                    <td>95</td>
                    <td>$342,000</td>
                    <td>22</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Targeta grafica</td>
                    <td>AMD Rx 580</td>
                    <td>110</td>
                    <td>$470,600</td>
                    <td>36</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
                <tr>
                    <td>Targeta grafica</td>
                    <td>Gigabyte Gtx 1650</td>
                    <td>92</td>
                    <td>$780.750</td>
                    <td>43</td>
                    <td>
                        <i class="fa-solid fa-trash" id="btntrash"></i>
                        <i class="fa-solid fa-pen-to-square" id="btnedit"></i>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Existencias</th>
                    <th>Precio</th>
                    <th>Visitas</th>
                    <th>Configuración</th>
                </tr>
            </tfoot>
        </table>
    </div>