<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PhpSkeletonTest extends TestCase
{
    public function getPhpSkeletonValues()
    {
        $fixtures = __DIR__.'/../fixtures';

        return [
            [$fixtures.'/Test.php', '<?php'],
            [$fixtures.'/src/Test.php', '<?php'],
            [$fixtures.'/src/Acme/Command.php', "<?php\n\nnamespace Acme;\n\nclass Command\n{\n\n}"],
            [$fixtures.'/lib/Test.php', "<?php\n\nnamespace App;\n\nclass Test\n{\n\n}"],
            [$fixtures.'/company1/Controller/Site.php', "<?php\n\nnamespace Company\\Controller;\n\nclass Site\n{\n\n}"],
            [$fixtures.'/company2/Security/Listener.php', "<?php\n\nnamespace Company\\Security;\n\nclass Listener\n{\n\n}"],
        ];
    }

    /**
     * @dataProvider getPhpSkeletonValues
     */
    public function testPhpSkeleton($path, $output): void
    {
        $this->expectOutputString($output);

        system(__DIR__.'/../bin/phpskeleton.php '.$path);
    }
}
