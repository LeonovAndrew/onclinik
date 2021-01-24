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

class QuestionForm extends \CBitrixComponent implements Controllerable
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
     * @param string $string
     * @return bool
     */
    private function isCorrectName($string)
    {
        return $this->isCorrectString($string, 1) && !preg_match('/[^а-яА-ЯёЁa-zA-Z ]/u', $string);
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
     * @param int $id
     * @return bool
     */
    private function isCorrectDirection($id)
    {
        if (intVal($id)) {
            $direction = new Direction($id);
            $direction->makeData();

            return $direction->name ? true : false;
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
        if (!$this->isCorrectName($data->name)) {
            $errorCollection->setError(new Error(getMessage('wrong_name'), 0, ['field_name' => 'name']));
        }
        if (!$this->isCorrectEmail($data->email)) {
            $errorCollection->setError(new Error(getMessage('wrong_email'), 0, ['field_name' => 'email']));
        }
        if (!$this->isCorrectString($data->text, 2)) {
            $errorCollection->setError(new Error(getMessage('wrong_text'), 0, ['field_name' => 'text']));
        }
        /*if (!$this->isCorrectDirection($data->directionId)) {
            $errorCollection->setError(new Error(getMessage('wrong_direction'), 0, ['field_name' => 'direction', 'neighbour_selector' => '.jq-selectbox__select']));
        }*/

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
                'PATIENT_NAME' => htmlspecialchars($data->name),
                'email' => htmlspecialchars($data->email),
                'QUESTION' => htmlspecialchars($data->text),
				'DIRECTIONS' => $data->directionId
            );
            $arLoadAppArray = array(
                'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                'DATE_ACTIVE_FROM' => ConvertTimeStamp(time(), 'FULL'),
                'NAME' => 'Вопрос от ' . date('d.m.Y H:i:s'),
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
           
			$direction = new Direction($data->directionId);
			$direction->makeData();

		    $arFields = array(
                'name' => htmlspecialchars($data->name),
                'email' => htmlspecialchars($data->email),
                'text' => htmlspecialchars($data->text),
				'direction' => $direction->name
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