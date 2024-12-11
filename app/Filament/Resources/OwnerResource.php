<?php

namespace App\Filament\Resources;

use App\Enums\OwnerTypeEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\OwnerResource\Pages;
use App\Filament\Resources\OwnerResource\RelationManagers\MembersRelationManager;
use App\Filament\Resources\OwnerResource\RelationManagers\WeaponsRelationManager;
use App\Models\Owner;
use App\Models\OwnerType;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
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
use Filament\Forms\Get;

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
        $auth_user = auth()->user();

    
        $is_company = $auth_user->hasRole(RoleEnum::POLSUS->value()) || $auth_user->hasRole(RoleEnum::HANDAK->value()) ? true : false;

        return $form
            ->schema([
                Fieldset::make($is_company ? 'Informasi Instansi / Perusahaan':'Informasi Pribadi')
                ->schema([
                TextInput::make('name')
                    ->placeholder('ex: John Doe')
                    ->required(),
                // TextInput::make('weapons'),
                TextInput::make('no_ktp')
                    ->label('Nomor KTP')
                    ->hidden($is_company)
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
                    ->label('Pekerjaan / Bidang Usaha')
                    ->placeholder('ex: Pegawai Swasta')
                    ->required(),
                ]),

                Tabs::make('attachment')
                    ->visible(auth()->user()->hasRole(RoleEnum::BELADIRI->value()))
                    ->columnSpanFull()
                    ->tabs([
                        
                        Tab::make('Dokumen Kepemilikan')
                        ->schema([
                            Grid::make(3)->schema([
                                FileUpload::make('file_ktp')
                                    ->label('KTP'),
                                FileUpload::make('file_npwp')
                                    ->label('NPWP'),
                                FileUpload::make('file_ksk')
                                    ->label('KSK'),
                                FileUpload::make('file_skep_jabatan')
                                    ->label('Skep Jabatan'),
                                FileUpload::make('file_kta')
                                    ->label('KTA'),
                                FileUpload::make('file_surat_ijin_impor')
                                    ->label('Surat Ijin Impor')

                            ]),

                        ]),
                        Tab::make('Dokumen Hasil Tes')
                            ->schema([
                                Grid::make(3)->schema([
                                    FileUpload::make('file_tes_kesehatan')
                                        ->label('Hasil Tes Kesehatan'),
                                    FileUpload::make('file_tes_psikologi')
                                        ->label('Hasil Tes Psikologi'),
                                    FileUpload::make('file_tes_menembak')
                                        ->label('Hasil Tes Menembak'),



                                ])
                            ])
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        $auth_user = auth()->user();

        $ktp_roles = $auth_user->hasRole(RoleEnum::POLSUS->value()) || $auth_user->hasRole(RoleEnum::HANDAK->value()) ? true : false;

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_ktp')->searchable()
                ->hidden($ktp_roles)
                ->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ownerType.name')->badge(),
                Tables\Columns\TextColumn::make('address')->searchable(),
                Tables\Columns\TextColumn::make('phone')->searchable(),

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
            MembersRelationManager::class
            
            // AttachmentRelationManager::class

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
