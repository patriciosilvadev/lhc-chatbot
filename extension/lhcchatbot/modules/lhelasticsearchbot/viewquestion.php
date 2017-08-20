<?php

$tpl = erLhcoreClassTemplate::getInstance('elasticsearchbot/viewquestion.tpl.php');

$question =  erLhcoreClassModelESChatbotQuestion::fetch($Params['user_parameters']['id']);

if (ezcInputForm::hasPostData()) {

    if (isset($_POST['Cancel_action'])) {
        erLhcoreClassModule::redirect('lhcchatbot/list');
        exit ;
    }

    $Errors = erLhcoreClassExtensionLHCChatBotValidator::validate($question);

    if (count($Errors) == 0) {
        try {
            erLhcoreClassExtensionLHCChatBotValidator::publishQuestion($question);

            erLhcoreClassModule::redirect('lhcchatbot/list');
            exit;

        } catch (Exception $e) {
            $tpl->set('errors',array($e->getMessage()));
        }

    } else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->setArray(array(
    'question' => $question,
));

$sparams = array();
$sparams['body']['query']['bool']['must'][]['term']['question_id'] = $question->id;

$tpl->set('items', erLhcoreClassModelESChatbotAnswer::getList(array(
    'offset' => 0,
    'limit' => 100,
    'body' => array_merge(array(
        'sort' => array(
            'itime' => array(
                'order' => 'desc'
            )
        )
    ), $sparams['body'])
)));

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
    array (
        'url' =>erLhcoreClassDesign::baseurl('lhcchatbot/index'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('lhcchatbot/module','ChatBot')
    ),
    array (
        'url' =>erLhcoreClassDesign::baseurl('elasticsearchbot/list'),
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('lhcchatbot/module','Proposed questions')
    ),
    array (
        'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('lhcchatbot/module', 'Edit')
    )
);

?>