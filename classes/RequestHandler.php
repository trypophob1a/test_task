<?php

namespace classes;

use Exception;
use UnexpectedValueException;

class RequestHandler
{
    private array $data;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (!$this->isAjax()) {
            throw new Exception('Ошибка Сервера', 403);
        }

        $json = json_decode(file_get_contents('php://input'), true);
        $this->data = $json;
    }

    public function getData()
    {
        $data = $this->data;
        if (!$this->isValidate($data['email'], $data['name'], $data['comment'])) {
            throw new UnexpectedValueException('Форма не прошла Валидацию');
        }
        return $data;
    }

    private function isValidate(string $email, string $name, string $comment): bool
    {
        return ValidatorForm::checkEmail($email) &&
            ValidatorForm::checkInputLength($name, 3) &&
            ValidatorForm::checkInputLength($comment, 4);
    }

    private function isAjax(): bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            (strtolower(getenv('HTTP_X_REQUESTED_WITH')) === 'xmlhttprequest'));
    }
}