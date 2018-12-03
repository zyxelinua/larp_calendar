<?php

namespace App\Form;

class MixDesk
{
    const RuntimeGM = [
        'title' => 'Вмешательство мастера во время игры: между Пассивным вмешательством и Активным',
        'description' => 'Некоторые мастера считают, что их работа заканчивается с началом игры. Затем они оставляют все на откуп игрокам. Другие постоянно влияют на игру по ходу действия. Насколько активно вы регулируете игровой процесс? Само вмешательство тоже может быть различным: от точечного посыла игротехов для внедрения информации в игру до остановки игрового процесса с разбором ситуации или отмены игровых событий (откаты).',
        'values' => [
            '1. Мастерская работа состоит в доигровой подготовке и заканчивается, когда начинается игра.' => 1,
            '2. Время от времени мастера вводят в игру информацию, игротехов и события. Отслеживают ключевые моменты.'=> 2,
            '3. Мастера контролируют ввод сюжетных элементов, а также ход боевых и квестовых событий.'=> 3,
            '4. Мастера контролируют все игровые события и наблюдают за всеми крупными контактами между игроками, объявляя Стоп Игру в случае необходимости.'=> 4,
            '5. Мастера постоянно следят за ходом сюжета и корректностью действий игроков. Ни одно игровое событие не может пройти без их участия. Отмена игровых событий в случае неудовлетворительного их развития.'=> 5,
        ]
    ];

    const Openness = [
        'title' => 'Открытость внутриигровой информации: между Секретностью и Доступностью',
        'description' => 'Является ли игровая информация - например, описания персонажей или событий, которые произойдут - тайной для игроков или ее узнать может кто угодно? Насколько мастера облегчают игрокам поиск информации по миру игры? Полнота доступа к информации дает игрокам возможность просто ею обменяться для органичного погружения, но лишает их открытий и сюрпризов. Нечто среднее предполагает, что для некоторых игроков существуют определенные секреты или сами игроки выбирают что именно они хотят знать.',
        'values' => [
            '1. Вводная минимальная или ее вообще нет. Информация о ролях и событиях недоступна. В процессе игры информация выдается жестко порционно.' => 1,
            '2. Скупая предистория игры. Материалы по миру игроки выискивают сами. Известны ключевые персонажи/команды, до игры известно лишь то с чего игра начинается. В ходе игры информация выдается последовательно и порционно.'=> 2,
            '3. Описана игровая вводная и предоставлены ссылки для изучения мира игры. Известны первоначальные игровые и возможно некоторые ключевые события. Сетка ролей известна всем, но могут быть некоторые неансированные персонажи. Большинство внутриигровой квестовой информации вброшено, но доступ к ней ограничен.'=> 3,
            '4. Объемная вводная и предыстория, мастера помогают игрокам в поиске информации по миру. Роли некоторых персонажей неизвестны широкому кругу, а также возможны события в виде сюрпризов. Только ключевые части игровой квестовой информации выдаются под мастерским надзором.'=> 4,
            '5. Мастера предоставляют многочисленные материалы по миру игры. Заранее известна вся сетка ролей и запланированных игровых событий. В игре можно найти всю интересующую информацию в любой момент.'=> 5,
        ]
    ];

    const PlayerPressure = [
        'title' => 'Физиологическо-психологическое давление на игрока: между Условностью и Хардкором',
        'description' => 'Есть некоторые элементы в ролевых играх, которые трудно передать. Например голод, насилие, лишение сна и пищи, секс и употребление наркотиков. Если вы хотите включить такие элементы в игру, как вы это сделаете? Окажите ли вы давление на игроков с помощь хардкорных методов, таких как реальный алкоголь, реальное лишение пищи и сна ночью? Или сбережете игроков от такого давления с помощью замены, например, секса сгущеным молоком, реального оружия мягким, ненастоящими наркотиками и предложите им делать вид, что все это было настоящим? Голодные игроки, конечно же прочувствуют что значит быть голодными, но их способность к отыгрышу и наслаждение другими аспектами игры будет снижено.',
        'values' => [
            '1. Жизненные лишения и неудобства физического и психологического характера на игре отсутствуют.' => 1,
            '2. Игра содержит некоторые жизненные неудобства, но все они четко регламентированы.'=> 2,
            '3. Ограничен доступ к жизненным удобствам, таким как еда и сон. Игроки в момент непереносимости состояния могут в любой момент покинуть игровой процесс.'=> 3,
            '4. Четко регламентированы некоторые элементы жесткого воздействия на психологию и физиологию играющих. В исключительно тяжелых условиях игроки выводятся мастерами из игры.'=> 4,
            '5. Игроки предупреждены и отдают себе отчет в том, что они будут испытывать физиологические и психологические неудобства и лишения.'=> 5,
        ]
    ];

