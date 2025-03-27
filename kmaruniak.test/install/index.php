<?php

declare(strict_types=1);

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

class Kmaruniak_test extends CModule
{
    /** @var string */
    public $MODULE_VERSION;

    /** @var string */
    public $MODULE_ID = 'kmaruniak.test';

    /** @var string */
    public $MODULE_NAME;

    /** @var string */
    public $MODULE_DESCRIPTION;

    /** @var string */
    public $MODULE_VERSION_DATE;

    /** @var string */
    public $PARTNER_URI;

    /** @var string */
    public $PARTNER_NAME;

    public function __construct()
    {
        Loc::loadMessages(__FILE__);
        $arModuleVersion = [];

        include_once __DIR__ . '/version.php';

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        $this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
        $this->PARTNER_URI = Loc::getMessage('PARTNER_URI');
        $this->PARTNER_NAME = Loc::getMessage('PARTNER_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_NAME');
    }

    public function DoInstall(): void
    {
        global $APPLICATION, $step;

        if ((int)$step < 1) {
            $APPLICATION->IncludeAdminFile(Loc::getMessage('STEP1_TITLE'), __DIR__ . '/step1.php');
        }

        if ((int)$step === 2) {
            $this->InstallDB();
            $this->InstallFiles();

            ModuleManager::registerModule($this->MODULE_ID);
        }
    }

    public function DoUninstall(): void
    {
        global $APPLICATION, $step;

        if ((int)$step < 1) {
            $APPLICATION->IncludeAdminFile(Loc::getMessage('STEP1_DELETE_TITLE'), __DIR__ . '/unstep1.php');
        }

        if ((int)$step === 2) {
            $this->UnInstallDB();
            $this->UnInstallFiles();

            ModuleManager::unRegisterModule($this->MODULE_ID);
        }
    }

    public function InstallDB(): bool
    {
        global $DB;

        $connectionType = Application::getConnection()->getType();

        if (Application::getInstance()->getContext()->getRequest()->getPost('drop') === 'Y') {
            $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/uninstall.sql');
        }

        $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/install.sql');

        if (Application::getInstance()->getContext()->getRequest()->getPost('fill') === 'Y') {
            $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/vendors.sql');
            $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/models.sql');
            $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/laptops.sql');
            $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/options.sql');
            $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/option_relations.sql');
        }

        return true;
    }

    public function UnInstallDB(): bool
    {
        global $DB;

        $connectionType = Application::getConnection()->getType();

        if (Application::getInstance()->getContext()->getRequest()->getPost('drop') === 'Y') {
            $DB->RunSQLBatch(__DIR__ . '/db/' . $connectionType . '/uninstall.sql');
        }

        return true;
    }

    public function InstallFiles(): void
    {
        CopyDirFiles(__DIR__ . '/components', $_SERVER['DOCUMENT_ROOT'] . '/local/components', true, true);
    }
}