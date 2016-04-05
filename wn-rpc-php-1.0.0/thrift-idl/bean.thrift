namespace php com.weinong.basedb.bean

struct Bank{
 1: i32 id,
 2: string name,
 3: string code,
} 
struct Classify{
 1: i32 id,
 2: i32 group_id,
 3: string name,
 4: bool visible,
}
struct Group{
 1: i32 id,
 2: string name,
 3: bool visible,
}
struct Market{
 1: i32 id,
 2: i32 subsection_id,
 3: string name,
}
struct SkuType{
 1: i32 id,
 2: string type,
}
struct Subsection{
 1: i32 id,
 2: string name,
}
struct Unit{
 1: i32 id,
 2: string name,
}
 