namespace java com.weinong.user.rpc.bean
namespace php com.weinong.user.rpc.bean

struct WeixinUserInfo4Rpc {
  1: i32 id;
  2: string open_id;
  3: string nick_name;
  4: i32 sex;
  5: string city;
  6: string province;
  7: string country;
  8: string head_img_url;
  9: string privilege;
  10: optional string union_id;
}

struct UserInfo4Rpc {
  1: i32 id;
  2: string mobile;
  3: i32 status;
  4: string create_time;
  5: string name;
  6: string idcard;
  7: string address;
  8: string inited;
}

struct Device4Rpc {
  1: i32 id;
  2: i32 user_id;
  3: string device_code;
  4: string device_name;
  5: i32 device_index;
  6: string refresh_time;
  7: i32 status;
  8: string create_time;
}

struct WeixinBindOpenid4Rpc {
  1: i32 id;
  2: i32 user_id;
  3: string appid;
  4: string openid;
  5: string create_time;
}