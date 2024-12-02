<?php

namespace App\Filament\Resources;

use App\Enums\OwnerTypeEnum;
use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers\WeaponsRelationManager;
use App\Models\Owner;
use App\Models\OwnerType;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Tabs;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OwnerResource\RelationManagers\RekomsRelationManager;
use App\Services\RekomServices\CommonRekomService;
use Storage;

class OwnerResource extends Resource
{
    protected static ?string $model = Owner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['rekoms'])
            ->whereHas('rekoms', function ($query) {
                $rekoms = new CommonRekomService();
                return $query->where('role_id', $rekoms->getRekomRoleId());
            });
    }


    public static function form(Form $form): Form
    {

        $defaultOwnerTypeId = OwnerType::where('name', OwnerTypeEnum::INDIVIDUAL->value())->first()->id;

        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Data Kepemilikan')->schema([
                            Grid::make()->schema([
                                BelongsToSelect::make('ownerType')
                                    ->label('Jenis Kepemilikan')
                                    ->relationship('ownerType', 'name')
                                    ->default($defaultOwnerTypeId)
                                    ->disabled()
                                    ->required()
                                    ->hidden(),

                                TextInput::make('name')
                                    ->placeholder('ex: John Doe')
                                    ->required(),

                                TextInput::make('no_ktp')
                                    ->label('Nomor KTP')
                                    ->numeric()
                                    ->placeholder('ex: 9999999999999999')
                                    ->required(),

                                TextInput::make('address')
                                    ->label('Alamat')
                                    ->placeholder('ex: Jalan Raya No. 1')
                                    ->required(),

                                TextInput::make('phone')
                                    ->label('Nomor Telepon')
                                    ->placeholder('ex: 08123456789')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('job')
                                    ->label('Pekerjaan')
                                    ->placeholder('ex: Pegawai Swasta')
                                    ->required(),

                            ]),


                        ]),
                        Tab::make('Dokumen Kepemilikan')->schema([
                            Grid::make(3)->schema([
                                FileUpload::make('ktp_attachment')
                                    ->label('KTP'),
                                FileUpload::make('npwp')
                                    ->label('NPWP'),
                                FileUpload::make('ksk')
                                    ->label('KSK'),
                                FileUpload::make('skep_jabatan')
                                    ->label('Skep Jabatan'),
                                FileUpload::make('kta')
                                    ->label('KTA'),
                                FileUpload::make('si_impor')
                                    ->label('Surat Ijin Impor')

                            ]),

                        ]),
                        Tab::make('Dokumen Hasil Tes')
                            ->schema([
                                Grid::make(3)->schema([
                                    FileUpload::make('health_certificate')
                                        ->label('Hasil Tes Kesehatan'),
                                    FileUpload::make('psychological_certificate')
                                        ->label('Hasil Tes Psikologi'),
                                    FileUpload::make('shooting_certificate')
                                        ->label('Hasil Tes Menembak'),



                                ])
                            ])
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_ktp')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),
                Tables\Columns\TextColumn::make('address')->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Ubah'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
                //
            RekomsRelationManager::class,
            WeaponsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOwners::route('/'),
            'create' => Pages\CreateOwner::route('/create'),
            'edit' => Pages\EditOwner::route('/{record}/edit'),
        ];
    }
}
