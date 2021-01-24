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
    Bitrix\Main\Loader,
    CEvent,
    CIBlockElement,
    CFile,
    CSubscription;

class SubscriptionForm extends \CBitrixComponent implements Controllerable
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
     * @param string $email
     * @return bool
     */
    private function isCorrectEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    /**
     * @param $email
     * @return bool
     */
    private function isAvailableEmail($email)
    {
        Loader::includeModule('subscribe');

        $arSubscr = CSubscription::getByEmail($email)->fetch();

        return $arSubscr ? false : true;
    }

    /**
     * @param $email
     * @return ErrorCollection
     */
    private function subscribe($email)
    {
        $errorCollection = new ErrorCollection();
        if (!$this->isAvailableEmail($email)) {
            $errorCollection->setError(new Error(getMessage('email_used'), 0, ['field_name' => 'email']));
        } else {
            Loader::includeModule('subscribe');

            $arFields = Array(
                'EMAIL' => $email,
                'ACTIVE' => 'Y',
            );
            $subscr = new CSubscription();
            $id = $subscr->Add($arFields);
            if (!$id) {
                $errorCollection->setError(new Error(strip_tags($subscr->LAST_ERROR)));
            }
        }

        return $errorCollection;
    }

    /**
     * @param object $data
     * @return ErrorCollection
     */
    private function validate($data)
    {
        $errorCollection = new ErrorCollection();

        if (!$data->agreement) {
            $errorCollection->setError(new Error(getMessage('accept_personal_agreement')));
        }
        if (!$this->isCorrectEmail($data->email)) {
            $errorCollection->setError(new Error(getMessage('wrong_email'), 0, ['field_name' => 'email']));
        }

        return $errorCollection;
    }

    /**
     * @param string $json
     * @return mixed
     */
    public function subscribeAction($json)
    {
        $data = json_decode($json);

        $errorCollection = $this->validate($data);
        if (!$errorCollection->isEmpty()) {
            return AjaxJson::createError($errorCollection);
        }

        $errorCollection = $this->subscribe($data->email);
        if (!$errorCollection->isEmpty()) {
            return AjaxJson::createError($errorCollection);
        }

        return AjaxJson::createSuccess(
            array(
                'message' => $this->arParams['SUCCESS_MSG'],
            )
        );
    }
}