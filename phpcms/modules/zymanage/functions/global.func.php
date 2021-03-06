<?php

function returnWhereSQL($info, $tableString='B1.')
{
    $where = "1 ";
    foreach($info as $key=>$value)
    {
        if(strpos($key, "name"))
            $where .= " AND `".$key."` like '%".$value."%'";
        elseif($key == "start_addtime")
            $where .= "AND `addTime` > '$value'  ";
        elseif($key == "end_addtime")
            $where .= "AND `addTime` < '$value'  ";
        else
            $where .= "AND ".$tableString."`".$key."` = '$value'  ";
    }
    return $where;
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

?>
