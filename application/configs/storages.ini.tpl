; Хранилище Master, РСУБД MSSQL настройки для адаптера Lapi использующего Zend PDO
Master.storage.pdoType = "dblib"
Master.storage.host = "master"
Master.storage.dbname = "lanta"
Master.storage.username = "WEB_LAPI"
Master.storage.password = "tr43SqPzz"
Master.cache.type = "Memcached"
Master.cache.conf.servers.0.host = "127.0.0.1"
Master.cache.conf.servers.0.port = "11211"

; Хранилище MasterLPR, для поисовых таблиц по ценам в MSSQL
MasterRPL.storage.pdoType = "dblib"
MasterRPL.storage.host = "masterrpl"
MasterRPL.storage.port = "1301"
MasterRPL.storage.dbname = "LantaWeb"
MasterRPL.storage.username = "WEB_LAPI"
MasterRPL.storage.password = "tr43SqPzz"
MasterRPL.cache.type = "Memcached"
MasterRPL.cache.conf.servers.0.host = "127.0.0.1"
MasterRPL.cache.conf.servers.0.port = "11211"


MegatecSearch.storage.wsdl = "http://lanta.storage.lantatur.storage.ru/newonlineadvsrech/Search.storage.asmx?WSDL"
MegatecSearch.storage.soap = "Client_DotNet"

; Хранилище Djem - вообще это не совсем джем, это те статические страницы, которые он генерирует
Djem.storage.type = "static"
Djem.storage.encode = "utf-8"
Djem.storage.cruiseDjemPath = "http://www.cruiselanta.ru"
Djem.storage.cruiseDjemUrl = "http://www.cruiselanta.ru"

RCCL.storage.target = Test
RCCL.storage.ISOCountry = RU
RCCL.storage.wsdl = "http://my.cruiselanta.ru/wsdl/RCCL_FIT_Cruise_API.wsdl"
RCCL.storage.location = "https://stage.services.rccl.com/Reservation_FITWeb/sca/"
RCCL.storage.shortName = "LANTATUR"
RCCL.storage.requestorId = "126053"
RCCL.storage.options.soap_version = 2
RCCL.storage.options.trace = TRUE
;RCCL.storage.options.login = "CONLTOP"
;RCCL.storage.options.password = "8xvnG~be"
RCCL.storage.options.login = "CONSTAGELTOP"
RCCL.storage.options.password = "L@ntaTur1"
;RCCL.storage.options.stream_context.socket.bindto = "212.118.49.4:0"


; Master, база справочников
Reference.storage.pdoType = "dblib"
Reference.storage.host = "master"
Reference.storage.dbname = "total_services"
Reference.storage.username = "ANTONIUK"
Reference.storage.password = "Qwer1234"

; Сервис шифрования паролей Мегатека
MegatecEnc.storage.soap = "Client"
MegatecEnc.storage.wsdl = "http://lanta.lantatur.ru/EncryptionService/EncryptionService.asmx?WSDL"
MegatecEnc.storage.options.location = "http://lanta.lantatur.ru/EncryptionService/EncryptionService.asmx"
