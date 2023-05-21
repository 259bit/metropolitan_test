<?php

namespace Metropolitan\Test\Repository;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\ObjectException;
use CCrmLead;
use Metropolitan\Test\Model\CrmLeadModelBase;

class CrmLeadRepositoryBase
{
    private static array $modules = ['crm'];

    /**
     * @throws LoaderException
     */
    public function __construct()
    {
        static::includeModules();
    }
    public function getModel(): CrmLeadModelBase
    {
        return new CrmLeadModelBase();
    }

    /**
     * @throws LoaderException
     */
    public static function includeModules(): void
    {
        foreach (static::$modules as $module) {
            if (!Loader::includeModule($module)) {
                throw new LoaderException('Module not installed  ' . $module);
            }
        }
    }
    public static function getDefaultAssignedId(): ?int
    {
        return 1;
    }

    /**
     * @throws ObjectException
     */
    public function addElement(CrmLeadModelBase $element): ?CrmLeadModelBase
    {
        $lead = new CCrmLead(false);

        if ($element->getAssignedId() === null) {
            $element->setAssignedId(static::getDefaultAssignedId());
        }

        $arElement = $this->createArrayFromElement($element);
        $elementId = $lead->Add($arElement);

        if (empty($elementId)) {
            throw new ObjectException($lead->LAST_ERROR ?: 'An error occurred when adding a lead');
        }
        $element->setId($elementId);

        return $element;
    }

    public function createArrayFromElement(CrmLeadModelBase $element): array
    {
        return [
            'ID' => (int)$element->getId() ?: null,
            'ASSIGNED_BY_ID' => $element->getAssignedId(),
            'NAME' => $element->getName(),
            'LAST_NAME' => $element->getLastName(),
            'PHONE' => [
                [
                    'VALUE' => $element->getMobilePhone(),
                    'VALUE_TYPE' => 'MOBILE',
                ],
            ],
            'EMAIL' => [
                [
                    'VALUE' => $element->getEmail(),
                    'VALUE_TYPE' => 'WORK',
                ],
            ]
        ];
    }
}