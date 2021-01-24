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

class VacancyForm extends \CBitrixComponent implements Controllerable
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
    private function getVacancyInfo($id)
    {
        if (intval($id)) {
            return \Bitrix\Iblock\ElementTable::getList(
                array(
                    'select' => array(
                        'ID',
                        'NAME',
                    ),
                    'filter' => array(
                        'IBLOCK_ID' => Vacancy::getIBlockId(),
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
        //   $errorCollection->setError(new Error(getMessage('captcha_error')));
        //}
        if (!$data->agreement) {
            $errorCollection->setError(new Error(getMessage('accept_personal_agreement')));
        }
        if (!$this->isCorrectString($data->name, 1)) {
            $errorCollection->setError(new Error(getMessage('wrong_name'), 0, ['field_name' => 'name']));
        }
        if (!$this->isCorrectPhone($data->phone)) {
            $errorCollection->setError(new Error(getMessage('wrong_phone'), 0, ['field_name' => 'phone']));
        }
        if (!empty($data->email) && !$this->isCorrectEmail($data->email)) {
            $errorCollection->setError(new Error(getMessage('wrong_email'), 0, ['field_name' => 'email']));
        }
        if (empty($_FILES['file']) || $_FILES['file']['error'] != 0) {
            $errorCollection->setError(new Error(getMessage('no_file'), 0, ['field_name' => 'file']));
        }

        return $errorCollection;
    }

    /**
     * @param array $arParams File params
     * @return int File id
     */
    private function saveFile($arParams)
    {
        $fileId = CFile::SaveFile(
            array(
                'name' => $arParams['name'],
                'size' => $arParams['size'],
                'tmp_name' => $arParams['tmp_name'],
                'type' => $arParams['type'],
            ),
            'resume'
        );

        return intVal($fileId);
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
                'text' => htmlspecialchars($data->text),
                'resume' => CFile::getPath($data->fileId),
            );
            $arLoadAppArray = array(
                'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
                'DATE_ACTIVE_FROM' => ConvertTimeStamp(time(), 'FULL'),
                'NAME' => 'Отклик от ' . date('d.m.Y H:i:s'),
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
                'vacancy' => $data->vacancyInfo['NAME'],
				'vacancy_name' => $data->vacancyInfo['NAME'],
                'email' => htmlspecialchars($data->email),
                'text' => htmlspecialchars($data->text),
            );
            if (!empty($this->arParams['EVENT_MESSAGE_ID'])) {
                foreach($this->arParams['EVENT_MESSAGE_ID'] as $val) {
                    $eventMsgId = intVal($val);
                    if ($eventMsgId > 0) {
						if ($eventMsgId == 102) {
							$eventId = CEvent::Send($this->arParams['EVENT_NAME'], SITE_ID, $arFields, "Y", $eventMsgId, Array($data->fileId));
						}
						else {
							$eventId = CEvent::Send($this->arParams['EVENT_NAME'], SITE_ID, $arFields, "N", $eventMsgId);
						}
				    }
                }
            } else {
                $eventId = CEvent::Send($this->arParams['EVENT_NAME'], SITE_ID, $arFields, "Y", "", Array($data->fileId));
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
        $data->vacancyInfo = $this->getVacancyInfo($data->vacancy);

        $errorCollection = $this->validate($data);

        if (!$errorCollection->isEmpty()) {
            return AjaxJson::createError($errorCollection);
        }

        $data->fileId = $this->saveFile($_FILES['file']);
        if (!$data->fileId) {
            $errorCollection->setError(new Error(getMessage('save_file_error')));

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