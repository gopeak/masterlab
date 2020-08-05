
# 统一说明
更新时间 2019/4/19

## 请求说明

请求方式：对于表单提交统一采用 POST 方式，获取数据则采用 GET ，其他会特殊说明  
请求地址：http://demo.masterlab.vip/，可支持https

## 返回格式说明

```
 ret             string    返回的状态码,如不等于'200'，则表明异常
 msg             string    提示信息
 data            mix       任意数据类型 
```

## ret状态码说明
```text
200   为正常返回
101   客户端弹出提示tip
102   
```