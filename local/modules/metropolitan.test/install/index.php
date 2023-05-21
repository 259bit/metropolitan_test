<?php

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\ObjectException;

Loc::loadLanguageFile(__FILE__);

/**
 * Class metropolitan_test
 */
class metropolitan_test extends CModule
{

    /**
     * @var false|string|string[]
     */
    public $MODULE_ID;
    /**
     * @var mixed
     */
    public $MODULE_VERSION;
    /**
     * @var mixed
     */
    public $MODULE_VERSION_DATE;
    /**
     * @var
     */
    public $MODULE_NAME;
    /**
     * @var
     */
    public $MODULE_DESCRIPTION;
    /**
     * @var
     */
    public $PARTNER_NAME;
    /**
     * @var
     */
    public $PARTNER_URI;

    /**
     * metropolitan_test constructor.
     */
    public function __construct()
    {
        if (file_exists(__DIR__ . "/version.php")) {

            $arModuleVersion = [];

            include_once(__DIR__ . "/version.php");
            $this->MODULE_ID = str_replace("_", ".", get_class($this));
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
            $this->MODULE_NAME = Loc::getMessage('METROPOLITAN_TEST_MODULE_NAME');
            $this->MODULE_DESCRIPTION = Loc::getMessage('METROPOLITAN_TEST_MODULE_DESCRIPTION');
            $this->PARTNER_NAME = Loc::getMessage('METROPOLITAN_TEST_PARTNER_NAME');
            $this->PARTNER_URI = Loc::getMessage('METROPOLITAN_TEST_PARTNER_URI');
        }
    }

    /**
     * @throws ObjectException
     * @throws ArgumentOutOfRangeException
     */
    public function DoInstall(): void
    {
        $this->installUserFields();
        ModuleManager::registerModule($this->MODULE_ID);
        $this->setOptions();
        $this->installAgents();
    }

    /**
     * @throws ObjectException
     */
    public function installUserFields(): void
    {
        $this->createProfileLinkUserField();
        $this->createMessageUserField();
        $this->createOrderFileUserField();
        $this->createMpdIdUserField();
    }

    /**
     * @throws ObjectException
     */
    private function createProfileLinkUserField(): void
    {
        $fieldCode = 'UF_CRM_LEAD_PROFILE_LINK';

        $fieldData = [
            'ENTITY_ID' => 'CRM_LEAD',
            'FIELD_NAME' => $fieldCode,
            'USER_TYPE_ID' => 'url',
            'EDIT_FORM_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_PROFILE_LINK')
            ],
            'LIST_COLUMN_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_PROFILE_LINK')
            ],
            'LIST_FILTER_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_PROFILE_LINK')
            ],
            'MANDATORY' => 'N',
            'MULTIPLE' => 'N',
        ];

        $newUserFieldId = (new CUserTypeEntity)->add($fieldData);
        if ($newUserFieldId === false) {
            throw new ObjectException('Error creating user field ' . $fieldCode);
        }
    }

    /**
     * @throws ObjectException
     */
    private function createMessageUserField(): void
    {
        $fieldCode = 'UF_CRM_LEAD_MESSAGE';

        $fieldData = [
            'ENTITY_ID' => 'CRM_LEAD',
            'FIELD_NAME' => $fieldCode,
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_MESSAGE')
            ],
            'LIST_COLUMN_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_MESSAGE')
            ],
            'LIST_FILTER_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_MESSAGE')
            ],
            'MANDATORY' => 'N',
            'MULTIPLE' => 'N',
        ];

        $newUserFieldId = (new CUserTypeEntity)->add($fieldData);
        if ($newUserFieldId === false) {
            throw new ObjectException('Error creating user field ' . $fieldCode);
        }
    }

    /**
     * @throws ObjectException
     */
    private function createOrderFileUserField(): void
    {
        $fieldCode = 'UF_CRM_LEAD_ORDER_FILE';

        $fieldData = [
            'ENTITY_ID' => 'CRM_LEAD',
            'FIELD_NAME' => $fieldCode,
            'USER_TYPE_ID' => 'file',
            'EDIT_FORM_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_ORDER_FILE')
            ],
            'LIST_COLUMN_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_ORDER_FILE')
            ],
            'LIST_FILTER_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_ORDER_FILE')
            ],
            'MANDATORY' => 'N',
            'MULTIPLE' => 'N',
        ];

        $newUserFieldId = (new CUserTypeEntity)->add($fieldData);
        if ($newUserFieldId === false) {
            throw new ObjectException('Error creating user field ' . $fieldCode);
        }
    }

    /**
     * @throws ObjectException
     */
    private function createMpdIdUserField(): void
    {
        $fieldCode = 'UF_CRM_LEAD_MPD_ID';

        $fieldData = [
            'ENTITY_ID' => 'CRM_LEAD',
            'FIELD_NAME' => $fieldCode,
            'USER_TYPE_ID' => 'string',
            'EDIT_FORM_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_MPD_ID')
            ],
            'LIST_COLUMN_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_MPD_ID')
            ],
            'LIST_FILTER_LABEL' => [
                'ru' => Loc::getMessage('METROPOLITAN_TEST_UF_CRM_LEAD_MPD_ID')
            ],
            'MANDATORY' => 'N',
            'MULTIPLE' => 'N',
        ];

        $newUserFieldId = (new CUserTypeEntity)->add($fieldData);
        if ($newUserFieldId === false) {
            throw new ObjectException('Error creating user field ' . $fieldCode);
        }
    }

    /**
     * @throws ArgumentNullException
     */
    public function DoUninstall(): void
    {
        $this->unInstallUserFields();
        $this->unSetOptions();
        $this->unInstallAgents();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function unInstallUserFields(): void
    {
        $entity = new CUserTypeEntity;

        $userFieldCodes = [
            'UF_CRM_LEAD_PROFILE_LINK',
            'UF_CRM_LEAD_MESSAGE',
            'UF_CRM_LEAD_ORDER_FILE',
            'UF_CRM_LEAD_MPD_ID'
        ];

        foreach ($userFieldCodes as $userFieldCode) {
            $rsData = CUserTypeEntity::GetList(["ID" => "ASC"], ["FIELD_NAME" => $userFieldCode]);
            if ($rsData && ($arRes = $rsData->Fetch())) {
                do {
                    $entity->Delete($arRes['ID']);
                } while ($arRes = $rsData->Fetch());
            }
        }
    }

    /**
     * @throws ArgumentOutOfRangeException
     */
    private function setOptions(): void
    {
        Option::set($this->MODULE_ID, 'MPD_JSON_URL', 'https://crm.mpd.ae/upload/orders%20(1).json');
    }

    /**
     * @throws ArgumentNullException
     */
    private function unSetOptions(): void
    {
        Option::delete($this->MODULE_ID);
    }

    private function installAgents(): void
    {
        $startTime = ConvertTimeStamp(time() + CTimeZone::GetOffset() + 60, 'FULL');

        CAgent::addAgent(
            'Metropolitan\Test\Agent\MpdAgent::saveOrdersToLeads();',
            $this->MODULE_ID,
            'N',
            86400,
            '',
            'Y',
            $startTime
        );
    }

    private function unInstallAgents(): void
    {
        CAgent::removeModuleAgents($this->MODULE_ID);
    }

}