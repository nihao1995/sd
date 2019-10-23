<?php
return array(

//==================================== 接口配置
//******阿里云短信接口密钥-通过300c进行获取*******
    'alisms_off'=>'0',	//是否开启阿里云短信接口（0开启、1未开启）
    'alisms_uid'=>'19102234546535',
    'alisms_pid'=>'LTAINNjf3ubqn5cw',
    'alisms_passwd'=>'uLEHmWoH8RCnXKP9XLH9skE0qIfwVW',

//******邮箱接口密钥-通过300c进行获取*******
    'mail_off'=>'0',	//是否开启邮箱接口（0开启、1未开启）
    'mail_host'=>'smtp.exmail.qq.com',	//邮件服务器
    'mail_port'=>'465',	    //邮件发送端口
    'mail_secure'=>'ssl',	   //协议 ssl
    'mail_username'=>'admin@300c.cn',	    //验证用户名
    'mail_pwd'=>'ZHUOyuan123',	        //验证密码
    'mail_set_from'=>'admin@300c.cn',	   //发件人邮箱

//==================================== 接口配置
//******微信接口密钥*******

'wechat_off'=>0,	//是否开启微信登录（0开启、1未开启）
'wechat_kaifang'=>0,	//是否开启微信开放平台（0开启、1未开启）
'wechat_appid' => 'wx5b74a5c289a4b2a5',				//微信PE appid
'wechat_appsecret' => '8c73b91c2c927df3a02795d74e04264f',			//微信PE appsecret
'wechatpc_appid' => 'wx9787e16b5d857e68',				//微信PC appid
'wechatpc_appsecret' => 'c5700a92f641944b069c0a1b8ba07a12',			//微信PC appsecret
'wechatapp_appid' => 'wx6249224a649b236d',				//微信APP appid
'wechatapp_appsecret' => '565985ffd45f962f2fd505918111cb55',			//微信APP appsecret








// //******微信接口密钥*******
'wechatpay_off' => '0', //是否开启微信微信支付（0开启、1未开启）
'wechatpay_appid' => 'wxb5be9742ddc70bc5',              //微信PE appid
'wechatpay_appsecret' => '304f6891678370bb5fb4e4f69bcab5ac',            //微信PE appsecret
'wechatpay_mchid' => '1539282461',  //微信支付 商户号
'wechatpay_key' => 'eh4jaKajsfwdHPGqFnlAALAH7dnziGEA',  //微信支付 密钥

//******支付宝接口密钥*******
'alipay_off' => '0',    //是否开启支付宝支付（0开启、1未开启）
'alipay_appid' => '2019053165374799',   //应用ID,您的APPID。
'alipay_private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDrsIpqS3IHB2kFr9D70SWQpCWikYeq+rgahYBz40fMVnYxLXPdUAXrAS2hmgtx94O25E408zgZBojZRCgCqhaWOaWRKDh4KI63BuiNdOEZ4npTHXd2NuT8F+xdbEH+CKs3vqW13TdlqbaQ8aYyari/qu6isbzuT9FB/gChtitZFFfFeD65u753Rsm6GK+eSbsbRUMwv8X89c99zfn52j2zm4njxPIZuMq4J0CiXTKm6UZPN2dqLjFTiwO3/mUBXaqpv6djQIqHvxbGXPoHi+4ZRWR9vxSYjF92daksXICQLr2dm5o2XNTtNfqxx9A2A+qOm3Y8y5LzBZGxKZT2O0xfAgMBAAECggEAJNj26uNcsmigLLluDNCH9PMUxzPFaB/GhK72hCe2Y+XomIuon6MRKcqHXcp9m5W8y+0ppPGZhaAV6RHUx4Xb/iSJFAabvX1pwoeb9/Gb97YGtdPXh23RovACjiCMuLCWRCLUOXiaXpSH7GU7PIqe06hfoqPzC7cC2jRh2OZoJIbS27tGqNWx53TLg+FDsBTIXRZsN6ga9Fp77NvQh7ayEIgG60Cs7XC9UudxxWPNERYMsi0E7kzxtZ4XaKjt3O1glPB84RO55U78BfMjffdRvVWKNJkFOHa6b+XjVko2eVVtkur/bUoh8csR9Ug3zh204KCAdbTQjHLw3aEu2SksoQKBgQD2KHDyLEIFq5Rr84yIZIUZ51JVqhom7bpfh2/ZQZiA3STQD/xEf660QoMHXxKMx7U8A8dhFbk1/A8kyiDJrpOYuWrHkwLcCHuv+dhbH6Jy5dq477gFtHBa7nVNIbJCVQ+V4TWngp/vSGNRk9ul3yA6njxFK9Z4WUW7ACblEgJf6QKBgQD1HPNAQc+aYn2sQ0FCBrx5LfuXExtJf4fJIGZJzraGVslKj3vrKangABdW3+kX+5vVuEfrqZw1ZMfzWTG+jmxjIiAo4apkw7OAqQ9NrQa4ss9fZV7pRqcp5Mn15aXgZbL+84BshgaSsb1t5I0+a1bx5FgrKhxf4N7WbWYd6x4lBwKBgGgNikjkangpIlFLn1EcZKMhhE1P3UQtY4X0I1SMBOIcGO6Wg0WVT41FPEwGZTn7RWH8GvCwFR170g70Hk4CrMN3RWrdeuz17QrjKxDB25KEFSPtuTU4I/JcMFuNbePaPv9VNq/7aI3mZI1cWhHQsrf0oXd/42X2HqLAmrBkH3rZAoGAY8j9XlNsaLVf5BkdH/wODmch3Ubx/OHmLYL7IWD9/YKnP6taD0pO1dozpjJRemn77u2umcnaxgHZRMAy+BiTF2h1Hy9/ZrYlBWPNzxl5eweQVI24Lc+NjgiOD4UGGmxMim4nAgct9dpV+77noVmhc6g6HJhwJLgu/6xZviRRiVECgYEArnJrPJ4B52aBs4r4Kes344C7qO+pqzJVC5GNDEZZAOVfJ7SKR85dxeaYVwek5GeTWDaNM4Q74hOnX0zwJusCzpZ0eMlT7N7Sv8n76vveu7Ba/OQckjxKi9xrpZR4nc6BgaqIq3aoXm1Ypz4ZBRM+Z977GMZOWaQhmwn9rUvihPg=', //商户私钥，您的原始格式RSA私钥
'alipay_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjROBe6phH59H7EKH0n1bSzQLdMawQZJuAo5VLaQhEBTPCK6mdcMftL/caZH7YzSkedHitaD7UY/zk/Wg1z8kyHkDgVt7dYBPbKanWlu7BdV/vPZWIRfVr5CLTg5D8vazEXPdFOWpFEcPfXVBN22UZ2TxqvyooqCZQffF980dGnEeWAPkLTrjVlwQmx8K1lh5oVYeWW/vf0BfSDDcpPuBYyV3fxMp6nKXykx6G/iu6+dwJT2zC8CK9UWAdTTA+R168AezGdaS293SMAR9HBMvZAs1KCwZPRs7B6xhTHoVju30z7ZUm3TGd6maHUj3oBwoSDmge1fvatRGOvzasJX7NQIDAQAB',      //支付宝公钥
'alipay_gatewayUrl' => 'https://openapi.alipay.com/gateway.do',     //支付宝网关


//******支付回调接口*******
'alipay_yb_shopbuy'=>'1',   
'alipay_tb_shopbuy'=>'2',   
'alipay_yb_memberbuy'=>'3', 
'alipay_tb_memberbuy'=>'4', 
'wechatpay_yb_shopbuy'=>'5',    
'wechatpay_tb_shopbuy'=>'6',    
'wechatpay_yb_memberbuy'=>'7',  
'wechatpay_tb_memberbuy'=>'8',  




);
?>