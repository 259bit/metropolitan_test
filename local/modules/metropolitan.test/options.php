<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Context;

require_once(__DIR__ . "/include/defines.php");

global $USER,
       $APPLICATION;

if (!$USER->IsAdmin()) {
    return;
}

$request = Context::getCurrent()->getRequest();

$arTabs = [
    [
        'DIV' => 'main_options',
        'TAB' => Loc::getMessage('METROPOLITAN_TEST_MODULE_TAB_MAIN'),
        'OPTIONS' => [
            Loc::getMessage('METROPOLITAN_TEST_MODULE_TAB_MAIN_SECTION'),
            [
                'MPD_JSON_URL',
                Loc::getMessage('METROPOLITAN_TEST_MODULE_URL_JSON'),
                null,
                ['text', 52],
            ],
        ]
    ]
];

if ($request->isPost() && strlen($request->getPost('save')) > 0 && check_bitrix_sessid()) {
    foreach ($arTabs as $arTab) {
        __AdmSettingsSaveOptions(METROPOLITAN_TEST_MODULE_ID, $arTab['OPTIONS']);
    }

    LocalRedirect($APPLICATION->GetCurPage() . '?lang=' . LANGUAGE_ID . '&mid=' . urlencode(METROPOLITAN_TEST_MODULE_ID) .
        '&tabControl_active_tab=' . urlencode($_REQUEST['tabControl_active_tab']) . '&sid=' . urlencode(SITE_ID));
}

$tabControl = new CAdminTabControl('tabControl', $arTabs);
?>

<form method='post' action='' name='bootstrap'>
    <?php
    $tabControl->Begin();

    foreach ($arTabs as $arTab) {
        $tabControl->BeginNextTab();
        __AdmSettingsDrawList(METROPOLITAN_TEST_MODULE_ID, $arTab['OPTIONS']);
    }

    $tabControl->Buttons([
        'btnApply' => false,
        'btnCancel' => false,
        'btnSaveAndAdd' => false,
    ]);
    ?>

    <?= bitrix_sessid_post(); ?>
    <?php $tabControl->End(); ?>
</form>