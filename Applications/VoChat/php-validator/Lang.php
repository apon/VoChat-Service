<?php

namespace Yunhack\PHPValidator;

class Lang
{
    private static $def_lang = [
        'present' => "The parameter '{parameter-name}' is not found!",
        'alpha' => "The parameter '{parameter-name}' is not a alpha",
        'num' => "The parameter '{parameter-name}' is not a number",
        'alpha_num' => "The parameter '{parameter-name}' is not made of number and alpha",
        'alpha_dish' => "The parameter '{parameter-name}' is not made of number,alpha,transverse line and underline",
        'var' => "The parameter '{parameter-name}' is not a valid variable name",
        'ip' => "The parameter '{parameter-name}' is not a valid IP address",
        'url' => "The parameter '{parameter-name}' is not a valid URL string",
        'email' => "The parameter '{parameter-name}' is not a valid E-mail address",
        'mobile' => "The parameter '{parameter-name}' is not a valid mobile",
        'json' => "The parameter '{parameter-name}' is not a valid Json string",
        'timestamp' => "The parameter '{parameter-name}' is not a valid timestamp",
        'date_format' => "The parameter '{parameter-name}' is not a valid date format",
        'regex' => "The parameter '{parameter-name}' does not conform to the regex expression",
        'string' => "The parameter '{parameter-name}' is not a type of string",
        'boolean' => "The parameter '{parameter-name}' is not a type of boolean",
        'integer' => "The parameter '{parameter-name}' is not a type of integer",
        'float' => "The parameter '{parameter-name}' is not a type of float",
        'array' => "The parameter '{parameter-name}' is not a type of array",
        'object' => "The parameter '{parameter-name}' is not a type of object",
        'object_of' => "The parameter '{parameter-name}' is not a '{bind-value_1}' object",
        'integer_str' => "The parameter '{parameter-name}' is not a valid integer string",
        'float_str' => "The parameter '{parameter-name}' is not a valid float string",
        'numeric_str' => "The parameter '{parameter-name}' is not a valid numeric string",
        'array_str' => "The parameter '{parameter-name}' is not a valid array string",
        'max' => "The parameter '{parameter-name}' value is too big",
        'length_max' => "The parameter '{parameter-name}' length is too long",
        'min' => "The parameter '{parameter-name}' value is too small",
        'length_min' => "The parameter '{parameter-name}' length is too short",
        'length' => "The parameter '{parameter-name}' length not is '{bind-value_1}'",
        'between' => "The parameter '{parameter-name}' value is not between '{bind-value_1}' and '{bind-value_2}'",
        'length_between' => "The parameter '{parameter-name}' length is not between '{bind-value_1}' and '{bind-value_2}'",
        'in' => "The parameter '{parameter-name}' value is not in '{bind-value_1}'",
        'not_in' => "The parameter '{parameter-name}' value is in '{bind-value_1}'",
        'filled' => "When the parameter '{parameter-name}' exists, the value cannot be empty",
        'distinct' => "In the array parameter '{parameter-name}',the same value exists",
        'different' => "The parameter '{parameter-name}' is not different of the parameter '{bind-value_1}'",
        'same' => "The parameter '{parameter-name}' is different of the parameter '{bind-value_1}'",
        'required_with' => "The parameter '{parameter-name}' is empty when the parameter '{bind-value_1}' is not empty",
        'required_with_all' => "The parameter '{parameter-name}' is empty",
        'required_without' => "The parameter '{parameter-name}' is empty when the parameter '{bind-value_1}' is empty",
        'required_without_all' => "The parameter '{parameter-name}' is empty",
        'file_exists' => "The file is not found",
        'file_type_in' => "The file's type is must be in {bind-value_1}",
        'file_max' => "The maximum size of the file is {bind-value_1}M",
        'file_min' => "The minimum size of the file is {bind-value_1}M",
        'file_size_between' => "Size of the file must between {bind-value_1}M and {bind-value_2}M",
    ];

