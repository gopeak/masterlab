
# 登录相关模块
更新时间 2019/4/19

## 登录接口

请求方式：POST  
请求地址：http://demo.masterlab.vip/passport/do_login  

**参数** 

| 参数    | 类型     | 是否必须 |    说明                  |
| :----- -| ------: | :------: | :------:                |
| username | string | 是       |  用户名或email地址       |
| password | string | 是       |  登录密码                |

**返回结果说明**
```
 ret             string    返回的状态码,如不等于'200'，则表明异常
 msg             string    提示信息
 data            object    返回数据
    └user           object    返回的当前用户数据
        └uid             int    用户唯一标识id
        └title           string    用户职称
        └display_name    string    显示名称
        └status          string    用户状态, 
        └sign            string    签名
 token           string    维持登录的认证token
 token_expire    int       token的有效期，时间是秒,过期后请取refresh_token获取新的token维持登录状态
 refresh_token   string    刷新下一次token的凭证 
```

**返回的成功示例**
```json
// 20190418142328
{
  "ret": "200",
  "msg": "亲,登录成功",
  "data": {
    "user": {
      "uid": "1",
      "directory_id": "1",
      "phone": "18002510000",
      "username": "master",
      "openid": "q7a752741f667201b54780c926faec4e",
      "status": "1",
      "first_name": "",
      "last_name": "master",
      "display_name": "于子康",
      "email": "18002510000@masterlab.vip",
      "sex": "1",
      "birthday": "2019-04-12",
      "create_time": "0",
      "update_time": "0",
      "avatar": "http://demo.masterlab.vip/attachment/avatar/1.png?t=1555033377",
      "source": "",
      "ios_token": null,
      "android_token": null,
      "version": null,
      "token": null,
      "last_login_time": "1555566440",
      "is_system": "0",
      "login_counter": "0",
      "title": "管理员",
      "sign": "我是石家庄的庞立峰  今日在此地教育吾儿庞澳 天天不学习 还长得丑 气死我了",
      "k": "1",
      "create_time_text": ""
    },
    "msg": "亲,登录成功",
    "code": 1,
    "token": "148f36f95f7fbc8e5907078bf956f782dfa0e93969017f86395b0ee43738c7b1",
    "refresh_token": "7b3f79e64a0eb165c20b976910e626805b3eb0f3d2246b922f5b1a7759aa70a4",
    "token_expire": 2592000
  }
}
```

## 注销接口
请求方式：POST  
请求地址：http://demo.masterlab.vip/passport/do_logout

**参数** 

无  

**返回结果**
```
 ret             string    返回的状态码,如不等于'200'，则表明异常
 msg             string    提示信息
 data            array     返回空数组
```
**返回示例**
```
{
"ret": "200",
"msg": "ok",
"data": [ ]
}
```

## 注册接口
注册成功后，系统会发送一封确认邮件到用户注册的email中，用户需要点击邮箱中的激活链接。用户状态此时为审核中，需要管理员在后台审核通过才可使用。  
请求方式：POST  
请求地址：http://demo.masterlab.vip/passport/register  

**参数** 

| 参数    | 类型     | 是否必须 |    说明                 |
| :----- -| ------: | :------: | :------:                 |
| display_name | string | 是       |  用户显示名称       |
| username | string | 是       |  用户名                 |
| email    | string | 是       |  邮箱地址                |
| email_confirmation    | string | 是       |  邮箱地址             |
| password | string | 是       |  密码，长度6-20位         |

**返回结果**
```
 ret             string    返回的状态码,如不等于'200'，则表明异常
 msg             string    提示信息
 data            mix       返回数据
```

**返回的成功示例**
```
{
  "ret": "200",
  "msg": "注册成功",
  "data": []
}
```

**返回的错误示例**
```
{
  "ret": "104",
  "msg": "参数错误,请检查",
  "data": {
    "email": "email已经被使用了",
    "username": "用户名已经被使用了"
  }
}
```


## 找回密码发送邮件通知接口
用户输入邮箱，系统判断邮箱地址是否存在，如果存在会发送一封找回密码的邮件。  
请求方式：POST  
请求地址：http://demo.masterlab.vip/passport/send_find_password_email

**参数** 

| 参数    | 类型     | 是否必须 |    说明                 |
| :----- -| ------: | :------: | :------:                 |
| email | string | 是       |  邮箱地址       |

**返回结果**
```
 ret             string    返回的状态码,如不等于'200'，则表明异常
 msg             string    提示信息
 data            mix       返回数据
```

**返回的成功示例**
```
{
  "ret": "200",
  "msg": "ok",
  "data": []
}
```

**返回的错误示例**
```
{
  "ret": "101",
  "msg": "提示",
  "data": "您输入的email地址不存在"
}
```

## 检查email是否已经被使用
请求方式：GET  
请求地址：http://demo.masterlab.vip/passport/emailExist

**参数** 

| 参数    | 类型     | 是否必须 |    说明                 |
| :----- -| ------: | :------: | :------:                 |
| email | string | 是       |  邮箱地址       |

**返回结果**
```
true|false    如果返回 true 则存在，false表示不存在
```
 

## 检查用户名是否已经被使用
请求方式：GET  
请求地址：http://demo.masterlab.vip/passport/usernameExist

**参数** 

| 参数    | 类型     | 是否必须 |    说明                 |
| :----- -| ------: | :------: | :------:                 |
| username | string | 是       |  用户名       |

**返回结果**
```
true|false    如果返回 true 则存在，false表示不存在
```
 


















