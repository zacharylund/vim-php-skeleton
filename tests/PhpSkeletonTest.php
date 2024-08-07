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
            [$psr4Autoload.'/src/Acme/Command.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace Acme;\n\nfinal class Command\n{\n\n}"],
            [$psr4Autoload.'/lib/Test.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace App;\n\nfinal class Test\n{\n\n}"],
            [$psr4Autoload.'/company1/Controller/Site.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace Company\\Controller;\n\nfinal class Site\n{\n\n}"],
            [$psr4Autoload.'/company2/Security/Listener.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace Company\\Security;\n\nfinal class Listener\n{\n\n}"],

            [$psr4Autoload.'/tests/Controller/SiteControllerTest.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace Tests\\App\\Controller;\n\nfinal class SiteControllerTest\n{\n\n}"],

            [$psr4Autoload.'/lib/AbstractTest.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace App;\n\nabstract class AbstractTest\n{\n\n}"],
            [$psr4Autoload.'/lib/TestInterface.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace App;\n\ninterface TestInterface\n{\n\n}"],
            [$psr4Autoload.'/lib/TestTrait.php', "<?php\n\ndeclare(strict_types=1);\n\nnamespace App;\n\ntrait TestTrait\n{\n\n}"],
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
