<?php

namespace app\command;

use app\command\handlers\GroupCommandHandler;
use app\command\handlers\HelpCommandHandler;
use app\command\handlers\ScheduleCommandHandler;

class CommandKeyboard
{
    protected array $fields = [];

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function __toString(): string
    {
        return json_encode($this->fields);
    }

    public static function getDefault(): CommandKeyboard
    {
        $keyboard = array (
            'one_time' => false,
            'buttons' => array ()
        );

        // На сегодня, на завтра
        $keyboard["buttons"][] = array (
            array (
                'action' => array (
                    'type' => 'text',
                    'label' => 'Сегодня',
                    'payload' => array (
                        'command' => ScheduleCommandHandler::TODAY_COMMAND,
                    ),
                ),
                'color' => 'primary'
            ),
            array (
                'action' => array (
                    'type' => 'text',
                    'label' => 'Завтра',
                    'payload' => array (
                        'command' => ScheduleCommandHandler::TOMORROW_COMMAND,
                    ),
                ),
                'color' => 'primary'
            )
        );
        // На эту/следующую неделю
        $keyboard["buttons"][] = array (
            array (
                'action' => array (
                    'type' => 'text',
                    'label' => 'Эта неделя',
                    'payload' => array (
                        'command' => ScheduleCommandHandler::WEEK_COMMAND,
                    ),
                ),
                'color' => 'primary'
            ),
            array (
                'action' => array (
                    'type' => 'text',
                    'label' => 'Следующая неделя',
                    'payload' => array (
                        'command' => ScheduleCommandHandler::NEXT_WEEK_COMMAND,
                    ),
                ),
                'color' => 'primary'
            )
        );
        // Изменить группу
        $keyboard["buttons"][] = array (
            array (
                'action' => array (
                    'type' => 'text',
                    'label' => 'Изменить группу',
                    'payload' => array (
                        'command' => GroupCommandHandler::CHANGE_GROUP_COMMAND,
                    ),
                ),
                'color' => 'secondary'
            )
        );
        // Справка
        $keyboard["buttons"][] = array (
            array (
                'action' => array (
                    'type' => 'text',
                    'label' => 'Справка',
                    'payload' => array (
                        'command' => HelpCommandHandler::HELP_COMMAND,
                    ),
                ),
                'color' => 'secondary'
            )
        );

        return new static ($keyboard);
    }
}