<?php

namespace App\Console\Commands;

use App\Models\Comment;
use App\Models\Department;
use App\Models\Post;

use Egal\Core\Rest\Filter\Combiner;
use Egal\Core\Rest\Filter\Field;
use Egal\Core\Rest\Filter\FieldCondition;
use Egal\Core\Rest\Filter\Operator;
use Egal\Core\Rest\Filter\Query;
use Egal\Interface\Facades\Manager;
use Egal\Interface\Metadata\Components\Table\DateFormatComputed;
use Egal\Interface\Metadata\Components\Table\DecimalPlacesComputed;
use Egal\Interface\Metadata\Components\Table\FunctionComputed;
use Egal\Interface\Metadata\Components\Table\Table;
use Egal\Interface\Metadata\Components\Table\TableDataConfiguration;
use Egal\Interface\Metadata\Components\Table\TableField;
use Egal\Interface\Metadata\Widgets\Checkbox\Checkbox;
use Egal\Interface\Metadata\Widgets\Input\Input;
use Egal\Interface\Metadata\Widgets\Input\InputInterfaceConfiguration;
use Egal\Interface\Metadata\Widgets\Input\InputSize;
use Egal\Interface\Metadata\Widgets\Select\Select;
use Egal\Interface\Metadata\Widgets\Select\SelectDataConfiguration;
use Egal\Interface\Metadata\Widgets\Select\SelectInterfaceConfiguration;
use Egal\Interface\Metadata\Widgets\Select\SelectSize;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\App;
use function Composer\Autoload\includeFile;
use function PHPUnit\Framework\callback;

class DebugCommand extends Command
{

    protected $signature = 'debug';

    public function handle(): void
    {
//        $re = '/(?<key>\w+)\s*=\s*(\'?)(?<value>(?:\w+[-+*%\']*)*?\w+)\b\2/m';
//        dump(ScopeCondition::PARAMETER_REG_PATTERN);
//        $parameters = "parameter_one=1,parameter_two='two'";
//
//        preg_match_all($re, $parameters, $matches, PREG_SET_ORDER, 0);
//
//// Print the entire match result
//        dump($matches);

//        dump(Post::query()->where('id', '=', 1)->createdAfterToday()->get()->toArray());
//        dump(Post::query()->where('id', '=', 3)->where(function (Builder $query) {
//            $query->createdAfterToday();
//        }, 'or')->get()->toArray());
//        dump(Post::createdAfterToday()->toSql());
//        dump(Post::query()->scopes('createdAfterToday')->get()->toArray());
//        dump(Post::query()->where('id', '=', 3)->createdAfterToday(Combiner::Or)->get()->toArray());

//        dump(Post::query()->join('channels', 'channels.id', 'channel_id')->selectRaw('posts.title as post, channels.title as channel')->get()->toArray());
//        dump(Post::query()->select('title')->with('channel')->get()->toArray());
//        dump(Post::query()->with('channel')->with('comments')->get()->toArray());
//        dump(Comment::query()->with('commentable:id,commentable_id')->get()->toArray());
        $component = Table::make('Сотрудники')
            ->setDataConfig(
                TableDataConfiguration::make()
                    ->setRequestModel(\App\Models\User::class)
                    ->setRequestRelations(['channel'])
                    ->setRequestFilter(
                        Query::make([
                            FieldCondition::make(Field::fromString('rate'), Operator::Equals, 2)
                        ])
                    )
                    ->setRequestOrder(['full_name', 'desc'])
                    ->setFields(
                        TableField::make('ФИО', 'full_name')
                            ->setType('string')
                            ->setSortable(true)
                            ->setFilterable(true)
                            ->setSearchable(true)
                            ->setComputed(FunctionComputed::make('toUpperCase()'))
                            ->setEditWidget(
                                Input::make('')
                                    ->setInterfaceConfig(
                                        InputInterfaceConfiguration::make()
                                            ->setValidators(['required'])
                                            ->setSize(InputSize::Lg)
                                    )
                            ),
                        TableField::make('Дата рождения', 'birth_date')
                            ->setType('date')
                            ->setSortable(true)
                            ->setFilterable(true)
                            ->setComputed(DateFormatComputed::make('dd-MM-yy'))
                            ->setEditWidget(
                                Input::make('')
                                    ->setInterfaceConfig(
                                        InputInterfaceConfiguration::make()
                                            ->setValidators(['date'])
                                            ->setSize(InputSize::Lg),
                                    )
                            ),
                        TableField::make('Статус', 'is_active')
                            ->setType('bool')
                            ->setSortable(true)
                            ->setEditWidget(Checkbox::make('')),
                        TableField::make('Ставка', 'rate')
                            ->setType('float')
                            ->setComputed(DecimalPlacesComputed::make(2))
                            ->setEditWidget(
                                Input::make('')
                                    ->setInterfaceConfig(
                                        InputInterfaceConfiguration::make()
                                            ->setSize(InputSize::Lg)
                                    )
                            ),
                        TableField::make('Отдел', 'departments.name')
                            ->setType('string[]')
                            ->setFilterable(true)
                            ->setComputed(FunctionComputed::make('toLowerCase()'))
                            ->setEditWidget(
                                Select::make('')
                                    ->setInterfaceConfig(
                                        SelectInterfaceConfiguration::make()
                                            ->setSize(SelectSize::Lg)
                                    )
                                    ->setDataConfig(
                                        SelectDataConfiguration::make()
                                            ->setRequestModel(Department::class)
                                    )
                            )
                    )
            );

//        dump($component->toArray());
        includeFile(base_path('./interfaces/components.php'));
        dump(Manager::getComponents());
    }

}
