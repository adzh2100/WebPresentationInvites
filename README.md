# WebPresentationInvites

Архива съдържа проект за Уеб покани и генериране на МЕМЕ създаден от Александър Стоилов, Ангел Марински и Айше Джинджи. 
Съдържа 4 основни директории backend(прави връзката между frontend и базата данни), config(съдържа конфигурациите на системата), 
database(създаваме базите и seed-ове), frontend(грижи се за UI на системата, както и за error handling).

## User Manual за подкарване на системата:
Преди всичко трябва да влезем XAMPP и да пуснем Apache и MySQL. След това трябва да зададем желаната от нас конфигурация във файла /config/config.ini. 
За удобство при създаването на базата и таблиците сме изготвили php скрипт - /backend/db/prepare_db.php, който пуска sql скриптовете за създаването на  базата и таблиците, 
както и добавянето на данни в тях. За да работи правилно, скриптът трябва да бъде изпълнен от папката /backend/db. Възможно е скриптовете да бъдат изпълнени и самостоятелно. 
След пускането на им проектът би следвало да работи правилно*. 
В системата е разработена и функционалност за изпращане на имейли. 
За да работи правилно, трябва да имаме добавена конфигурация за изпращане на имейли в php.ini файла.