    const CharCreation = [
        'title' => 'Создание персонажа: между Мастером и Игроком',
        'description' => 'Кто создает образы персонажей? Их выдумывают мастера? Или игроки? Или они пишутся совместно в доигровом процессе? Возможны различные комбинации, например изначально образ создается мастером, а затем он прорабатывается игроком. Создание игроком образов более сильно привязывает их к персонажам и снимает с мастеров часть работы. С другой стороны создание образов мастерами помогает им в создании соответствия между ролями и видением самой игры.',
        'values' => [
            '1. Все квенты и завязки написаны исключительно мастерами. Игроки выбирают себе роль из сетки ролей или получают ее от мастеров.' => 1,
            '2. Квенты персонажей написаны мастерами частично. Игроки лишь дополняют написанное, придумывая недостающие части.'=> 2,
            '3. Игроки выдумывают себе роль, но могут воспользоваться предложенными мастерами вариантами. Исходя из результата мастера создают сюжетные завязки.'=> 3,
            '4. Игроки выдумывают себе роли, советуясь в ключевых аспектах с мастерами. Сюжетные завязки создаются мастерами только для главных персонажей.'=> 4,
            '5. Игроки самостоятельно придумывают себе роль и квенту. Мастера занимаются исключительно допуском.'=> 5,
        ]
    ];

    const Metatechniques = [
        'title' => 'Способы ввода информации (метатехники): между Игровыми и Пожизненными',
        'description' => 'Метатехниками являются методы передачи информации игрокам, но не персонажам. Информация о прошедших событиях, состоянии и чувствах игрока, а также о происходящем передается человеку, но ее “не слышит” его персонаж. Информацией могут обмениваться как сами игроки “по жизни”, так она может передаваться от мастера к игроку, например мастер описывает игроку то что чувствует сейчас его персонаж. Хотите ли вы чтобы информация о событиях, имевших место в другое время, в другом месте или иная недоступная персонажам информация вводилась исключительно игровыми методами или “по жизни”?',
        'values' => [
            '1. Информация вводится исключительно “по игре”, пожизненного ее обмена нет. Для передачи новой информации используются игротехнические роли.' => 1,
            '2. Передача информации о событиях другого времени или места происходит только тогда, когда сделать это “по игре” фактически невозможно.'=> 2,
            '3. Игроки передают друг другу информацию “по жизни” только в тех случаях когда сделать это игровыми методами затруднительно или займет много времени. Мастера вводят информацию напрямую тогда, когда нет свободных игротехников или же это поломает разворачивающийся сюжет.'=> 3,
            '4. При любых неясных ситуациях игроки могут отойти в сторону и обменяться информацией не в канве игры. Мастерская информация передается напрямую без игровых методов.'=> 4,
            '5. Игроки общаются “по жизни”, только номинально передавая информацию о своих персонажах. Мастера напрямую руководят игроками.'=> 5,
        ]
    ];

