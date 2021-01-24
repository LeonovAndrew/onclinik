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

class HousecallForm extends \CBitrixComponent implements Controllerable
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
                'text' => htmlspecialchars($data->text),
            );
            $arLoadAppArray = array(
                'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                'DATE_ACTIVE_FROM' => ConvertTimeStamp(time(), 'FULL'),
                'NAME' => 'Вызов от ' . date('d.m.Y H:i:s'),
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