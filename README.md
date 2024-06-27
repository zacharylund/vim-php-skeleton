# Vim PHP Skeleton

Use Composer's autoload definitions to pre-populate PHP files with namespace and class details.

For example, running `vim src/Foo/Bar.php` in a directory with an appropriate `composer.json` file will open a new file with the contents:

```php
<?php

declare(strict_types=1);

namespace Foo;

final class Bar
{

}
```

For PHPUnit tests, run `phpunit tests/`.