    const StoryEngine = [
        'title' => 'Командность игры: между Соперничеством и Командной игрой',
        'description' => 'Возможно ли в игре победить или иметь достижимую цель, можно ли это совершить в одиночку или командно? Возможно ли задать цель игры для участников (особенно это подходит новичкам)? Это особенность соревновательного подхода. С другой стороны, получается более интересное развитие истории и большее погружение игроков при совместном решении проблемы. Это особенность командной игры.',
        'values' => [
            '1. У каждого игрока обозначена персональная цель, противоречащая целям большинства других игроков.' => 1,
            '2. Каждый игрок решает свои задачи, однако иногда для этого выгоднее с кем-нибудь объединиться.'=> 2,
            '3. Каждый игрок решает подниматься ли ему по собственной игровой карьерной лестнице или объединяться для решения задач с другими игроками.'=> 3,
            '4. Игра располагает к командному объединению, но оно не обязательно для положительного завершения игры.'=> 4,
            '5. Единственный способ не проиграть, это командная игра, в которой все игроки участвуют в решении общей задачи.'=> 5,
        ]
    ];

    const CommunicationStyle = [
        'title' => 'Взаимодействие между игроками: между Вербальным и Физическим',
        'description' => 'Какой стиль взаимодействия между игроками предполагается на вашей игре? Существуют ли способы разрешение ситуаций через общение или через физическое взаимодействие? Сподвигать игровой процесс на тот или иной тип взаимодействия можно через образы персонажей, через правила конкретной игры, через устройство игровых помещений или просто через беседу с игроками. Физическое воздействие игроков друг на друга делает их опыт более захватывающим, т.к. в процессе участвуют все органы чувств, но словесное взаимодействие на играх упрощает привлечение новых игроков и более реалистично в большинстве ситуаций.',
        'values' => [
            '1. Игра является словесной, физического взаимодействия с игроками нет и все ситуации решаются вербально.' => 1,
            '2. В игре используется такое оружие и предметы физического взаимодействия, которые сами по себе не могут нанести вреда здоровью игроков. Физическое взаимодействие между игроками допускается в строго определенных случаях.'=> 2,
            '3. Физический контакт между игроками происходит в боевых исходных ситуациях. Он четко прописан в правилах и предупреждает физический ущерб.'=> 3,
            '4. Физическое взаимодействие между игроками лежит в основе игры. Исключаются лишь ситуации, способные нанести тяжелый ущерб здоровью игрока.'=> 4,
            '5. Между игроками фул-контакт, игроки предупреждены и осознают опасность игровых ситуаций для своего здоровья и жизни.'=> 5,
        ]
    ];

    const BleedIn = [
        'title' => 'Отношение игрока к персонажу: между Личным и Дистанцированным',
        'description' => 'Используете ли вы элементы из личного жизненного опыта игроков в формировании их персонажей или создаете барьеры и дистанцируете личные переживания игроков от переживаний их персонажей? Использование личного опыта или прошедших событий в жизни игроков может создать более сильное эмоциональное впечатление для них, но превращает ролевую игру в реальную жизнь. Оно может увести игровые впечатления от сюжета событий в сторону личных привнесенных эмоций. В крайней форме игроки являются самими собой только в альтернативной обстановке.',
        'values' => [
            '1. Игроки являются самими собой только в альтернативной обстановке.' => 1,
            '2. При формировании образов персонажей мастера используют прошлую жизнь и элементы характера игроков.'=> 2,
            '3. Игроки выбирают себе такие роли, поведение и переживания которых они могут себе представить и ощутить.'=> 3,
            '4. Персонажи достаточно далеки от личностей игроков, так что их чувства и характеры последние представляют себе весьма условно.'=> 4,
            '5. Личность игроков не имеют ничего общего с личностями персонажей. Образ и мотивация последних чужды или непонятны игрокам.'=> 5,
        ]
    ];

