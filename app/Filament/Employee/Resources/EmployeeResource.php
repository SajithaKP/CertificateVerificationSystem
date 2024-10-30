<?php 
namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use App\Models\Education;
use App\Models\WorkExperience;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\FieldSetting;


class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Wizard::make([
    //                 Step::make('Personal Details')
    //                     ->schema([
    //                         TextInput::make('name'),
    //                         TextInput::make('age')->numeric(),
    //                         TextInput::make('email')->email(),
    //                         DatePicker::make('dob')->label('Date of Birth')->native(false),
    //                         Select::make('gender')
    //                             ->options([
    //                                 'male' => 'Male',
    //                                 'female' => 'Female',
    //                             ]),
    //                         Textarea::make('address')->rows(6)->cols(20),
    //                         FileUpload::make('image')->image(),
    //                         FileUpload::make('id_proof')->image(),
    //                     ]),
                    
    //                 Step::make('Education Details')
    //                     ->schema([
    //                         Repeater::make('educations')
    //                             ->relationship('education') // Define the relationship
    //                             ->schema([
    //                                 TextInput::make('course_name')->label('Course Name'),
    //                                 TextInput::make('college'),
    //                                 DatePicker::make('date_of_passing')->native(false),
    //                                 TextInput::make('persentage_of_mark')->label('% of mark'),
    //                                 FileUpload::make('certificate_image')->image(),
    //                             ])
    //                             ->createItemButtonLabel('Add Education')
    //                     ]),
                    
    //                 Step::make('Work Experiences')
    //                     ->schema([
    //                         Repeater::make('work_experiences')
    //                             ->relationship('workExperiences') // Define the relationship
    //                             ->schema([
    //                                 TextInput::make('company_name')->label('Company Name'),
    //                                 DatePicker::make('from_date')->native(false)->label('From Date'),
    //                                 DatePicker::make('to_date')->native(false)->label('To Date'),
    //                                 TextInput::make('years_of_experience')->numeric()->label('Years of Experience'),
    //                                 FileUpload::make('experience_image')->image(),
    //                             ])
    //                             ->createItemButtonLabel('Add Experience')
    //                     ]),
    //             ])
    //         ]);
    // }
    public static function form(Form $form): Form
    {
        // Retrieve field settings and sort by 'step_order'
        $fieldSettings = FieldSetting::all()->keyBy('field_name')->toArray();
        $sortedSteps = collect($fieldSettings)
            ->whereIn('field_name', ['Personal Details', 'Education Details', 'Work Experiences'])
            ->sortBy('step_order')
            ->keys()
            ->toArray();
    
        $stepsArray = array_filter(array_map(function ($step) use ($fieldSettings) {
            switch ($step) {
                case 'Personal Details':
                    return Step::make('Personal Details')
                        ->schema([
                            TextInput::make('name')->required(),
                            TextInput::make('age')->numeric()->disabled(!$fieldSettings['age']['is_enabled']),
                            TextInput::make('email')->email()->disabled(!$fieldSettings['email']['is_enabled']),
                            DatePicker::make('dob')->native(false)->disabled(!$fieldSettings['dob']['is_enabled']),
                            Select::make('gender')->options(['male' => 'Male', 'female' => 'Female'])->disabled(!$fieldSettings['gender']['is_enabled']),
                            Textarea::make('address')->rows(6)->disabled(!$fieldSettings['address']['is_enabled']),
                            FileUpload::make('image')->image()->disabled(!$fieldSettings['image']['is_enabled']),
                            FileUpload::make('id_proof')->image()->disabled(!$fieldSettings['id_proof']['is_enabled']),
                        ]);
    
                case 'Education Details':
                    return Step::make('Education Details')
                        ->schema([
                            Repeater::make('educations')
                                ->relationship('education')
                                ->schema([
                                    TextInput::make('course_name')->label('Course Name')->disabled(!$fieldSettings['course_name']['is_enabled']),
                                    TextInput::make('college')->disabled(!$fieldSettings['college']['is_enabled']),
                                    DatePicker::make('date_of_passing')->native(false)->disabled(!$fieldSettings['date_of_passing']['is_enabled']),
                                    TextInput::make('percentage_of_mark')->label('% of mark')->disabled(!$fieldSettings['percentage_of_mark']['is_enabled']),
                                    FileUpload::make('certificate_image')->image()->disabled(!$fieldSettings['certificate_image']['is_enabled']),
                                ])
                                ->createItemButtonLabel('Add Education'),
                        ]);
    
                case 'Work Experiences':
                    return Step::make('Work Experiences')
                        ->schema([
                            Repeater::make('work_experiences')
                                ->relationship('workExperiences')
                                ->schema([
                                    TextInput::make('company_name')->label('Company Name')->disabled(!$fieldSettings['company_name']['is_enabled']),
                                    DatePicker::make('from_date')->native(false)->label('From Date')->disabled(!$fieldSettings['from_date']['is_enabled']),
                                    DatePicker::make('to_date')->native(false)->label('To Date')->disabled(!$fieldSettings['to_date']['is_enabled']),
                                    TextInput::make('years_of_experience')->numeric()->label('Years of Experience')->disabled(!$fieldSettings['years_of_experience']['is_enabled']),
                                    FileUpload::make('experience_image')->image()->disabled(!$fieldSettings['experience_image']['is_enabled']),
                                ])
                                ->createItemButtonLabel('Add Experience'),
                        ]);
    
                default:
                    return null;
            }
        }, $sortedSteps));
    
        // Filter out null values and reindex the array
        $stepsArray = array_values($stepsArray);
    
        return $form->schema([
            Wizard::make($stepsArray)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->sortable(),
                TextColumn::make('email')->label('Email')->sortable(),
                TextColumn::make('latestEducation.course_name')->label('Qualification')->sortable(),
                TextColumn::make('latestWorkExperience.company_name')->label('Company Name')->sortable(), // This will show the latest company name
                TextColumn::make('latestWorkExperience.years_of_experience')->label('Years of Experience')->sortable(), // This will show the latest years of experience
                //TextColumn::make('latestWorkExperience.years_of_experience')->label('Years of Experience')->sortable(),
                //TextColumn::make('workExperiences.years_of_experience')->label('Years of Experience')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
