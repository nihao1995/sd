<?php 

/**
 * CURL方式的GET传值
 * @param  [type] $url  [GET传值的URL]
 * @return [type]       [description]
 */
function _crul_get($url){
	 $oCurl = curl_init();  
	 if(stripos($url,"https://")!==FALSE){  
		 curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);  
		 curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);  
		 curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1  
	 }  
	 curl_setopt($oCurl, CURLOPT_URL, $url);  
	 curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1 );  
	 $sContent = curl_exec($oCurl);  
	 $aStatus = curl_getinfo($oCurl);  
	 curl_close($oCurl);  
	 if(intval($aStatus["http_code"])==200){  
		 return $sContent;  
	 }else{  
		 return false;  
	 }  
}
function getPage($page, $pageSize,$arrayCount)
{
	$pagenums = $pageCount = ($arrayCount%$pageSize) == 0? ($arrayCount/$pageSize): (int)($arrayCount/$pageSize)+1;//总页数
	if($page > $pagenums)
		$page = 1;
	if($pagenums < 10)
	{
		$pageStart = 1;
	}
	elseif($page <5)
	{
		$pageStart = 1;
		$pagenums = 9;
	}
	elseif($pagenums-$page >=5)
	{
		$pageStart = $page-4;
		$pagenums = $page+4;
	}
	else
	{
		$pageStart = $pagenums - 8;
	}
	return array($page,$pagenums, $pageStart, $pageCount);
}




/**
 * CURL方式的POST传值
 * @param  [type] $url  [POST传值的URL]
 * @param  [type] $data [POST传值的参数]
 * @return [type]       [description]
 */
function _crul_post($url,$data){
    //初始化curl		
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    //post提交方式
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //运行curl
    $result = curl_exec($curl);

    //返回结果	    
    if (curl_errno($curl)) {
       return 'Errno'.curl_error($curl);
    }
    curl_close($curl);
    return $result;
}


 ?>