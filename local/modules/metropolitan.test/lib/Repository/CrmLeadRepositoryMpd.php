<?php

namespace Metropolitan\Test\Repository;

use CCrmLead;
use CFile;
use Metropolitan\Test\Model\CrmLeadModelBase;
use Metropolitan\Test\Model\CrmLeadModelMpd;

class CrmLeadRepositoryMpd extends CrmLeadRepositoryBase
{

    public function getModel(): CrmLeadModelMpd
    {
        return new CrmLeadModelMpd();
    }

    public function getElementIdByMpdId(string $externalId): ?int
    {
        $filter = [
            '=UF_CRM_LEAD_MPD_ID' => $externalId,
            'CHECK_PERMISSIONS' => 'N',
        ];
        $select = ['ID'];
        $result = CCrmLead::GetList([], $filter, $select);
        $elementId = $result->Fetch()['ID'];
        return (int)$elementId;
    }

    public function createArrayFromElement(CrmLeadModelMpd|CrmLeadModelBase $element): array
    {
        $arBasicElement = parent::createArrayFromElement($element);

        $arElement = array_merge($arBasicElement, [
            'UF_CRM_LEAD_MPD_ID' => $element->getMpdId(),
            'UF_CRM_LEAD_PROFILE_LINK' => $element->getProfileLink(),
            'UF_CRM_LEAD_MESSAGE' => $element->getMessage(),
            'UF_CRM_LEAD_ORDER_FILE' => CFile::MakeFileArray($element->getOrderFile()),
        ]);

        return $arElement;
    }

}