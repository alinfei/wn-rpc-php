##什么是RPC
&#160; &#160; &#160; &#160;
RPC（Remote Procedure Call Protocol）——远程过程调用协议，它是一种通过网络从远程计算机程序上请求服务，而不需要了解底层网络技术的协议。RPC协议假定某些传输协议的存在，如TCP或UDP，为通信程序之间携带信息数据。在OSI网络通信模型中，RPC跨越了传输层和应用层。RPC使得开发包括网络分布式多程序在内的应用程序更加容易。
RPC采用客户机/服务器模式。请求程序就是一个客户机，而服务提供程序就是一个服务器。首先，客户机调用进程发送一个有进程参数的调用信息到服务进程，然后等待应答信息。在服务器端，进程保持睡眠状态直到调用信息到达为止。当一个调用信息到达，服务器获得进程参数，计算结果，发送答复信息，然后等待下一个调用信息，最后，客户端调用进程接收答复信息，获得进程结果，然后调用执行继续进行。
有多种 RPC模式和执行。最初由 Sun 公司提出。IETF ONC 宪章重新修订了 Sun 版本，使得 ONC RPC 协议成为 IETF 标准协议。现在使用最普遍的模式和执行是开放式软件基础的分布式计算环境（DCE）。[百度百科](http://baike.baidu.com/link?url=biFWaN66mb_2XrFxrVnOUhPMF_r0h1EN-_BihQH5CPo0Psp3q0BATbLx1WOpwNBf9m0TDXnUhSIP3L74c1ruGj3IdOU4oTY80oQm8Yr4Qjq)
##Thrift框架
流行的RPC框架有:Thrift(FaceBook->Apache)、dubbo(阿里)、Hessian等。

&#160; &#160; &#160; &#160;
thrift是一个软件框架，用来进行可扩展且跨语言的服务的开发。它结合了功能强大的软件堆栈和代码生成引擎，以构建在 C++, Java, Python, PHP, Ruby, Erlang, Perl, Haskell, C#, Cocoa, JavaScript, Node.js, Smalltalk, and OCaml 这些编程语言间无缝结合的、高效的服务。

##wn-rpc-php
###编写idl文(接口描述语言)<br/>
bean.thrift
```idl
namespace php com.weinong.basedb.bean

struct Bank{
    1: i32 id,
    2: string name,
    3: string code,
} 
...
```
api.thrift
```idl
include "bean.thrift"

namespace php com.weinong.basedb.api

service BankApi {
    bean.Bank getById(1:i32 id)
    void save(1:bean.Bank bank)
    list<bean.Bank> getAllList()
    i32 delBankById(1:i32 id)
    bean.Bank getByCode(1:string code)
}
...
```
###执行thrift命令
```bat
thrift -out ./users-api-bean  -gen php thrift-idl/bean.thrift
thrift -out ./users-api-bean  -gen php thrift-idl/api.thrift
```
未完待续...
