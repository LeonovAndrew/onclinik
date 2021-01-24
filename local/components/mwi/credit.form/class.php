<?php
namespace MWI;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Engine\Contract\Controllerable,
    Bitrix\Main\Engine\ActionFilter,
    Bitrix\Main\Engine\Response\AjaxJson,
    Bitrix\Main\Error,
    Bitrix\Main\ErrorCollection,
    CEvent,
    CIBlockElement,
    CFile;

class CreditForm extends \CBitrixComponent implements Controllerable
{
    function executeComponent()
    {
        $this->includeComponentTemplate();
    }

    /**
     * @return array
     */
    protected function listKeysSignedParameters()
    {
        return [
            'IBLOCK_ID',
            'EVENT_MESSAGE_ID',
            'EVENT_NAME',
            'SUCCESS_MSG',
        ];
    }

    /**
     * @return array
     */
    public function configureActions()
    {
        return [
            'sendMessage' => [
                '+prefilters' => [
                    new ActionFilter\HttpMethod(
                        [
                            ActionFilter\HttpMethod::METHOD_POST,
                        ]
                    ),
                    new ActionFilter\Csrf(),
                ],
                '-prefilters' => [
                    ActionFilter\Authentication::class,
                ],
                'postfilters' => [],
            ],
        ];
    }

    /**
     * @param string $string
     * @param int $minLength
     * @return bool
     */
    private function isCorrectString($string, $minLength = 0)
    {
        return strlen($string) >= $minLength;
    }

    /**
     * @param string $phone
     * @return bool
     */
    private function isCorrectPhone($phone)
    {
        return isCorrectPhone($phone);
    }

    /**
     * @param string $email
     * @return bool
     */
    private function isCorrectEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getBankInfo($id)
    {
        if (intval($id)) {
            return \Bitrix\Iblock\ElementTable::getList(
                array(
                    'select' => array(
                        'ID',
                        'NAME',
                    ),
                    'filter' => array(
                        'IBLOCK_ID' => Bank::getIBlockId(),
                        'ID' => $id,
                    ),
                    'cache' => array(
                        'ttl' => 60,
                    )
                )
            )->fetch();
        }

        return false;
    }

    /**
     * @param object $data
     * @return ErrorCollection
     */
    private function validate($data)
    {
        $errorCollection = new ErrorCollection();

        //if (!isValidCaptcha($data->recaptcha)) {
        //    $errorCollection->setError(new Error(getMessage('captcha_error')));
        //}
        if (!$data->agreement) {
            $errorCollection->setError(new Error(getMessage('accept_personal_agreement')));
        }
        if (!$this->isCorrectString($data->name, 1)) {
            $errorCollection->setError(new Error(getMessage('wrong_name'), 0, ['field_name' => 'name']));
        }
        if (empty($data->phone) || !$this->isCorrectPhone($data->phone)) {
            $errorCollection->setError(new Error(getMessage('wrong_phone'), 0, ['field_name' => 'phone']));
        }
        if (empty($data->email) || !$this->isCorrectEmail($data->email)) {
            $errorCollection->setError(new Error(getMessage('wrong_email'), 0, ['field_name' => 'email']));
        }
        if (!$data->bankInfo) {
            $errorCollection->setError(new Error(getMessage('wrong_bank')));
        }

        return $errorCollection;
    }

    /**
     * @param object $data
     * @return bool
     */
    private function saveApp($data)
    {
        $appId = 0;

        if (!empty($this->arParams['IBLOCK_ID'])) {
            $app = new CIBlockElement;

            $arProps = array(
                'name' => htmlspecialchars($data->name),
                'phone' => htmlspecialchars($data->phone),
                'email' => htmlspecialchars($data->email),
                'bank' => htmlspecialchars($data->bank),
            );
            $arLoadAppArray = array(
                'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                'DATE_ACTIVE_FROM' => ConvertTimeStamp(time(), 'FULL'),
                'NAME' => 'Заявка от ' . date('d.m.Y H:i:s'),
                'ACTIVE' => 'N',
                'PROPERTY_VALUES' => $arProps,
            );

            $appId = $app->add($arLoadAppArray);
        }

        return $appId ? true : false;
    }

    /**
     * @param object $data
     * @return bool
     */
    private function sendMessage($data)
    {
        $eventId = 0;

        if (!empty($this->arParams['EVENT_NAME']) || !empty($this->arParams['EVENT_MESSAGE_ID'])) {
            $arFields = array(
                'name' => htmlspecialchars($data->name),
                'bank' => $data->bankInfo['NAME'],
                'phone' => htmlspecialchars($data->phone),
                'email' => htmlspecialchars($data->email),
                'text' => htmlspecialchars($data->text),
            );
            if (!empty($this->arParams['EVENT_MESSAGE_ID'])) {
                foreach($this->arParams['EVENT_MESSAGE_ID'] as $val) {
                    $eventMsgId = intVal($val);
                    if ($eventMsgId > 0) {
                        $eventId = CEvent::Send($this->arParams['EVENT_NAME'], SITE_ID, $arFields, 'N', $eventMsgId);
                    }
                }
            } else {
                $eventId = CEvent::Send($this->arParams['EVENT_NAME'], SITE_ID, $arFields);
            }
        }

        return $eventId ? true : false;
    }

    /**
     * @param string $json
     * @return mixed
     */
    public function sendMessageAction($json)
    {
        $data = json_decode($json);
        $data->bankInfo = $this->getBankInfo($data->bank);

        $errorCollection = $this->validate($data);

        if (!$errorCollection->isEmpty()) {
            return AjaxJson::createError($errorCollection);
        }

        $this->sendMessage($data);
        $this->saveApp($data);

        /*if (!$this->sendMessage($data)) {
            $errorCollection->setError(new Error(getMessage('send_error')));

            return AjaxJson::createError($errorCollection);
        }*/

        /*if (!$this->saveApp($data)) {
            $errorCollection->setError(new Error(getMessage('save_error')));

            return AjaxJson::createError($errorCollection);
        }*/

        return AjaxJson::createSuccess(
            array(
                'message' => $this->arParams['SUCCESS_MSG'],
            )
        );
    }
}