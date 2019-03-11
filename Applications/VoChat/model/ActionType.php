<?php
/**
 * Created by PhpStorm.
 * UserDao: yaopeng
 * Date: 2019-03-10
 * Time: 03:47
 */
namespace VoChat\Model;
class ActionType
{
    const USUER_LOGIN   = 1000;
    const USER_REGISTER   = 1001;
    const BOOL   = 2;
    const BYTE   = 3;
    const I08    = 3;
    const DOUBLE = 4;
    const I16    = 6;
    const I32    = 8;
    const I64    = 10;
    const STRING = 11;
    const UTF7   = 11;
    const STRUCT = 12;
    const MAP    = 13;
    const SET    = 14;
    const LST    = 15;
    const UTF8   = 16;
    const UTF16  = 17;
}