    private static $zh_cn_lang = [
        'present' => "参数 '{parameter-name}' 不存在",
        'alpha' => "参数 '{parameter-name}' 不是全字母",
        'num' => "参数 '{parameter-name}' 不是全数字",
        'alpha_num' => "参数 '{parameter-name}' 不是由数字、字母组成",
        'alpha_dish' => "参数 '{parameter-name}' 不是由字母、数字、下划线和短横线组成",
        'var' => "参数 '{parameter-name}' 不是一个有效变量名",
        'ip' => "参数 '{parameter-name}' 不是合法的IP地址",
        'url' => "参数 '{parameter-name}' 不是合法的URL",
        'email' => "参数 '{parameter-name}' 不是合法的邮箱地址",
        'mobile' => "参数 '{parameter-name}' 不是合法的手机号",
        'json' => "参数 '{parameter-name}' 不是正确的JSON结构",
        'timestamp' => "参数 '{parameter-name}' 不是有效的时间戳",
        'date_format' => "参数 '{parameter-name}' 不是规范的日期格式，或日期已超出范围",
        'regex' => "参数 '{parameter-name}' 不符合正则表达式规则",
        'string' => "参数 '{parameter-name}' 不是字符串类型",
        'boolean' => "参数 '{parameter-name}' 不是布尔值类型",
        'integer' => "参数 '{parameter-name}' 不是整数类型",
        'float' => "参数 '{parameter-name}' 不是浮点数类型",
        'array' => "参数 '{parameter-name}' 不是数组类型",
        'object' => "参数 '{parameter-name}' 不是 ",
        'object_of' => "参数 '{parameter-name}' 不是 '{bind-value_1}' 对象类型",
        'integer_str' => "参数 '{parameter-name}' 不是有效的整数",
        'float_str' => "参数 '{parameter-name}' 不是有效的浮点数",
        'numeric_str' => "参数 '{parameter-name}' 不是有效的数字",
        'array_str' => "参数 '{parameter-name}' 不是有效的数组字符串",
        'max' => "参数 '{parameter-name}' 的值太大",
        'length_max' => "参数 '{parameter-name}' 的长度过长",
        'min' => "参数 '{parameter-name}' 的值太小",
        'length_min' => "参数 '{parameter-name}' 的长度过短",
        'length' => "参数 '{parameter-name}' 的长度不是 '{bind-value_1}'",
        'between' => "参数 '{parameter-name}' 的值不在 '{bind-value_1}' 和 '{bind-value_2}' 之间",
        'length_between' => "参数 '{parameter-name}' 的长度不在 '{bind-value_1}' 和 '{bind-value_2}' 之间",
        'in' => "参数 '{parameter-name}' 的值不在: '{bind-value_1}' 当中",
        'not_in' => "参数 '{parameter-name}' 的值在： '{bind-value_1}' 当中",
        'filled' => "当传入参数 '{parameter-name}' 时，其值不能为空",
        'distinct' => "在数组参数 '{parameter-name}' 中,存在重复的值",
        'different' => "参数 '{parameter-name}' 和参数 '{bind-value_1}' 一样",
        'same' => "参数 '{parameter-name}' 和参数 '{bind-value_1}' 不一样",
        'required_with' => "当参数 '{bind-value_1}' 不为空时，参数 '{parameter-name}' 不能为空",
        'required_with_all' => "参数 '{parameter-name}' 不能为空",
        'required_without' => "当参数 '{bind-value_1}' 为空时，参数 '{parameter-name}' 不能为空",
        'required_without_all' => "参数 '{parameter-name}' 不存在",
        'file_exists' => "指定的文件不存在",
        'file_type_in' => "文件的类型必须如下: {bind-value_1}",
        'file_max' => "文件大小最大为 {bind-value_1}M",
        'file_min' => "文件大小最小为 {bind-value_1}M",
        'file_size_between' => "文件大小只能在 {bind-value_1}M 和 {bind-value_2}M 之间",
    ];


    private static $lang = [];

    public static function lang($rule)
    {
        if (self::$lang == []) {
            self::initLangData();
        }
        return self::$lang[$rule];
    }

    private static function initLangData()
    {

//        self::$lang = self::$def_lang;
        self::$lang = self::$zh_cn_lang;
        return;

    }
}
