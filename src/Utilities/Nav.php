<?php

namespace Utilities;

class Nav
{
    /**
     * Establece el contexto de navegación pública.
     */
    public static function setPublicNavContext()
    {
        // Verificar si la navegación pública ya está en el contexto
        $tmpNAVIGATION = Context::getContextByKey("PUBLIC_NAVIGATION");
        if ($tmpNAVIGATION === "") {
            // Cargar los datos de navegación desde el archivo JSON
            $navigationData = self::getNavFromJson()["public"];

            // Iniciar sesión si no está iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Obtener el idRol del usuario desde la sesión
            $usuario = $_SESSION['user'] ?? null;
            $usuarioIdRol = $usuario['idRol'] ?? null;

            $filteredNavigation = [];

            // Filtrar la navegación según los roles permitidos
            foreach ($navigationData as $navEntry) {
                if (empty($navEntry['roles']) || ($usuarioIdRol !== null && in_array($usuarioIdRol, $navEntry['roles']))) {
                    $filteredNavigation[] = $navEntry;
                }
            }

            // Guardar la navegación pública filtrada en el contexto
            $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
            Context::setContext("PUBLIC_NAVIGATION", $filteredNavigation, $saveToSession);
        }
    }

    /**
     * Establece el contexto de navegación privada.
     */
    public static function setNavContext()
    {
        // Verificar si la navegación privada ya está en el contexto
        $tmpNAVIGATION = Context::getContextByKey("NAVIGATION");
        if ($tmpNAVIGATION === "") {
            $tmpNAVIGATION = [];

            // Obtener el idRol del usuario desde la sesión
            $usuarioIdRol = $_SESSION['user']['idRol'] ?? null;

            // Cargar los datos de navegación desde el archivo JSON
            $navigationData = self::getNavFromJson()["private"];

            // Filtrar la navegación privada según los roles
            foreach ($navigationData as $navEntry) {
                if ($usuarioIdRol !== null && in_array($usuarioIdRol, $navEntry['roles'])) {
                    $tmpNAVIGATION[] = $navEntry;
                }
            }

            // Guardar la navegación privada filtrada en el contexto
            $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
            Context::setContext("NAVIGATION", $tmpNAVIGATION, $saveToSession);
        }
    }

    /**
     * Invalida los datos de navegación almacenados.
     */
    public static function invalidateNavData()
    {
        // Remover el contexto de navegación
        Context::removeContextByKey("NAVIGATION_DATA");
        Context::removeContextByKey("NAVIGATION");
        Context::removeContextByKey("PUBLIC_NAVIGATION");
    }

    /**
     * Obtiene los datos de navegación desde un archivo JSON.
     *
     * @return array
     * @throws \Exception
     */
    private static function getNavFromJson()
    {
        // Verificar si los datos de navegación ya están en el contexto
        $jsonContent = Context::getContextByKey("NAVIGATION_DATA");
        if ($jsonContent === "") {
            // Ruta al archivo JSON de configuración de navegación
            $filePath = 'nav.config.json';

            // Verificar la existencia y legibilidad del archivo JSON
            if (!file_exists($filePath)) {
                throw new \Exception(sprintf('%s does not exist', $filePath));
            }
            if (!is_readable($filePath)) {
                throw new \Exception(sprintf('%s file is not readable', $filePath));
            }

            // Leer el contenido del archivo JSON
            $jsonContent = file_get_contents($filePath);
            $saveToSession = intval(Context::getContextByKey("DEVELOPMENT")) !== 1;
            Context::setContext("NAVIGATION_DATA", $jsonContent, $saveToSession);
        }

        // Decodificar el JSON a un array asociativo
        $jsonData = json_decode($jsonContent, true);
        return $jsonData;
    }

    // Constructor privado para evitar instancias de esta clase
    private function __construct()
    {
    }

    // Clonación privada para evitar la duplicación de instancias de esta clase
    private function __clone()
    {
    }
}
