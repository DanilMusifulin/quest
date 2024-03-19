Задание: Разработать Rest Api для выполненияи заданий пользователей

Шаги установки
1. Создание базы данных quests
2. Запуск скрипта quests.sql  - для создания таблиц (с начально заполненными данными для примера):
   Описание таблиц:
   quest - задания
   quest_user - задания, распределенные на пользователей
   status - статус задания
   user - пользоватли

--
-- Структура таблицы `quest`
--

CREATE TABLE IF NOT EXISTS `quest` (
  `id_quest` int(11) NOT NULL AUTO_INCREMENT,
  `name_quest` varchar(512) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `created` date NOT NULL,
  `cost` int(11) NOT NULL,
  PRIMARY KEY (`id_quest`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `quest`
--

INSERT INTO `quest` (`id_quest`, `name_quest`, `description`, `created`, `cost`) VALUES
(1, 'Задание 1', '', '0000-00-00', 10000),
(2, 'Задание 2', '', '0000-00-00', 125000);

-- --------------------------------------------------------

--
-- Структура таблицы `quest_user` 
--

CREATE TABLE IF NOT EXISTS `quest_user` (
  `id_quest` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_status` int(11) NOT NULL COMMENT 'таблица status',
  `date_1` date NOT NULL COMMENT 'дата получения задания',
  `date_2` date NOT NULL COMMENT 'дата начала выполнения задания',
  `date_3` date NOT NULL COMMENT 'отдано на контроль',
  `date_4` date NOT NULL COMMENT 'контроль начат',
  `date_5` date NOT NULL COMMENT 'контроль пройден',
  `date_6` date NOT NULL COMMENT 'дата оплаты',
  PRIMARY KEY (`id_quest`,`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `quest_user`
--

INSERT INTO `quest_user` (`id_quest`, `id_user`, `id_status`, `date_1`, `date_2`, `date_3`, `date_4`, `date_5`, `date_6`) VALUES
(1, 1, 6, '2024-03-01', '2024-03-04', '2024-03-05', '2024-03-08', '2024-03-09', '2024-03-12'),
(1, 2, 6, '2024-03-02', '2024-03-06', '2024-03-07', '2024-03-15', '2024-03-16', '2024-03-16'),
(2, 1, 5, '2024-03-07', '2024-03-08', '2024-03-09', '2024-03-12', '2024-03-20', '0000-00-00'),
(2, 2, 6, '2024-03-05', '2024-03-13', '2024-03-14', '2024-03-15', '2024-03-16', '2024-03-20');

-- --------------------------------------------------------

--
-- Структура таблицы `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name_status` varchar(64) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `status`
--

INSERT INTO `status` (`id_status`, `name_status`) VALUES
(1, 'Задание назначено'),
(2, 'Задание на выполнении'),
(3, 'Задание выполнено'),
(4, 'На контроле'),
(5, 'Контроль пройден, готово к оплате'),
(6, 'Оплачено');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(32) NOT NULL,
  `balance` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `name` (`name_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `balance`) VALUES
(1, 'Пользователь 1', 10000),
(2, 'Пользователь 2', 135000),
(3, 'Пользователь 3', 0),
(4, 'Пользователь 4', 0),
(5, 'Пользователь 5', 0);

3. Описание файловой структуры Rest Api
api/config/database.php - Настройка пользователей б.д.
  
4. Описание методов:

5. Отчет о выполнении необходимых требований:
- RIMARY KEY (`id_quest`,`id_user`) в таблице quest_user обеспечивает наличие у одного пользователя одного и того же задания только один раз
- Класс User, метод create - метод создания пользователя (условие 1)
- Класс Quest, метод create -  метод создания пользователя задания (условия 2)
- Класс Quest_user, метод necessary_to_pay - просмотр заданий, которые необходимо оплатить; control_passed - метод отправки задания на оплату контролером (условие 3)
- Класс Quest_user, метод readOne - метод для просмотра истории выполнения работ и баланс по конкретному пользователю (условие 4)
- 

3. Файловая структура Api_Rest:
4. 
5. Описание методов:
6. Класс User, метод create() - выполнение условия 1
7. 

   
