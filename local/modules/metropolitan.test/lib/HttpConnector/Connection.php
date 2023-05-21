<?php

namespace Metropolitan\Test\HttpConnector;

/**
 * Class Connection
 * @package Metropolitan\Test\HttpConnector
 */
class Connection
{
    /**
     * Текущее подключение
     * @var false|resource
     */
    protected $connection;

    private array $headers = [];

    /**
     * Создание подключения
     */
    public function __construct()
    {
        $this->connection = curl_init();

        $this->setOption(CURLOPT_HEADER, 1);
        $this->setOption(CURLOPT_RETURNTRANSFER, true);
        $this->setOption(CURLOPT_SSL_VERIFYPEER, false);
    }

    /**
     * Завершение подключения
     */
    public function __destruct()
    {
        curl_close($this->connection);
    }

    /**
     * @param string $option
     * @param $value
     */
    public function setOption(string $option, $value)
    {
        curl_setopt($this->connection, $option, $value);
    }

    public function setUserPwd(string $login, string $password)
    {
        $this->setOption(CURLOPT_USERPWD, $login.":".$password);
    }

    /**
     * @param string $header
     */
    public function addHeader(string $header)
    {
        if(!in_array($header, $this->headers)) {
            $this->headers[] = $header;
        }
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = array_unique($headers);
    }

    /**
     * @param string $fields
     */
    public function setPostFields(string $fields)
    {
        $this->setOption(CURLOPT_POSTFIELDS, $fields);
    }

    /**
     * Выполнение запроса
     * @return bool|string
     */
    protected function getResult()
    {
        $this->setOption(CURLOPT_HTTPHEADER, $this->headers);

        return curl_exec($this->connection);
    }

    /**
     * Установка URL
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->setOption(CURLOPT_URL, $url);
    }

    /**
     * Возвращает ответ запроса
     * @return Response
     */
    public function getResponse(): Response
    {
        $result = $this->getResult();
        $header_size = curl_getinfo($this->connection, CURLINFO_HEADER_SIZE);

        $response = [
            'header' => substr($result, 0, $header_size),
            'body' => substr($result, $header_size),
            'code' => curl_getinfo($this->connection, CURLINFO_HTTP_CODE),
            'lastUrl' => curl_getinfo($this->connection, CURLINFO_EFFECTIVE_URL),
            'error' => curl_error($this->connection)
        ];

        return new Response($response);
    }
}