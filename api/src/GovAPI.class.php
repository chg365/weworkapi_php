<?php
/*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File CorpAPI.class.php
 * @Brief : 为企业开放的接口
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */

include_once(__DIR__."./../../utils/Utils.class.php");
include_once(__DIR__."/../../utils/HttpUtils.class.php");
include_once(__DIR__."/../../utils/error.inc.php");

include_once(__DIR__."/CorpAPI.class.php");

include_once(__DIR__."/../datastructure/MailTips.class.php");

class GovAPI extends CorpAPI
{
    private $corpId = null;
    private $secret = null;
    protected $accessToken = null;

    const MAIL_SENDTIPS     = '/cgi-bin/mail/sendtips?access_token=ACCESS_TOKEN';

    //
    // --------------------------- 新邮件到达推送提醒 -----------------------------------
    //
    //
    /**
     * @brief MailSendtips: 发送提醒
     *
     * @link https://work.weixin.qq.com/api/doc#10167
     *
     * @param $tips: MailTips
     * @param $invalidUserIdList : string array
     * @param $invalidPartyIdList : uint array
     *
     * @return
     */
    public function MailSendTips(MailTips $mailTips, &$invalidUserIdList, &$invalidPartyIdList)
    {
        $mailTips->CheckTipsSendArgs();
        $args = $mailTips->Tips2Array();

        self::_HttpCall(self::MAIL_SENDTIPS, 'POST', $args);

        $invalidUserIdList_string = trim(utils::arrayGet($this->rspJson, "invaliduser"));
        if (strlen($invalidUserIdList_string) > 0) {
            $invalidUserIdList = explode('|', $invalidUserIdList_string);
        }

        $invalidPartyIdList_string = trim(utils::arrayGet($this->rspJson, "invalidparty"));
        if (strlen($invalidPartyIdList_string) > 0) {
            $temp = explode('|', $invalidPartyIdList_string);
            foreach($temp as $item) {
                $invalidPartyIdList[] = intval($item);
            }
        }
    }
}
