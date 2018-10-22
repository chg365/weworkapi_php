<?php

include_once(__DIR__."/../../utils/error.inc.php");
include_once(__DIR__."/../../utils/Utils.class.php");

class MailTips
{
    public $sendToAll = false; // bool, 是否全员发送, 即文档所谓 @all
    public $touser = null; // string array
    public $toparty = null; // uint array
    public $mailId = null; // string 邮件id
    public $subject = null; // string 邮件主题
    public $sender  = null; // string 发件人
    public $abstract = null; // string 摘要

	public function CheckTipsSendArgs()
    {
        if (count($this->touser) > 1000) throw new QyApiError("touser should be no more than 1000");
        if (count($this->toparty) > 100) throw new QyApiError("toparty should be no more than 100");

        if (is_null($this->mailId)) throw new QyApiError("mailId is empty");
        //if (is_null($this->subject)) throw new QyApiError("subject is empty");
    }

	public function Tips2Array()
    {
        $args = array();

        if (true == $this->sendToAll) {
		    Utils::setIfNotNull("@all", "touser", $args);
        } else {
            //
            $touser_string = null;
            foreach($this->touser as $item) {
                $touser_string = $touser_string . $item . "|";
            }
		    Utils::setIfNotNull($touser_string, "touser", $args);

            //
            $toparty_string = null;
            foreach($this->toparty as $item) {
                $toparty_string = $toparty_string . $item . "|";
            }
		    Utils::setIfNotNull($toparty_string, "toparty", $args);
        }

        Utils::setIfNotNull($this->subject, "subject", $args);
        Utils::setIfNotNull($this->sender, "sender", $args);
        Utils::setIfNotNull($this->mailId, "mailid", $args);
        Utils::setIfNotNull($this->abstract, "abstract", $args);

        return $args;
    }
}
