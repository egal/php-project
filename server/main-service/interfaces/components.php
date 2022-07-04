<?php

use App\Models\Department;
use Egal\Core\Rest\Filter\Field;
use Egal\Core\Rest\Filter\FieldCondition;
use Egal\Core\Rest\Filter\Operator;
use Egal\Core\Rest\Filter\Query;
use Egal\Interface\Facades\Manager;
use Egal\Interface\Metadata\Components\Table\Computed\DateFormatComputed;
use Egal\Interface\Metadata\Components\Table\Computed\DecimalPlacesComputed;
use Egal\Interface\Metadata\Components\Table\Computed\FunctionComputed;
use Egal\Interface\Metadata\Components\Table\FieldType;
use Egal\Interface\Metadata\Components\Table\Table;
use Egal\Interface\Metadata\Components\Table\TableDataConfiguration;
use Egal\Interface\Metadata\Components\Table\TableField;
use Egal\Interface\Metadata\Components\Table\TableInterfaceConfiguration;
use Egal\Interface\Metadata\Widgets\Checkbox\Checkbox;
use Egal\Interface\Metadata\Widgets\Checkbox\CheckboxInterfaceConfiguration;
use Egal\Interface\Metadata\Widgets\Input\Input;
use Egal\Interface\Metadata\Widgets\Input\InputInterfaceConfiguration;
use Egal\Interface\Metadata\Widgets\Input\InputSize;
use Egal\Interface\Metadata\Widgets\Select\Select;
use Egal\Interface\Metadata\Widgets\Select\SelectDataConfiguration;
use Egal\Interface\Metadata\Widgets\Select\SelectInterfaceConfiguration;
use Egal\Interface\Metadata\Widgets\Select\SelectSize;

Manager::component(Table::make(
    'Сотрудники',
    TableInterfaceConfiguration::make(),
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
            TableField::make('ФИО', 'full_name', FieldType::String)
                ->setSortable(true)
                ->setFilterable(true)
                ->setSearchable(true)
                ->setComputed(FunctionComputed::make('toUpperCase()'))
                ->setEditWidget(
                    Input::make(
                        '',
                        InputInterfaceConfiguration::make()
                            ->setValidators(['required'])
                            ->setSize(InputSize::Lg))
                ),
            TableField::make('Дата рождения', 'birth_date', FieldType::Date)
                ->setSortable(true)
                ->setFilterable(true)
                ->setComputed(DateFormatComputed::make('dd-MM-yy'))
                ->setEditWidget(
                    Input::make(
                        '',
                        InputInterfaceConfiguration::make()
                            ->setValidators(['date'])
                            ->setSize(InputSize::Lg)
                    )
                ),
            TableField::make('Статус', 'is_active', FieldType::Boolean)
                ->setSortable(true)
                ->setEditWidget(Checkbox::make('', CheckboxInterfaceConfiguration::make())),
            TableField::make('Ставка', 'rate', FieldType::Numeric)
                ->setComputed(DecimalPlacesComputed::make(2))
                ->setEditWidget(
                    Input::make(
                        '',
                        InputInterfaceConfiguration::make()
                            ->setSize(InputSize::Lg)
                    )
                ),
            TableField::make('Отдел', 'departments.name', FieldType::ArrayOfString)
                ->setFilterable(true)
                ->setComputed(FunctionComputed::make('toLowerCase()'))
                ->setEditWidget(
                    Select::make(
                        '',
                        SelectInterfaceConfiguration::make()
                            ->setSize(SelectSize::Lg),
                        SelectDataConfiguration::make()
                            ->setRequestModel(Department::class)
                    )
                )
        )
));
