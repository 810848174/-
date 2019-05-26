<?php
require_once 'WxPay.Config.php'; require_once 'WxPay.Exception.php'; class WxPayDataBase { protected $values = array(); public function SetSign() { $sp1e1df1 = $this->MakeSign(); $this->values['sign'] = $sp1e1df1; return $sp1e1df1; } public function GetSign() { return $this->values['sign']; } public function IsSignSet() { return array_key_exists('sign', $this->values); } public function ToXml() { if (!is_array($this->values) || count($this->values) <= 0) { throw new WxPayException('数组数据异常！'); } $spa65db2 = '<xml>'; foreach ($this->values as $sp1e4b49 => $sp7a0550) { if (is_numeric($sp7a0550)) { $spa65db2 .= '<' . $sp1e4b49 . '>' . $sp7a0550 . '</' . $sp1e4b49 . '>'; } else { $spa65db2 .= '<' . $sp1e4b49 . '><![CDATA[' . $sp7a0550 . ']]></' . $sp1e4b49 . '>'; } } $spa65db2 .= '</xml>'; return $spa65db2; } public function FromXml($spa65db2) { if (!$spa65db2) { throw new WxPayException('xml数据异常！'); } libxml_disable_entity_loader(true); $this->values = json_decode(json_encode(simplexml_load_string($spa65db2, 'SimpleXMLElement', LIBXML_NOCDATA)), true); return $this->values; } public function ToUrlParams() { $sp10414e = ''; foreach ($this->values as $spc57c89 => $sp2a00a3) { if ($spc57c89 != 'sign' && $sp2a00a3 != '' && !is_array($sp2a00a3)) { $sp10414e .= $spc57c89 . '=' . $sp2a00a3 . '&'; } } $sp10414e = trim($sp10414e, '&'); return $sp10414e; } public function MakeSign() { ksort($this->values); $sp6dba13 = $this->ToUrlParams(); $sp6dba13 = $sp6dba13 . '&key=' . WxPayConfig::KEY; $sp6dba13 = md5($sp6dba13); $sp820aff = strtoupper($sp6dba13); return $sp820aff; } public function GetValues() { return $this->values; } } class WxPayResults extends WxPayDataBase { public function CheckSign() { if (!$this->IsSignSet()) { throw new WxPayException('签名错误！'); } $sp1e1df1 = $this->MakeSign(); if ($this->GetSign() == $sp1e1df1) { return true; } throw new WxPayException('签名错误！'); } public function FromArray($spfee848) { $this->values = $spfee848; } public static function InitFromArray($spfee848, $spcef1aa = false) { $sp1d6e9f = new self(); $sp1d6e9f->FromArray($spfee848); if ($spcef1aa == false) { $sp1d6e9f->CheckSign(); } return $sp1d6e9f; } public function SetData($sp1e4b49, $sp39a65f) { $this->values[$sp1e4b49] = $sp39a65f; } public static function Init($spa65db2) { $sp1d6e9f = new self(); $sp1d6e9f->FromXml($spa65db2); if ($sp1d6e9f->values['return_code'] != 'SUCCESS') { return $sp1d6e9f->GetValues(); } $sp1d6e9f->CheckSign(); return $sp1d6e9f->GetValues(); } } class WxPayNotifyReply extends WxPayDataBase { public function SetReturn_code($sp8cea05) { $this->values['return_code'] = $sp8cea05; } public function GetReturn_code() { return $this->values['return_code']; } public function SetReturn_msg($sp38dbc5) { $this->values['return_msg'] = $sp38dbc5; } public function GetReturn_msg() { return $this->values['return_msg']; } public function SetData($sp1e4b49, $sp39a65f) { $this->values[$sp1e4b49] = $sp39a65f; } } class WxPayUnifiedOrder extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetDevice_info($sp39a65f) { $this->values['device_info'] = $sp39a65f; } public function GetDevice_info() { return $this->values['device_info']; } public function IsDevice_infoSet() { return array_key_exists('device_info', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } public function SetBody($sp39a65f) { $this->values['body'] = $sp39a65f; } public function GetBody() { return $this->values['body']; } public function IsBodySet() { return array_key_exists('body', $this->values); } public function SetDetail($sp39a65f) { $this->values['detail'] = $sp39a65f; } public function GetDetail() { return $this->values['detail']; } public function IsDetailSet() { return array_key_exists('detail', $this->values); } public function SetAttach($sp39a65f) { $this->values['attach'] = $sp39a65f; } public function GetAttach() { return $this->values['attach']; } public function IsAttachSet() { return array_key_exists('attach', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetFee_type($sp39a65f) { $this->values['fee_type'] = $sp39a65f; } public function GetFee_type() { return $this->values['fee_type']; } public function IsFee_typeSet() { return array_key_exists('fee_type', $this->values); } public function SetTotal_fee($sp39a65f) { $this->values['total_fee'] = $sp39a65f; } public function GetTotal_fee() { return $this->values['total_fee']; } public function IsTotal_feeSet() { return array_key_exists('total_fee', $this->values); } public function SetSpbill_create_ip($sp39a65f) { $this->values['spbill_create_ip'] = $sp39a65f; } public function GetSpbill_create_ip() { return $this->values['spbill_create_ip']; } public function IsSpbill_create_ipSet() { return array_key_exists('spbill_create_ip', $this->values); } public function SetTime_start($sp39a65f) { $this->values['time_start'] = $sp39a65f; } public function GetTime_start() { return $this->values['time_start']; } public function IsTime_startSet() { return array_key_exists('time_start', $this->values); } public function SetTime_expire($sp39a65f) { $this->values['time_expire'] = $sp39a65f; } public function GetTime_expire() { return $this->values['time_expire']; } public function IsTime_expireSet() { return array_key_exists('time_expire', $this->values); } public function SetGoods_tag($sp39a65f) { $this->values['goods_tag'] = $sp39a65f; } public function GetGoods_tag() { return $this->values['goods_tag']; } public function IsGoods_tagSet() { return array_key_exists('goods_tag', $this->values); } public function SetNotify_url($sp39a65f) { $this->values['notify_url'] = $sp39a65f; } public function GetNotify_url() { return $this->values['notify_url']; } public function IsNotify_urlSet() { return array_key_exists('notify_url', $this->values); } public function SetTrade_type($sp39a65f) { $this->values['trade_type'] = $sp39a65f; } public function GetTrade_type() { return $this->values['trade_type']; } public function IsTrade_typeSet() { return array_key_exists('trade_type', $this->values); } public function SetProduct_id($sp39a65f) { $this->values['product_id'] = $sp39a65f; } public function GetProduct_id() { return $this->values['product_id']; } public function IsProduct_idSet() { return array_key_exists('product_id', $this->values); } public function SetOpenid($sp39a65f) { $this->values['openid'] = $sp39a65f; } public function GetOpenid() { return $this->values['openid']; } public function IsOpenidSet() { return array_key_exists('openid', $this->values); } public function SetScene_info($sp39a65f) { $this->values['scene_info'] = $sp39a65f; } public function IsScene_info() { return array_key_exists('scene_info', $this->values); } } class WxPayOrderQuery extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetTransaction_id($sp39a65f) { $this->values['transaction_id'] = $sp39a65f; } public function GetTransaction_id() { return $this->values['transaction_id']; } public function IsTransaction_idSet() { return array_key_exists('transaction_id', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } } class WxPayCloseOrder extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } } class WxPayRefund extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetDevice_info($sp39a65f) { $this->values['device_info'] = $sp39a65f; } public function GetDevice_info() { return $this->values['device_info']; } public function IsDevice_infoSet() { return array_key_exists('device_info', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } public function SetTransaction_id($sp39a65f) { $this->values['transaction_id'] = $sp39a65f; } public function GetTransaction_id() { return $this->values['transaction_id']; } public function IsTransaction_idSet() { return array_key_exists('transaction_id', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetOut_refund_no($sp39a65f) { $this->values['out_refund_no'] = $sp39a65f; } public function GetOut_refund_no() { return $this->values['out_refund_no']; } public function IsOut_refund_noSet() { return array_key_exists('out_refund_no', $this->values); } public function SetTotal_fee($sp39a65f) { $this->values['total_fee'] = $sp39a65f; } public function GetTotal_fee() { return $this->values['total_fee']; } public function IsTotal_feeSet() { return array_key_exists('total_fee', $this->values); } public function SetRefund_fee($sp39a65f) { $this->values['refund_fee'] = $sp39a65f; } public function GetRefund_fee() { return $this->values['refund_fee']; } public function IsRefund_feeSet() { return array_key_exists('refund_fee', $this->values); } public function SetRefund_fee_type($sp39a65f) { $this->values['refund_fee_type'] = $sp39a65f; } public function GetRefund_fee_type() { return $this->values['refund_fee_type']; } public function IsRefund_fee_typeSet() { return array_key_exists('refund_fee_type', $this->values); } public function SetOp_user_id($sp39a65f) { $this->values['op_user_id'] = $sp39a65f; } public function GetOp_user_id() { return $this->values['op_user_id']; } public function IsOp_user_idSet() { return array_key_exists('op_user_id', $this->values); } } class WxPayRefundQuery extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetDevice_info($sp39a65f) { $this->values['device_info'] = $sp39a65f; } public function GetDevice_info() { return $this->values['device_info']; } public function IsDevice_infoSet() { return array_key_exists('device_info', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } public function SetTransaction_id($sp39a65f) { $this->values['transaction_id'] = $sp39a65f; } public function GetTransaction_id() { return $this->values['transaction_id']; } public function IsTransaction_idSet() { return array_key_exists('transaction_id', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetOut_refund_no($sp39a65f) { $this->values['out_refund_no'] = $sp39a65f; } public function GetOut_refund_no() { return $this->values['out_refund_no']; } public function IsOut_refund_noSet() { return array_key_exists('out_refund_no', $this->values); } public function SetRefund_id($sp39a65f) { $this->values['refund_id'] = $sp39a65f; } public function GetRefund_id() { return $this->values['refund_id']; } public function IsRefund_idSet() { return array_key_exists('refund_id', $this->values); } } class WxPayDownloadBill extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetDevice_info($sp39a65f) { $this->values['device_info'] = $sp39a65f; } public function GetDevice_info() { return $this->values['device_info']; } public function IsDevice_infoSet() { return array_key_exists('device_info', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } public function SetBill_date($sp39a65f) { $this->values['bill_date'] = $sp39a65f; } public function GetBill_date() { return $this->values['bill_date']; } public function IsBill_dateSet() { return array_key_exists('bill_date', $this->values); } public function SetBill_type($sp39a65f) { $this->values['bill_type'] = $sp39a65f; } public function GetBill_type() { return $this->values['bill_type']; } public function IsBill_typeSet() { return array_key_exists('bill_type', $this->values); } } class WxPayReport extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetDevice_info($sp39a65f) { $this->values['device_info'] = $sp39a65f; } public function GetDevice_info() { return $this->values['device_info']; } public function IsDevice_infoSet() { return array_key_exists('device_info', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } public function SetInterface_url($sp39a65f) { $this->values['interface_url'] = $sp39a65f; } public function GetInterface_url() { return $this->values['interface_url']; } public function IsInterface_urlSet() { return array_key_exists('interface_url', $this->values); } public function SetExecute_time_($sp39a65f) { $this->values['execute_time_'] = $sp39a65f; } public function GetExecute_time_() { return $this->values['execute_time_']; } public function IsExecute_time_Set() { return array_key_exists('execute_time_', $this->values); } public function SetReturn_code($sp39a65f) { $this->values['return_code'] = $sp39a65f; } public function GetReturn_code() { return $this->values['return_code']; } public function IsReturn_codeSet() { return array_key_exists('return_code', $this->values); } public function SetReturn_msg($sp39a65f) { $this->values['return_msg'] = $sp39a65f; } public function GetReturn_msg() { return $this->values['return_msg']; } public function IsReturn_msgSet() { return array_key_exists('return_msg', $this->values); } public function SetResult_code($sp39a65f) { $this->values['result_code'] = $sp39a65f; } public function GetResult_code() { return $this->values['result_code']; } public function IsResult_codeSet() { return array_key_exists('result_code', $this->values); } public function SetErr_code($sp39a65f) { $this->values['err_code'] = $sp39a65f; } public function GetErr_code() { return $this->values['err_code']; } public function IsErr_codeSet() { return array_key_exists('err_code', $this->values); } public function SetErr_code_des($sp39a65f) { $this->values['err_code_des'] = $sp39a65f; } public function GetErr_code_des() { return $this->values['err_code_des']; } public function IsErr_code_desSet() { return array_key_exists('err_code_des', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetUser_ip($sp39a65f) { $this->values['user_ip'] = $sp39a65f; } public function GetUser_ip() { return $this->values['user_ip']; } public function IsUser_ipSet() { return array_key_exists('user_ip', $this->values); } public function SetTime($sp39a65f) { $this->values['time'] = $sp39a65f; } public function GetTime() { return $this->values['time']; } public function IsTimeSet() { return array_key_exists('time', $this->values); } } class WxPayShortUrl extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetLong_url($sp39a65f) { $this->values['long_url'] = $sp39a65f; } public function GetLong_url() { return $this->values['long_url']; } public function IsLong_urlSet() { return array_key_exists('long_url', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } } class WxPayMicroPay extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetDevice_info($sp39a65f) { $this->values['device_info'] = $sp39a65f; } public function GetDevice_info() { return $this->values['device_info']; } public function IsDevice_infoSet() { return array_key_exists('device_info', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } public function SetBody($sp39a65f) { $this->values['body'] = $sp39a65f; } public function GetBody() { return $this->values['body']; } public function IsBodySet() { return array_key_exists('body', $this->values); } public function SetDetail($sp39a65f) { $this->values['detail'] = $sp39a65f; } public function GetDetail() { return $this->values['detail']; } public function IsDetailSet() { return array_key_exists('detail', $this->values); } public function SetAttach($sp39a65f) { $this->values['attach'] = $sp39a65f; } public function GetAttach() { return $this->values['attach']; } public function IsAttachSet() { return array_key_exists('attach', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetTotal_fee($sp39a65f) { $this->values['total_fee'] = $sp39a65f; } public function GetTotal_fee() { return $this->values['total_fee']; } public function IsTotal_feeSet() { return array_key_exists('total_fee', $this->values); } public function SetFee_type($sp39a65f) { $this->values['fee_type'] = $sp39a65f; } public function GetFee_type() { return $this->values['fee_type']; } public function IsFee_typeSet() { return array_key_exists('fee_type', $this->values); } public function SetSpbill_create_ip($sp39a65f) { $this->values['spbill_create_ip'] = $sp39a65f; } public function GetSpbill_create_ip() { return $this->values['spbill_create_ip']; } public function IsSpbill_create_ipSet() { return array_key_exists('spbill_create_ip', $this->values); } public function SetTime_start($sp39a65f) { $this->values['time_start'] = $sp39a65f; } public function GetTime_start() { return $this->values['time_start']; } public function IsTime_startSet() { return array_key_exists('time_start', $this->values); } public function SetTime_expire($sp39a65f) { $this->values['time_expire'] = $sp39a65f; } public function GetTime_expire() { return $this->values['time_expire']; } public function IsTime_expireSet() { return array_key_exists('time_expire', $this->values); } public function SetGoods_tag($sp39a65f) { $this->values['goods_tag'] = $sp39a65f; } public function GetGoods_tag() { return $this->values['goods_tag']; } public function IsGoods_tagSet() { return array_key_exists('goods_tag', $this->values); } public function SetAuth_code($sp39a65f) { $this->values['auth_code'] = $sp39a65f; } public function GetAuth_code() { return $this->values['auth_code']; } public function IsAuth_codeSet() { return array_key_exists('auth_code', $this->values); } } class WxPayReverse extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetTransaction_id($sp39a65f) { $this->values['transaction_id'] = $sp39a65f; } public function GetTransaction_id() { return $this->values['transaction_id']; } public function IsTransaction_idSet() { return array_key_exists('transaction_id', $this->values); } public function SetOut_trade_no($sp39a65f) { $this->values['out_trade_no'] = $sp39a65f; } public function GetOut_trade_no() { return $this->values['out_trade_no']; } public function IsOut_trade_noSet() { return array_key_exists('out_trade_no', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } } class WxPayJsApiPay extends WxPayDataBase { public function FromArray($spfee848) { $this->values = $spfee848; } public function SetAppid($sp39a65f) { $this->values['appId'] = $sp39a65f; } public function GetAppid() { return $this->values['appId']; } public function IsAppidSet() { return array_key_exists('appId', $this->values); } public function SetTimeStamp($sp39a65f) { $this->values['timeStamp'] = $sp39a65f; } public function GetTimeStamp() { return $this->values['timeStamp']; } public function IsTimeStampSet() { return array_key_exists('timeStamp', $this->values); } public function SetNonceStr($sp39a65f) { $this->values['nonceStr'] = $sp39a65f; } public function GetReturn_code() { return $this->values['nonceStr']; } public function IsReturn_codeSet() { return array_key_exists('nonceStr', $this->values); } public function SetPackage($sp39a65f) { $this->values['package'] = $sp39a65f; } public function GetPackage() { return $this->values['package']; } public function IsPackageSet() { return array_key_exists('package', $this->values); } public function SetSignType($sp39a65f) { $this->values['signType'] = $sp39a65f; } public function GetSignType() { return $this->values['signType']; } public function IsSignTypeSet() { return array_key_exists('signType', $this->values); } public function SetPaySign($sp39a65f) { $this->values['paySign'] = $sp39a65f; } public function GetPaySign() { return $this->values['paySign']; } public function IsPaySignSet() { return array_key_exists('paySign', $this->values); } } class WxPayBizPayUrl extends WxPayDataBase { public function SetAppid($sp39a65f) { $this->values['appid'] = $sp39a65f; } public function GetAppid() { return $this->values['appid']; } public function IsAppidSet() { return array_key_exists('appid', $this->values); } public function SetMch_id($sp39a65f) { $this->values['mch_id'] = $sp39a65f; } public function GetMch_id() { return $this->values['mch_id']; } public function IsMch_idSet() { return array_key_exists('mch_id', $this->values); } public function SetTime_stamp($sp39a65f) { $this->values['time_stamp'] = $sp39a65f; } public function GetTime_stamp() { return $this->values['time_stamp']; } public function IsTime_stampSet() { return array_key_exists('time_stamp', $this->values); } public function SetNonce_str($sp39a65f) { $this->values['nonce_str'] = $sp39a65f; } public function GetNonce_str() { return $this->values['nonce_str']; } public function IsNonce_strSet() { return array_key_exists('nonce_str', $this->values); } public function SetProduct_id($sp39a65f) { $this->values['product_id'] = $sp39a65f; } public function GetProduct_id() { return $this->values['product_id']; } public function IsProduct_idSet() { return array_key_exists('product_id', $this->values); } }