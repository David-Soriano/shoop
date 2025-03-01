<?php include_once('../model/musu.php');
if (!class_exists('Conexion')) {
    include_once('../model/conexion.php');
}

$idusu = isset($_REQUEST['idusu']) ? $_REQUEST['idusu'] : NULL;
$nomusu = isset($_POST['nomusu']) ? $_POST['nomusu'] : NULL;
$apeusu = isset($_POST['apeusu']) ? $_POST['apeusu'] : NULL;
$tipdoc = isset($_POST['tipdoc']) ? $_POST['tipdoc'] : NULL;
$docusu = isset($_POST['docusu']) ? $_POST['docusu'] : NULL;
$emausu = isset($_POST['emausu']) ? $_POST['emausu'] : NULL;
$celusu = isset($_POST['celusu']) ? $_POST['celusu'] : NULL;
$genusu = isset($_POST['genusu']) ? $_POST['genusu'] : NULL;
$idubi = isset($_POST['ciudad']) ? $_POST['ciudad'] : NULL;
$dirrecusu = isset($_POST['dirrecusu']) ? $_POST['dirrecusu'] : NULL;
$idpef = isset($_POST['idpef']) ? $_POST['idpef'] : NULL;
$pasusu = isset($_POST['pasusu']) ? $_POST['pasusu'] : NULL;

$ope = isset($_POST['ope']) ? $_POST['ope'] : NULL;

$usu = new Musu();


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$idubiUsuario = $_SESSION['idubi'] ?? null; // Ciudad del usuario

function obtenerUbicacion($idubi) {
    // Conexión a la BD
    $modelo = new Conexion();
    $conexion = $modelo->getConexion();

    // Obtener el departamento correspondiente a la ciudad
    $stmt = $conexion->prepare("SELECT depenubi FROM ubicacion WHERE idubi = :idubi");
    $stmt->bindParam(':idubi', $idubi, PDO::PARAM_INT);
    $stmt->execute();
    $departamentoID = $stmt->fetchColumn();

    // Si `depenubi` es 0, significa que `idubi` ya es un departamento
    if ($departamentoID == 0) {
        $departamentoID = $idubi;
    }

    // Obtener todos los departamentos (depenubi = 0)
    $stmt = $conexion->prepare("SELECT * FROM ubicacion WHERE depenubi = 0");
    $stmt->execute();
    $dtDtp = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener ciudades del departamento correspondiente
    $stmt = $conexion->prepare("SELECT * FROM ubicacion WHERE depenubi = :departamentoID");
    $stmt->bindParam(':departamentoID', $departamentoID, PDO::PARAM_INT);
    $stmt->execute();
    $ciudades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'departamentoID' => $departamentoID,
        'dtDtp' => $dtDtp,
        'ciudades' => $ciudades
    ];
}

// Ejemplo de uso:

$ubicacion = obtenerUbicacion($idubiUsuario);

// Ahora puedes acceder a los datos retornados
$departamentoID = $ubicacion['departamentoID'];
$dtDtp = $ubicacion['dtDtp'];
$ciudades = $ubicacion['ciudades'];


if ($ope == "save") {
    if ($isCorreo) {
        echo "El usuario ya se ha registrado anteriormente. Intente de nuevo";
    } else {
        $usu->setNomusu($nomusu);
        $usu->setApeusu($apeusu);
        $usu->setTipdoc($tipdoc);
        $usu->setDocusu($docusu);
        $usu->setEmausu($emausu);
        $usu->setCelusu($celusu);
        $usu->setGenusu($genusu);
        $usu->setIdubi($idubi);
        $usu->setDirrecusu($dirrecusu);
        $usu->setIdpef($idpef);
        $hashedPassword = password_hash($pasusu, PASSWORD_DEFAULT); // Hashear la contraseña
        $usu->setPasusu($hashedPassword);

        $res = $usu->saveUsu();
        if ($res == 2) {
            header("Location: ../views/admin.php?pg=31&error=4");
            exit();
        }

        // Si no es 2, redirige a la misma página
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
} else if ($ope == 'eliUs') {
    header("Content-Type: application/json");
    $usu->setIdusu($idusu);

    if ($usu->delUsu()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "No se pudo eliminar usuario"]);
    }
} else if ($ope == 'edit') {
    $usu->setIdusu($idusu);
    $usu->setNomusu($nomusu);
    $usu->setApeusu($apeusu);
    $usu->setEmausu($emausu);
    $usu->setCelusu($celusu);
    if ($usu->editUsu()) {
        updateSession();
        header("Location: ../home.php?pg=15&msj=1");
    } else {
        header("Location: ../home.php?pg=15&msj=2");
    }
} else if ($ope == 'editPass') {
    session_start();
    $modelo = new Conexion();
    $conexion = $modelo->getConexion();

    // Obtener la contraseña actual del usuario
    $stmt = $conexion->prepare("SELECT pasusu FROM usuario WHERE idusu = :idusu");
    $stmt->bindParam(':idusu', $_SESSION['idusu'], PDO::PARAM_INT);
    $stmt->execute();
    $pass = $stmt->fetchColumn(); // Obtiene la contraseña almacenada en la BD

    // Validar que la contraseña ingresada (pasusu2) coincide con la guardada
    if (isset($_POST['pasusu2']) && password_verify($_POST['pasusu2'], $pass)) {
        $usu->setIdusu($_SESSION['idusu']);

        // Hashear la nueva contraseña ingresada
        $hashedPassword = password_hash($_POST['pasusu'], PASSWORD_DEFAULT);
        $usu->setPasusu($hashedPassword);

        // Llamar la función que actualiza la contraseña en la BD
        if ($usu->editContraseña()) {
            header("Location: ../home.php?pg=15&msj=1"); // Contraseña cambiada con éxito
        } else {
            header("Location: ../home.php?pg=15&msj=2"); // Error al actualizar
        }
    } else {
        header("Location: ../home.php?pg=15&msj=3"); // Contraseña actual incorrecta
    }

} else if ($ope == "editDir") {
    $idubi = intval($_POST['ciudad'] ?? 0);
    $usu->setIdusu($_SESSION['idusu']);
    $usu->setDirrecusu($dirrecusu);
    $usu->setIdubi($idubi);

    if ($usu->editDireccion()) {
        updateSession();
        var_dump($_SESSION);
        header("Location: ../home.php?pg=15&msj=1");
    } else {
        header("Location: ../home.php?pg=15&msj=2");
    }
}

function updateSession()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $modelo = new Conexion();
    $conexion = $modelo->getConexion();
    $stmt = $conexion->prepare("SELECT 
            u.idusu, u.nomusu, u.apeusu, u.docusu, u.emausu, u.pasusu, 
            u.celusu, u.genusu, u.dirrecusu, u.tipdoc, u.fotpef, u.idpef, 
            u.idubi, u.estusu, p.nompef, p.pagini, 
            ciu.nomubi AS ciudad, dep.nomubi AS departamento 
            FROM usuario AS u 
            INNER JOIN perfil AS p ON u.idpef = p.idpef 
            INNER JOIN ubicacion AS ciu ON u.idubi = ciu.idubi 
            LEFT JOIN ubicacion AS dep ON ciu.depenubi = dep.idubi 
            WHERE u.idusu = :idusu");

    $stmt->bindParam(':idusu', $_SESSION['idusu'], PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Actualizar sesión con los datos más recientes
    if ($usuario) {
        foreach ($usuario as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }
}