<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PhpSkeletonTest extends TestCase
{
    public function getPhpSkeletonValues(): array
    {
        $noAutoload = __DIR__.'/../fixtures/no-autoload';
        $noComposer = __DIR__;
        $psr4Autoload = __DIR__.'/../fixtures/psr4-autoload';

        return [
            [$noAutoload.'/Test.php', "<?php\n\ndeclare(strict_types=1);"],
            [$noAutoload.'/src/Test.php', "<?php\n\ndeclare(strict_types=1);"],
            [$noAutoload.'/lib/Test.php', "<?php\n\ndeclare(strict_types=1);"],

            [$noComposer.'/Test.php', "<?php\n\ndeclare(strict_types=1);"],
            [$noComposer.'/src/Test.php', "<?php\n\ndeclare(strict_types=1);"],
            [$noComposer.'/lib/Test.php', "<?php\n\ndeclare(strict_types=1);"],

            [$psr4Autoload.'/Test.php', "<?php\n\ndeclare(strict_types=1);"],
            [$psr4Autoload.'/src/Test.php', "<?php\n\ndeclare(strict_types=1);"],
            [$psr4Autoload.'/src/Acme/Command.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace Acme;\n\nclass Command\n{\n\n}"],
            [$psr4Autoload.'/lib/Test.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace App;\n\nclass Test\n{\n\n}"],
            [$psr4Autoload.'/company1/Controller/Site.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace Company\\Controller;\n\nclass Site\n{\n\n}"],
            [$psr4Autoload.'/company2/Security/Listener.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace Company\\Security;\n\nclass Listener\n{\n\n}"],
        ];
    }

    /**
     * @dataProvider getPhpSkeletonValues
     */
    public function testPhpSkeleton(string $path, string $output): void
    {
        $this->expectOutputString($output);

        system(__DIR__.'/../bin/phpskeleton.php '.$path);
    }
}
