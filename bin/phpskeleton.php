#!/usr/bin/env php
<?php

function getComposerFile($dir)
{
    do {
        $dir = dirname($dir);

        $composerFile = $dir.DIRECTORY_SEPARATOR.'composer.json';

        if (file_exists($composerFile)) {
            return $composerFile;
        }
    } while (DIRECTORY_SEPARATOR !== $dir);
}

function getNamespace($file)
{
    if (!$composerFile = getComposerFile($file)) {
        return;
    }

    $composerData = json_decode(file_get_contents($composerFile), true);

    $path = str_replace([dirname($composerFile).DIRECTORY_SEPARATOR, basename($file)], '', $file);

    foreach ($composerData['autoload']['psr-4'] as $namespacePrefix => $pathPrefixes) {
        if (!is_array($pathPrefixes)) {
            $pathPrefixes = [$pathPrefixes];
        }

        foreach ($pathPrefixes as $pathPrefix) {
            if (0 === strpos($path, $pathPrefix)) {
                $namespace = str_replace(DIRECTORY_SEPARATOR, '\\', str_replace($pathPrefix, '', $path));

                if ($namespacePrefix) {
                    $namespace = $namespacePrefix.$namespace;
                }

                return rtrim($namespace, '\\');
            }
        }
    }
}

$file = $argv[1];

$class = basename($file, '.php');

if (!$namespace = getNamespace($file)) {
    echo '<?php';
    exit;
}

echo <<<PHP
<?php

namespace $namespace;

class $class
{

}
PHP;