    const LoyaltyToSetting = [
        'title' => 'Реконструкция поведения персонажей: между Отыгрышем и Повторением',
        'description' => 'Часто мастера на своих играх хотели бы, чтобы игроки вели себя согласно прототипам их ролей для реконструкции атмосферы первоисточника, особенно в исторических играх.Но в большинстве игр невозможно переживать чувства своего персонажа, если роль последнего не имеет смысловой нагрузки, даже если сам образ уместен в этой атмосфере. Иногда органичнее совершать игровые поступки, делающие сюжет более интересным, чем те, которые более ожидаемы от прототипа персонажа. Насколько реалистичное вам нужно исполнение? Реконструкция поведения помогает погрузиться в атмосферу игры, но сильный упор на этом может лишить игроков переживаний через большее внимание к тому, как требуется поступать, а не к смыслу действий.',
        'values' => [
            '1. Игроки ничего не знают о поведении их прототипов и поступают исходя из собственных побуждений.' => 1,
            '2. Игроки имеют общее представление о характерах отыгрываемых персонажей и событий.'=> 2,
            '3. Игроки изучают прообразы их персонажей, однако ведут себя по собственному усмотрению.'=> 3,
            '4. Поведение игроков стилизовано под первоисточник их ролей и допускает некоторые отклонения.'=> 4,
            '5. Поведение игроков строго соответствует прообразу первоисточника, их внимание сконцентрировано на соответствии моделируемым событиям.'=> 5,
        ]
    ];

    const RepresentaionOfTheme = [
        'title' => 'Реконструкция окружения: между Условностью и Симуляцией',
        'description' => 'Насколько обстановка на вашей игре приближена к обстановке моделируемых событий? Является ли реализм вашей целью? Или же вы используете условные или даже сюрреалистические элементы для концентрации на ощущениях и переживаниях или для выделения определенных аспектов игры? К примеру, если цель игры - создать атмосферу тюремного заключения, то это можно сделать двумя способами: либо симуляцией реальной тюремной обстановки, либо использованием условных элементов, которые вызовут соответствующие ощущения.',
        'values' => [
            '1. Требования к костюму и антуражу отсутствуют или полностью отдаются на откуп игрокам. Игровые постройки и помещения не имеют оформления' => 1,
            '2. Требования к костюму и антуражу минимальны. Игровые постройки и помещения имеют условное обозначение.'=> 2,
            '3. Правила игры или пожелания мастеров описывают требования внешней схожести костюмов с первоисточником. Постройки имеют общее сходство с оригиналом.'=> 3,
            '4. Реконструкция костюмов и антуража допускает упрощения. Постройки и помещения декорированы для общего сходства с оригиналом.'=> 4,
            '5. Полная реконструкция костюма. Постройки декорированные для максимальной схожести с оригиналом.'=> 5,
        ]
    ];

    const Scenography = [
        'title' => 'Сценография: между Минимализмом и 360 градусов (все в игре)',
        'description' => 'Как игроки взаимодействуют с окружением? Является ли все окружение частью самой игры, требуя реалистичного к себе отношения (термин 360 градусов) или же взаимодействие с предметами является условным. Под окружением понимаются игровые постройки и места обитания персонажей, предметы обихода, оружие и другие вещи, а также еда и напитки. В случае “все в игре” все действия с предметами производятся “по жизни”, безо всяких условностей.',
        'values' => [
            '1. Постройки и места обитания запрещается разрушать и преодолевать “по жизни”. Ни один из игровых предметов или ценностей не отчуждается. Еда и напитки являются личными ценностями человека.' => 1,
            '2. Запрещено взаимодействовать с игровыми сооружениями, кроме как с использованием специальных возможностей. Игровыми ценностями являются не сами предметы, а их маркировка и сертификаты на них. Еду и напитки запрещено отчуждать.'=> 2,
            '3. Игровые постройки запрещено разрушать и преодолевать, кроме случаев указанных в правилах или по особым сертификатам. Предметы, которые находятся в игре и не являются личными ценностями маркированы специальными чипами. Отчуждаемыми являются еда и напитки с нанесенными на них маркерами.'=> 3,
            '4. Игровые сооружения и места обитания по умолчанию возможно преодолевать, кроме отдельно оговоренных случаев. Все предметы и антураж являются игровыми ценностями, кроме личных вещей. Еда и напитки выдаются внутри игры, однако не могут быть отобраны.'=> 4,
            '5. 360 градусов. Все в игре. Взаимодействие и преодоление игровых построек полностью реалистично и не терпит условностей. Все игровые ценности, вплоть до антуража отчуждаемы. Пропитание получается внутри игры и может быть отобрано, украдено или обменяно на другую ценность.'=> 5,
        ]
    ];
}
