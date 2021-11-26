
input = """
100 Continue («продолжай»)[2][3];
101 Switching Protocols («переключение протоколов»)[2][3];
102 Processing («идёт обработка»);
103 Early Hints («ранняя метаинформация»);
200 OK («хорошо»)[2][3];
201 Created («создано»)[2][3][4];
202 Accepted («принято»)[2][3];
203 Non-Authoritative Information («информация не авторитетна»)[2][3];
204 No Content («нет содержимого»)[2][3];
205 Reset Content («сбросить содержимое»)[2][3];
206 Partial Content («частичное содержимое»)[2][3];
207 Multi-Status («многостатусный»)[5];
208 Already Reported («уже сообщалось»)[6];
226 IM Used («использовано IM»).
300 Multiple Choices («множество выборов»)[2][7];
301 Moved Permanently («перемещено навсегда»)[2][7];
302 Moved Temporarily («перемещено временно»)[2][7], 302 Found («найдено»)[7];;
303 See Other («смотреть другое»)[2][7];
304 Not Modified («не изменялось»)[2][7];
305 Use Proxy («использовать прокси»)[2][7];
307 Temporary Redirect («временное перенаправление»)[7];
308 Permanent Redirect («постоянное перенаправление»)[8].
400 Bad Request («неправильный, некорректный запрос»)[2][3][4];
401 Unauthorized («не авторизован (не представился)»)[2][3];
402 Payment Required («необходима оплата»)[2][3];
403 Forbidden («запрещено (не уполномочен)»)[2][3];
404 Not Found («не найдено»)[2][3];
405 Method Not Allowed («метод не поддерживается»)[2][3];
406 Not Acceptable («неприемлемо»)[2][3];
407 Proxy Authentication Required («необходима аутентификация прокси»)[2][3];
408 Request Timeout («истекло время ожидания»)[2][3];
409 Conflict («конфликт»)[2][3][4];
410 Gone («удалён»)[2][3];
411 Length Required («необходима длина»)[2][3];
412 Precondition Failed («условие ложно»)[2][3][9];
413 Payload Too Large («полезная нагрузка слишком велика»)[2][3];
414 URI Too Long («URI слишком длинный»)[2][3];
415 Unsupported Media Type («неподдерживаемый тип данных»)[2][3];
416 Range Not Satisfiable («диапазон не достижим»)[3];
417 Expectation Failed («ожидание не удалось»)[3];
418 I’m a teapot («я — чайник»);
419 Authentication Timeout (not in RFC 2616) («обычно ошибка проверки CSRF»);
421 Misdirected Request [10];
422 Unprocessable Entity («необрабатываемый экземпляр»);
423 Locked («заблокировано»);
424 Failed Dependency («невыполненная зависимость»);
425 Too Early («слишком рано»);
426 Upgrade Required («необходимо обновление»);
428 Precondition Required («необходимо предусловие»)[11];
429 Too Many Requests («слишком много запросов»)[11];
431 Request Header Fields Too Large («поля заголовка запроса слишком большие»)[11];
449 Retry With («повторить с»)[1];
451 Unavailable For Legal Reasons («недоступно по юридическим причинам»)[12].
499 Client Closed Request (клиент закрыл соединение);
500 Internal Server Error («внутренняя ошибка сервера»)[2][3];
501 Not Implemented («не реализовано»)[2][3];
502 Bad Gateway («плохой, ошибочный шлюз»)[2][3];
503 Service Unavailable («сервис недоступен»)[2][3];
504 Gateway Timeout («шлюз не отвечает»)[2][3];
505 HTTP Version Not Supported («версия HTTP не поддерживается»)[2][3];
506 Variant Also Negotiates («вариант тоже проводит согласование»)[13];
507 Insufficient Storage («переполнение хранилища»);
508 Loop Detected («обнаружено бесконечное перенаправление»)[14];
509 Bandwidth Limit Exceeded («исчерпана пропускная ширина канала»);
510 Not Extended («не расширено»);
511 Network Authentication Required («требуется сетевая аутентификация»)[11];
520 Unknown Error («неизвестная ошибка»)[15];
521 Web Server Is Down («веб-сервер не работает»)[15];
522 Connection Timed Out («соединение не отвечает»)[15];
523 Origin Is Unreachable («источник недоступен»)[15];
524 A Timeout Occurred («время ожидания истекло»)[15];
525 SSL Handshake Failed («квитирование SSL не удалось»)[15];
526 Invalid SSL Certificate («недействительный сертификат SSL»)[15].
"""


def get_description_status(item):
    item_slice = item[1:]
    answer = ''
    for i in item_slice:
        if i[0] == '(' or i[0] == '[':
            break
        answer += i + ' '
    return answer[:len(answer) - 1]


def get_verdict_by_status(item):
    status_code = int(item[0])
    if status_code // 100 == 1:
        return 'INFORMATION'
    elif status_code // 100 == 2:
        return 'SUCCESS'
    elif status_code // 100  == 3:
        return 'REDIRECTION'
    elif status_code // 100  == 4:
        return 'CLIENT_ERROR'
    else:
        return 'SERVER_ERROR'

f = open('output.txt', 'w')

for item in (input.split("\n")):
    item_splited = item.split()

    if len(item_splited) > 2:
        print(
            'public',
            'const',
            f'{get_verdict_by_status(item_splited)}_{item_splited[0]}',
            '='
            '\'HTTP/1.1',
            f'{item_splited[0]}',
            f'{get_description_status(item_splited)}\';'
            , file=f
        )
