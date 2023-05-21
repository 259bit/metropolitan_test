<?php

namespace Metropolitan\Test\HttpConnector;

/**
 * Class Response
 * @package Metropolitan\Test\HttpConnector
 */
class Response
{
    /**
     * Код успешного ответа
     */
    const SUCCESS_CODE = 200;

    /**
     * Код ответа - доступ запрещен
     */
    const FORBIDDEN_CODE = 403;

    /**
     * Код ответа - bad request
     */
    const BAD_REQUEST_CODE = 400;

    /**
     * Заголовок овтета
     * @var string
     */
    protected $header;

    /**
     * Тело ответа
     * @var string
     */
    protected ?string $body = null;

    /**
     * Код ответа
     * @var int
     */
    protected ?int $code = null;

    /**
     * Ошибка в ответе
     * @var string
     */
    protected $error;

    /**
     * URL с которого пришел ответа
     * @var string
     */
    protected $lastUrl;

    /**
     * Response constructor.
     * @param array $response
     */
    public function __construct(array $response)
    {
        $this->header = $response['header'] ?: '';
        $this->body = $response['body'] ?: '';
        $this->error = $response['error'] ?: '';
        $this->lastUrl = $response['lastUrl'] ?: '';
        $this->code = (int)$response['code'];
    }

    /**
     * Возвращает заголовок ответа
     * @return string
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * Возвращает тело ответа
     * @return string
     */
    public function getBody(): string
    {
        return $this->body ?: '';
    }

    /**
     * Возвращает код ответа
     * @return int
     */
    public function getCode(): int
    {
        return (int)$this->code;
    }

    /**
     * Возвращает ошибки в ответе
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Возвращает URL с которого пришел ответ
     * @return string
     */
    public function getLastUrl(): string
    {
        return $this->lastUrl;
    }

    /**
     * @param string $toEncoding
     * @param string $fromEncoding
     */
    public function encodingBody(string $toEncoding, string $fromEncoding)
    {
        $this->body = mb_convert_encoding($this->getBody(), $toEncoding, $fromEncoding);
    }

    /**
     * Является ли ответ равным - доступ запрещен
     * @return bool
     */
    public function isForbidden()
    {
        return $this->getCode() == self::FORBIDDEN_CODE;
    }

    /**
     * Является ли ответ равным - bad request
     * @return bool
     */
    public function isBadRequest()
    {
        return $this->getCode() == self::BAD_REQUEST_CODE;
    }

    /**
     * Успешным считается ответ, ответ которого равен 200 и нет ошибок
     * @return bool
     */
    public function isSuccess(): bool
    {
        return ($this->getCode() == self::SUCCESS_CODE) && (empty($this->getError()));
    }
}