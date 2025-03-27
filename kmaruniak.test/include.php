<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Loader::registerAutoLoadClasses(
    Loc::getMessage('MODULE_ID'),
    [
        '\KMaruniak\Orm\VendorTable' => 'lib/Orm/VendorTable.php',
        '\KMaruniak\Orm\ModelTable' => 'lib/Orm/ModelTable.php',
        '\KMaruniak\Orm\LaptopTable' => 'lib/Orm/LaptopTable.php',
        '\KMaruniak\Orm\OptionsTable' => 'lib/Orm/OptionsTable.php',
        '\KMaruniak\Repository\AbstractRepository' => 'lib/Repository/AbstractRepository.php',
        '\KMaruniak\Repository\LaptopRepository' => 'lib/Repository/LaptopRepository.php',
        '\KMaruniak\Repository\ModelRepository' => 'lib/Repository/ModelRepository.php',
        '\KMaruniak\Repository\VendorRepository' => 'lib/Repository/VendorRepository.php',
        '\KMaruniak\Repository\Interfaces\RepositoryInterface' => 'lib/Repository/Interfaces/RepositoryInterface.php',
        '\KMaruniak\Repository\Interfaces\SelectInterface' => 'lib/Repository/Interfaces/SelectInterface.php',
        '\KMaruniak\Factory\RepositoryFactory' => 'lib/Factory/RepositoryFactory.php',
        '\KMaruniak\Helper\EntityHelper' => 'lib/Helper/EntityHelper.php',
    ]
);
