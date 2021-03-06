所有请求必须有id/cmd参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |请求id，发送请求时随机生成  |
|cmd |是  |long |请求命令，用于区分不同业务 |

所有请求返回必须有id/cmd/code/msg参数

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |

code:
200->成功
201->参数不正确
202->未登录、绑定


-------
# 用户登录
    
简要描述：

cmd=1000

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|phone |是  |string |手机号  |
|password |是  |string | 密码    |

返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |
|data |是  |user | 用户信息    |
user

|参数名|必选|类型|说明|
|:---- |:---|:----- |-----   |
|id |是  |long |用户id  |
|name |是  |string | 用户名|
|phone |是  |string |手机号  |
|avatar |是  |string | 用户头像    |

返回示例 

```
{
    "id": 1111111,
    "cmd": 1000,
    "code": 200,
    "msg": "login success!",
    "data":{
        "id":12,
        "name":"VOCHAT-RYBR",
        "phone":"18978403465",
        "avatar":""
    }
}
```


-------

# 用户注册
    
简要描述：

cmd=1001

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|phone |是  |string |手机号  |
|password |是  |string | 密码    |

返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |
|data |是  |user | 用户信息    |
user

|参数名|必选|类型|说明|
|:---- |:---|:----- |-----   |
|id |是  |long |用户id  |
|name |是  |string | 用户名|
|phone |是  |string |手机号  |
|avatar |是  |string | 用户头像    |

返回示例
 
```
{
    "id": 1111111,
    "cmd": 1001,
    "code": 200,
    "msg": "register success!"
    "data":{
        "id":12,
        "name":"VOCHAT-RYBR",
        "phone":"18978403465",
        "avatar":""
    }
}
```


-------


# 用户绑定
    
简要描述：

cmd=1002

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|userid |是  |string |用户id  |

返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |

返回示例
 
```
{
    "id": 1111111,
    "cmd": 1002,
    "code": 200,
    "msg": "bind success!"
}
```


-------

# 重置密码
    
简要描述：
已登录
cmd=1003

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|password |是  |string | 新密码    |

返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |

返回示例
 
```
{
    "id": 1111111,
    "cmd": 1003,
    "code": 200,
    "msg": "reset password success!"
}
```
-------

# 修改用户名
    
简要描述：
已登录
cmd=1004

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|name |是  |string | 用户名    |

返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |

返回示例
 
```
{
    "id": 1111111,
    "cmd": 1004,
    "code": 200,
    "msg": "reset name success!"
}
```
-------

# 搜索用户
    
简要描述：

cmd=1005

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|phone |是  |string |手机号  |

返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |
|data |是  |List< user > | 用户列表    |
user

|参数名|必选|类型|说明|
|:---- |:---|:----- |-----   |
|id |是  |long |用户id  |
|name |是  |string | 用户名|
|phone |是  |string |手机号  |
|avatar |是  |string | 用户头像    |
返回示例
 
```
{
    "id": 1111111,
    "cmd": 1005,
    "code": 200,
    "msg": "search success!"
    "data":[{
        "id":12,
        "name":"VOCHAT-RYBR",
        "phone":"18978403465",
        "avatar":""
    }]
}
```
-------

# 添加联系人
    
简要描述：
以登录
cmd=1006

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|friendid |是  |string |要添加的联系人ID|

返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |
|data |是  |List< user > | 用户列表    |
user

|参数名|必选|类型|说明|
|:---- |:---|:----- |-----   |
|id |是  |long |用户id  |
|name |是  |string | 用户名|
|phone |是  |string |手机号  |
|avatar |是  |string | 用户头像    |
返回示例
 
```
{
    "id": 1111111,
    "cmd": 1006,
    "code": 200,
    "msg": "add contact success!"
    "data":[{
        "id":12,
        "name":"VOCHAT-RYBR",
        "phone":"18978403465",
        "avatar":""
    }]
}
```
-------

# 获取联系人列表
    
简要描述：
已登录
cmd=1007

请求参数：⏫ 

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |


返回参数：⏬

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|id |是  |long |服务端不做处理原样返回  |
|cmd |是  |long | 服务端不做处理原样返回|
|code |是  |int |状态码  |
|msg |是  |string | 状态信息    |
|data |是  |List< user > | 用户列表    |
user

|参数名|必选|类型|说明|
|:---- |:---|:----- |-----   |
|id |是  |long |用户id  |
|name |是  |string | 用户名|
|phone |是  |string |手机号  |
|avatar |是  |string | 用户头像    |
返回示例
 
```
{
    "id": 1111111,
    "cmd": 1007,
    "code": 200,
    "msg": "get contact success!"
    "data":[{
        "id":12,
        "name":"VOCHAT-RYBR",
        "phone":"18978403465",
        "avatar":""
    }]
}
```
-------


