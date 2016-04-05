include "bean.thrift"

namespace php com.weinong.basedb.api


service BankApi {
  bean.Bank getById(1:i32 id)
  void save(1:bean.Bank bank)
  list<bean.Bank> getAllList()
  i32 delBankById(1:i32 id)
  bean.Bank getByCode(1:string code)
}
service ClassifyApi{
  bean.Classify getById(1:i32 id)
  void save(1:bean.Classify classify)
  list<bean.Classify> getAllList()
  bean.Classify getDefaultClassify()
  list<bean.Classify> getClassifysByGroupId(1:i32 group_id)
  map<bean.Group, list<bean.Classify>> getVisiableClassifyTree(1:i32 trade_id)
}
service GroupApi{
  bean.Group getById(1:i32 id)
  void save(1:bean.Group group)
  list<bean.Group> getAllList()
  bean.Group getDefaultGroup()
  list<bean.Group> getGroupsByTradeId(1:i32 trade_id)
}
service MarketApi{
  bean.Market getById(1:i32 id)
  void save(1:bean.Market market)
  list<bean.Market> getAllList()
  list<bean.Market> getBySubsection(1:i32 subsection_id)
}
service SkuTypeApi{
  bean.SkuType getById(1:i32 id)
  void save(1:bean.SkuType skuType)
  list<bean.SkuType> getAllList()
}
service SubsectionApi{
  bean.Subsection getById(1:i32 id)
  void save(1:bean.Subsection subsection)
  list<bean.Subsection> getAllList()
}
service UnitApi{
  bean.Unit getById(1:i32 id)
  void save(1:bean.Unit Unit)
  list<bean.Unit> getAllList()
  list<bean.Unit> getUnitsByTradeId(1:i32 trade_id)
}