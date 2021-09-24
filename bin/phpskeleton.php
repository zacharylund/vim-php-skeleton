#!/usr/bin/env php
<?php

declare(strict_types=1);

function getComposerFile(string $dir): ?string
{
    do {
        $dir = dirname($dir);

        $composerFile = $dir.DIRECTORY_SEPARATOR.'composer.json';

        if (file_exists($composerFile)) {
            return $composerFile;
        }
    } while (DIRECTORY_SEPARATOR !== $dir);

    return null;
}

function getNamespace(string $file): ?string
{
    if (!$composerFile = getComposerFile($file)) {
        return null;
    }

    $composerData = json_decode(file_get_contents($composerFile), true);

    $path = str_replace([dirname($composerFile).DIRECTORY_SEPARATOR, basename($file)], '', $file);

    $autoloads = [];

    if (isset($composerData['autoload-dev']['psr-4'])) {
        $autoloads = array_merge($autoloads, $composerData['autoload-dev']['psr-4']);
    }

    if (isset($composerData['autoload']['psr-4'])) {
        $autoloads = array_merge($autoloads, $composerData['autoload']['psr-4']);
    }

    foreach ($autoloads as $namespacePrefix => $pathPrefixes) {
        if (!is_array($pathPrefixes)) {
            $pathPrefixes = [$pathPrefixes];
        }

        foreach ($pathPrefixes as $pathPrefix) {
            if ('' === $pathPrefix || 0 === strpos($path, $pathPrefix)) {
                $namespace = str_replace(DIRECTORY_SEPARATOR, '\\', str_replace($pathPrefix, '', $path));

                if ($namespacePrefix) {
                    $namespace = $namespacePrefix.$namespace;
                }

                if ($namespace = rtrim($namespace, '\\')) {
                    return $namespace;
                }
            }
        }
    }

    return null;
}

$file = $argv[1];

$class = basename($file, '.php');

if (null === $namespace = getNamespace($file)) {
    echo "<?php\n\ndeclare(strict_types=1);";
    exit;
}

echo <<<PHP
<?php

declare(strict_types=1);

namespace $namespace;

class $class
{

}
PHP;
