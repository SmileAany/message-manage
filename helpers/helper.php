<?php

if(!function_exists('custom_array_key')){
    /**
     * @describe
     * 判断数组中，是否包含指定的字段
     * @param array $array
     * @param string $string
     * @param bool $status
     * @return bool
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-10-21 9:43
     */
    function custom_array_key(array $array,string $string,bool $status = FALSE){
        if(!empty($array) && !empty($string)){
            $keys = explode(",",$string);

            if($status){
                foreach($keys as $val){
                    if(!isset($array[$val]) || empty($array[$val])){
                        return false;
                    }
                }
            }else{
                foreach($keys as $val){
                    if(!isset($array[$val])){
                        return false;
                    }
                }
            }
            return true;
        }
    }
}

if(!function_exists('custom_array_wechat')){
    /** 组装微信模板消息数据格式
     * @param array $data
     * @param string $column1
     * @param string $column2
     * @param string $column3
     * @return array
     * @throws Exception
     */
    function custom_array_wechat(array $data,string $column1,string $column2,string $column3):array{
        if(!empty($data) && !empty($column1) && !empty($column2) && !empty($column3)){
            $array=[];
            $current_val= current($data);
            $end_val    = end($data);
            foreach($data as $val){
                static $count=1;
                if($val===$current_val){
                    $key=$column1;
                }else{
                    if($val===$end_val){
                        $key=$column3;
                    }else{
                        $key=$column2.$count;
                        $count++;
                    }
                }
                $array[$key]=$val;
            }
            return $array;
        }
    }
}