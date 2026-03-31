<?php

if (!function_exists('getMonthName')) {
    function getMonthName($date, $lang = LANG): int|string
    {
        $monthAr = array(
            "uz" => array(
                ('Январ'),
                ('Феврал'),
                ('Март'),
                ('Апрел'),
                ('Май'),
                ('Июн'),
                ('Июл'),
                ('Август'),
                ('Сентябр'),
                ('Октябр'),
                ('Ноябр'),
                ('Декабр')
            ),
            "oz" => array(
                ('Yanvar'),
                ('Fevral'),
                ('Mart'),
                ('Aprel'),
                ('May'),
                ('Iyun'),
                ('Iyul'),
                ('Avgust'),
                ('Sentyabr'),
                ('Oktyabr'),
                ('Noyabr'),
                ('Dekabr')
            ),
            "en" => array(
                ('January'),
                ('February'),
                ('March'),
                ('April'),
                ('May'),
                ('June'),
                ('July'),
                ('August'),
                ('September'),
                ('October'),
                ('November'),
                ('December')
            ),
            'ru' => array(
                ('Января'),
                ('Февраля'),
                ('Марта'),
                ('Апреля'),
                ('Мая'),
                ('Июня'),
                ('Июля'),
                ('Августа'),
                ('Сентября'),
                ('Октября'),
                ('Ноября'),
                ('Декабря')
            ),
        );
        $date_arr = date_parse($date);
        $month_number = $date_arr['month'];
        if ($month_number >= 1 && $month_number <= 12)
            return $monthAr[$lang][$month_number - 1];
        else
            return -1;
    }

}

if (!function_exists('getMonthNameShort')) {
    function getMonthNameShort($date, $lang = LANG): int|string
    {
        $monthAr = array(
            "uz" => array(
                ('Янв'),
                ('Фев'),
                ('Мар'),
                ('Апр'),
                ('Май'),
                ('Июн'),
                ('Июл'),
                ('Авг'),
                ('Сен'),
                ('Окт'),
                ('Ноя'),
                ('Дек')
            ),
            "oz" => array(
                ('Yan'),
                ('Fev'),
                ('Mar'),
                ('Apr'),
                ('May'),
                ('Iyu'),
                ('Iyu'),
                ('Avg'),
                ('Sen'),
                ('Okt'),
                ('Noy'),
                ('Dek')
            ),
            "en" => array(
                ('Jan'),
                ('Feb'),
                ('Mar'),
                ('Apr'),
                ('May'),
                ('Jun'),
                ('Jul'),
                ('Aug'),
                ('Sept'),
                ('Oct'),
                ('Nov'),
                ('Dec')
            ),
            'ru' => array(
                ('Янв'),
                ('Фев'),
                ('Мар'),
                ('Апр'),
                ('Мая'),
                ('Июн'),
                ('Июл'),
                ('Авг'),
                ('Сен'),
                ('Окт'),
                ('Ноя'),
                ('Дек')
            ),
        );
        $date_arr = date_parse($date);
        $month_number = $date_arr['month'];
        if ($month_number >= 1 && $month_number <= 12)
            return $monthAr[$lang][$month_number - 1];
        else
            return -1;
    }
}
