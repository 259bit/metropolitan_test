<?php

namespace Metropolitan\Test\ExternalApi;

use Bitrix\Main\Config\Option;
use Bitrix\Main\ObjectException;
use Bitrix\Main\ObjectNotFoundException;
use JsonException;
use Metropolitan\Test\HttpConnector\Connection;
use Metropolitan\Test\Repository\CrmLeadRepositoryMpd;

class MpdOrder
{

    private string $jsonUrl;
    private Connection $connection;

    private CrmLeadRepositoryMpd $crmLeadMpdRepository;

    public function __construct()
    {
        $this->jsonUrl = Option::get(METROPOLITAN_TEST_MODULE_ID, 'MPD_JSON_URL');
        $this->connection = new Connection();
        $this->crmLeadMpdRepository = new CrmLeadRepositoryMpd();
    }

    /**
     * @throws JsonException
     * @throws ObjectNotFoundException
     */
    public function getLasts(): array
    {
        $this->connection->setUrl($this->jsonUrl);
        $response = $this->connection->getResponse();

        if ($response->isSuccess()) {
            $orders = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            if($orders) {
                foreach ($orders as $key => &$order) {
                    $order['mpdId'] = $key;
               }
            }
            return $orders;
        }

        throw new ObjectNotFoundException("Error connecting to " . $response->getLastUrl());
    }

    /**
     * @throws ObjectException
     */
    public function saveToLead(array $order): void
    {
        if($this->isLeadExist($order)) {
            return;
        }

        $lead = $this->crmLeadMpdRepository->getModel();

        $lead->setMpdId($order['mpdId']);
        $lead->setAssignedId($this->crmLeadMpdRepository::getDefaultAssignedId());
        $lead->setName($order['Name']);
        $lead->setLastName($order['LastName']);
        $lead->setMobilePhone($order['MobilePhone']);
        $lead->setEmail($order['Email']);
        $lead->setOrderFile($order['Order']);
        $lead->setMessage($order['Message']);
        $lead->setProfileLink($order['ProfileLink']);

        $this->crmLeadMpdRepository->addElement($lead);

    }

    private function isLeadExist(array $order): bool
    {
        $leadId = $this->crmLeadMpdRepository->getElementIdByMpdId($order['mpdId']);
        return $leadId !== 0;
    }


}