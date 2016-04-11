namespace java com.weinong.user.rpc.api
namespace php com.weinong.user.rpc.api
include "bean.thrift"

service WeixinUserApi {
    bean.WeixinUserInfo4Rpc getWeixinUserInfoByOpenId(1:string open_id);
    bool forbidUser(1:i32 user_id);
    bool allowUser(1:i32 user_id);
    bool forbidDevice(1:i32 device_id);
    bool allowDevice(1:i32 device_id);
    bool unbindDevice(1:i32 device_id);
    bool unbindWeixin(1:i32 id);
    bean.UserInfo4Rpc getUserInfo(1:i32 user_id);
    bean.UserInfo4Rpc getUserInfoByMobile(1:string mobile);
    list<bean.Device4Rpc> getUserDevice(1:i32 user_id);
    list<bean.WeixinBindOpenid4Rpc> getWeixinBindOpenid(1:i32 user_id);
    bool updateWeixinBind(1:i32 old_user_id, 2:i32 new_user_id);
}

