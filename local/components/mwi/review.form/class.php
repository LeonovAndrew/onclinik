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
    Bitrix\Main\Application,
    CEvent,
    CIBlockElement,
    CFile;

class ReviewForm extends \CBitrixComponent implements Controllerable
{
    function executeComponent()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $this->arResult['doctor'] = htmlspecialchars($request->getQueryList()->getRaw('nameDoctor'));

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
     * @param int $id
     * @return bool
     */
    private function isCorrectDirection($id)
    {
        if ($id) {
            $direction = new Direction($id);
            $direction->makeData();

            return $direction->name ? true : false;
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool
     */
    private function isCorrectClinic($id)
    {
        if ($id) {
            $clinic = new Clinic($id);
            $clinic->makeData();

            return $clinic->name ? true : false;
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
        $data->clinicId = $this->isCorrectClinic(intVal($data->clinicId)) ? $data->clinicId : 0;
        $data->doctorId = Personal::getByName($data->doctorName);

        if (!$data->agreement) {
            $errorCollection->setError(new Error(getMessage('accept_personal_agreement')));
        }
        if (!$data->accommodation) {
            $errorCollection->setError(new Error(getMessage('accept_accommodation_agreement')));
        }
        if (!$this->isCorrectName($data->name)) {
            $errorCollection->setError(new Error(getMessage('wrong_name'), 0, ['field_name' => 'name']));
        }
        if (!$this->isCorrectPhone($data->phone)) {
            $errorCollection->setError(new Error(getMessage('wrong_phone'), 0, ['field_name' => 'phone']));
        }
        if (!$this->isCorrectEmail($data->email)) {
            $errorCollection->setError(new Error(getMessage('wrong_email'), 0, ['field_name' => 'email']));
        }
        if (!$this->isCorrectString($data->text, 2)) {
            $errorCollection->setError(new Error(getMessage('wrong_text'), 0, ['field_name' => 'text']));
        }
        if (!empty($data->directionId) && !$this->isCorrectDirection(intVal($data->directionId))) {
            $errorCollection->setError(new Error(getMessage('wrong_direction'), 0, ['field_name' => 'direction', 'neighbour_selector' => '.jq-selectbox__select']));
        }
        if (!$data->clinicId && (!$data->doctorId || !empty($data->clinicId))) {
            $errorCollection->setError(new Error(getMessage('wrong_clinic'), 0, ['field_name' => 'clinic', 'neighbour_selector' => '.jq-selectbox__select']));
        }
        if (!$data->doctorId && (!$data->clinicId || !empty($data->doctorname))) {
            $errorCollection->setError(new Error(getMessage('wrong_doctor'), 0, ['field_name' => 'nameDoctor']));
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
			
			
			
			

            $arProps = [
                'PATIENT_NAME'  => htmlspecialchars($data->name),
                'PHONE' => htmlspecialchars($data->phone),
                'EMAIL' => htmlspecialchars($data->email),
				'CLINIC' => $data->clinicId,
				'DIRECTION' => $data->directionId,
				'DOCTOR_NAME' => $data->doctorName
            ];
            $arLoadAppArray = [
                'IBLOCK_ID'        => $this->arParams['IBLOCK_ID'],
                'DATE_ACTIVE_FROM' => ConvertTimeStamp(time(), 'FULL'),
                'NAME'             => 'Отзыв от ' . date('d.m.Y H:i:s'),
                'ACTIVE'           => 'N',
				'DETAIL_TEXT' 	   => htmlspecialchars($data->text),
                'PROPERTY_VALUES'  => $arProps,
            ];

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
           
			if ( $data->directionId ){
				$direction = new Direction( intVal($data->directionId) );
				$direction->makeData();
				$data->direction_name = $direction->name;
			}
            
			if ( $data->clinicId ){
				$clinic = new Clinic( $data->clinicId );
				$clinic->makeData();
				$data->clinic_name = $clinic->name;
			}

		   $arFields = [
                'name'   => htmlspecialchars($data->name),
                'phone'  => htmlspecialchars($data->phone),
                'email'  => htmlspecialchars($data->email),
                'review' => htmlspecialchars($data->text),
				'clinic_name' => $data->clinic_name,
				'direction_name' => $data->direction_name,
				'doctor_name' => $data->doctorName
            ];

            if (!empty($this->arParams['EVENT_MESSAGE_ID'])) {
                foreach ($this->arParams['EVENT_MESSAGE_ID'] as $val) {
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
            [
                'message' => $this->arParams['SUCCESS_MSG'],
            ]
        );
    }
}