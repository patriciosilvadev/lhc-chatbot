<?php

try {

    $chat =  erLhcoreClassModelChat::fetch($Params['user_parameters']['id']);

    if ($chat instanceof erLhcoreClassModelChat) {

        if (isset($_POST['answer'])) {
            $answer = $_POST['answer'];
        } else {
            throw new Exception('Answer not provided!');
        }

        if (isset($_POST['question'])) {
            $question = $_POST['question'];
        } else {
            throw new Exception('Question not provided!');
        }

        $invalid = erLhcoreClassModelLHCChatBotInvalid::findOne(array('filter' => array(
            'question' => $question,
            'answer' => $answer,
        )));

        if ($invalid instanceof erLhcoreClassModelLHCChatBotInvalid) {
            $invalid->counter++;
            $invalid->saveThis();
        } else {
            $invalid = new erLhcoreClassModelLHCChatBotInvalid();
            $invalid->counter = 1;
            $invalid->question = $question;
            $invalid->answer = $answer;
            $invalid->saveThis();
        }

        echo json_encode(array('error' => false,'msg' => 'Invalid counter was updated!'));

    } else {
        throw new Exception('Chat not found!');
    }

} catch (Exception $e) {
    echo json_encode(array('error' => true, 'msg' => $e->getMessage()));
}

exit;

?>