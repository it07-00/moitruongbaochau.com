<?php

namespace App\Filament\Resources\Pages;

use App\ContentStatus;
use App\Filament\Forms\Components\SeoSection;
use App\Filament\Resources\Pages\Pages\CreatePage;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Models\Page;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentDuplicate;

    protected static string|UnitEnum|null $navigationGroup = 'Nội dung khác';

    protected static ?string $navigationLabel = 'Cấu hình các Trang';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return 'Trang';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cấu hình các Trang';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // 1. THÔNG TIN CƠ BẢN CỦA TRANG
                Section::make('Thông tin chung của trang')
                    ->description('Cấu hình định danh, giao diện mẫu và trạng thái hiển thị')
                    ->components([
                        TextInput::make('title')
                            ->label('Tiêu đề trang')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, ?string $state, callable $set, callable $get) {
                                if ($operation === 'create' || blank($get('slug'))) {
                                    $set('slug', Str::slug($state));
                                }
                                if (blank($get('meta_title'))) {
                                    $set('meta_title', $state);
                                }
                                if (blank($get('og_title'))) {
                                    $set('og_title', $state);
                                }
                            }),
                        TextInput::make('slug')
                            ->label('Đường dẫn tĩnh (Slug)')
                            ->required()
                            ->maxLength(255)
                            ->unique(Page::class, 'slug', ignoreRecord: true),
                        Select::make('template')
                            ->label('Giao diện mẫu (Template)')
                            ->options([
                                'home' => '🏠 1. Trang Chủ (Home Page)',
                                'about' => '🏢 2. Trang Giới thiệu (About Us)',
                                'services' => '🛠️ 3. Trang Dịch vụ (Services Index)',
                                'projects' => '🏗️ 4. Trang Dự án (Projects Index)',
                                'posts' => '📰 5. Trang Tin tức (News Index)',
                                'recruitment' => '💼 6. Trang Tuyển dụng (Recruitment Index)',
                                'contact' => '📞 7. Trang Liên hệ (Contact Us)',
                                'default' => '📄 8. Trang Mặc định (Standard Content Page)',
                            ])
                            ->default('default')
                            ->live()
                            ->required(),
                        Select::make('status')
                            ->label('Trạng thái')
                            ->options(ContentStatus::class)
                            ->default(ContentStatus::Published->value)
                            ->required(),
                        FileUpload::make('thumbnail')
                            ->label('Ảnh đại diện / Banner trang')
                            ->image()
                            ->directory('uploads/pages'),
                        DateTimePicker::make('published_at')
                            ->label('Ngày xuất bản')
                            ->default(now()),
                        Textarea::make('excerpt')
                            ->label('Mô tả tóm tắt ngắn')
                            ->rows(3)
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set, callable $get) {
                                if (filled($state)) {
                                    $clean = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($state))), 160, '');
                                    if (blank($get('meta_description'))) {
                                        $set('meta_description', $clean);
                                    }
                                    if (blank($get('og_description'))) {
                                        $set('og_description', $clean);
                                    }
                                }
                            }),
                        RichEditor::make('content')
                            ->label('Nội dung chi tiết trang')
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (?string $state, callable $set, callable $get) {
                                if (blank($get('meta_description')) && filled($state)) {
                                    $clean = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($state))), 160, '');
                                    $set('meta_description', $clean);
                                    if (blank($get('og_description'))) {
                                        $set('og_description', $clean);
                                    }
                                }
                            }),
                    ])->columns(2),

                // 2. CẤU HÌNH TRANG CHỦ (TEMPLATE: HOME)
                Section::make('Cấu hình Khối Giới thiệu Trang Chủ')
                    ->description('Tùy chỉnh huy hiệu, nội dung giới thiệu và nút liên kết trên trang chủ')
                    ->visible(fn ($get) => in_array($get('template'), ['home'], true) || $get('slug') === 'trang-chu')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.about_badge')->label('Huy hiệu (Badge)')->default('Về chúng tôi'),
                        TextInput::make('metadata.about_link')->label('Đường dẫn nút xem thêm')->default('/gioi-thieu'),
                        Textarea::make('metadata.about_desc_1')->label('Đoạn văn giới thiệu 1')->rows(2)->columnSpanFull(),
                        Textarea::make('metadata.about_desc_2')->label('Đoạn văn giới thiệu 2')->rows(2)->columnSpanFull(),
                        Textarea::make('metadata.about_desc_3')->label('Đoạn văn giới thiệu 3')->rows(2)->columnSpanFull(),
                    ])->columns(2),

                Section::make('Cấu hình 3 Số liệu Thống kê Trang Chủ (Counters)')
                    ->description('Tùy chỉnh các con số và văn bản thống kê nổi bật')
                    ->visible(fn ($get) => in_array($get('template'), ['home'], true) || $get('slug') === 'trang-chu')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.stat_1_number')->label('Số liệu 1 (Số)')->default('7'),
                        TextInput::make('metadata.stat_1_suffix')->label('Hậu tố 1')->default('+'),
                        TextInput::make('metadata.stat_1_title')->label('Tiêu đề 1')->default('Năm kinh nghiệm'),
                        Textarea::make('metadata.stat_1_desc')->label('Mô tả số liệu 1')->rows(2)->columnSpanFull(),

                        TextInput::make('metadata.stat_2_number')->label('Số liệu 2 (Số)')->default('500'),
                        TextInput::make('metadata.stat_2_suffix')->label('Hậu tố 2')->default('+'),
                        TextInput::make('metadata.stat_2_title')->label('Tiêu đề 2')->default('Dự án đã hoàn thành'),
                        Textarea::make('metadata.stat_2_desc')->label('Mô tả số liệu 2')->rows(2)->columnSpanFull(),

                        TextInput::make('metadata.stat_3_number')->label('Số liệu 3 (Số)')->default('30'),
                        TextInput::make('metadata.stat_3_suffix')->label('Hậu tố 3')->default('+'),
                        TextInput::make('metadata.stat_3_title')->label('Tiêu đề 3')->default('Chuyên gia & Kỹ sư'),
                        Textarea::make('metadata.stat_3_desc')->label('Mô tả số liệu 3')->rows(2)->columnSpanFull(),
                    ])->columns(3),

                Section::make('Cấu hình Tiêu đề các phân đoạn khác trên Trang Chủ')
                    ->description('Tùy chỉnh tiêu đề và huy hiệu của các khối Dịch vụ, Dự án, Đánh giá và Tin tức')
                    ->visible(fn ($get) => in_array($get('template'), ['home'], true) || $get('slug') === 'trang-chu')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.services_badge')->label('Huy hiệu khối Dịch vụ')->default('DỊCH VỤ MÔI TRƯỜNG'),
                        TextInput::make('metadata.services_title')->label('Tiêu đề khối Dịch vụ')->default('Dịch vụ môi trường tiêu biểu'),
                        TextInput::make('metadata.projects_badge')->label('Huy hiệu khối Dự án')->default('DỰ ÁN TIÊU BIỂU'),
                        TextInput::make('metadata.projects_title')->label('Tiêu đề khối Dự án')->default('Dự án đã thực hiện'),
                        TextInput::make('metadata.testimonials_badge')->label('Huy hiệu khối Đánh giá')->default('ĐÁNH GIÁ KHÁCH HÀNG'),
                        TextInput::make('metadata.testimonials_title')->label('Tiêu đề khối Đánh giá')->default('Khách hàng nói gì về Bảo Châu'),
                        TextInput::make('metadata.posts_badge')->label('Huy hiệu khối Tin tức')->default('TIN TỨC MỚI NHẤT'),
                        TextInput::make('metadata.posts_title')->label('Tiêu đề khối Tin tức')->default('Tin tức & Kiến thức môi trường'),
                    ])->columns(2),

                // 3. CẤU HÌNH TRANG GIỚI THIỆU (TEMPLATE: ABOUT)
                Section::make('Cấu hình Khối: Tầm nhìn & Sứ mệnh (Vision & Mission)')
                    ->description('Tùy chỉnh nội dung khối Tầm nhìn và 4 thẻ Sứ mệnh trên trang Giới thiệu')
                    ->visible(fn ($get) => in_array($get('template'), ['about'], true) || $get('slug') === 'gioi-thieu')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.vision_badge')
                            ->label('Huy hiệu (Badge)')
                            ->default('TẦM NHÌN & SỨ MỆNH'),
                        TextInput::make('metadata.vision_title')
                            ->label('Tiêu đề chính')
                            ->default('<span class="text-primary block">MÔI TRƯỜNG BẢO CHÂU</span> Kiến tạo biểu tượng phát triển bền vững')
                            ->columnSpanFull(),
                        Textarea::make('metadata.vision_desc_1')
                            ->label('Mô tả tầm nhìn (Đoạn 1)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('metadata.vision_desc_2')
                            ->label('Mô tả tầm nhìn (Đoạn 2)')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('metadata.mission_1_title')->label('Sứ mệnh 1 - Tiêu đề')->default('Đối với khách hàng'),
                        Textarea::make('metadata.mission_1_desc')->label('Sứ mệnh 1 - Nội dung')->rows(2),

                        TextInput::make('metadata.mission_2_title')->label('Sứ mệnh 2 - Tiêu đề')->default('Đối với đối tác'),
                        Textarea::make('metadata.mission_2_desc')->label('Sứ mệnh 2 - Nội dung')->rows(2),

                        TextInput::make('metadata.mission_3_title')->label('Sứ mệnh 3 - Tiêu đề')->default('Đối với nhân viên'),
                        Textarea::make('metadata.mission_3_desc')->label('Sứ mệnh 3 - Nội dung')->rows(2),

                        TextInput::make('metadata.mission_4_title')->label('Sứ mệnh 4 - Tiêu đề')->default('Đối với cộng đồng'),
                        Textarea::make('metadata.mission_4_desc')->label('Sứ mệnh 4 - Nội dung')->rows(2),
                    ])->columns(2),

                Section::make('Cấu hình Khối: Sơ đồ Cơ cấu Tổ chức (Org Chart)')
                    ->description('Tùy chỉnh cơ cấu bộ máy lãnh đạo, phòng ban và các bộ phận chuyên trách')
                    ->visible(fn ($get) => in_array($get('template'), ['about'], true) || $get('slug') === 'gioi-thieu')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.org_badge')
                            ->label('Huy hiệu (Badge)')
                            ->default('SƠ ĐỒ BỘ MÁY'),
                        TextInput::make('metadata.org_title')
                            ->label('Tiêu đề khối')
                            ->default('CƠ CẤU <span class="text-primary">TỔ CHỨC</span>'),
                        TextInput::make('metadata.org_director')
                            ->label('Cấp lãnh đạo cao nhất')
                            ->default('GIÁM ĐỐC')
                            ->columnSpanFull(),

                        TextInput::make('metadata.org_dept_1')->label('Khối 1 - Phòng ban')->default('PHÒNG KỸ THUẬT'),
                        TextInput::make('metadata.org_dept_1_sub1')->label('Khối 1 - Bộ phận trực thuộc 1')->default('Bộ phận Quan trắc'),
                        TextInput::make('metadata.org_dept_1_sub2')->label('Khối 1 - Bộ phận trực thuộc 2')->default('Bộ phận Tư vấn'),

                        TextInput::make('metadata.org_dept_2')->label('Khối 2 - Phòng ban')->default('PHÒNG KINH DOANH'),
                        TextInput::make('metadata.org_dept_2_sub1')->label('Khối 2 - Bộ phận trực thuộc')->default('Bộ phận Kinh doanh'),

                        TextInput::make('metadata.org_dept_3')->label('Khối 3 - Phòng ban')->default('PHÒNG TỔNG HỢP'),
                        TextInput::make('metadata.org_dept_3_sub1')->label('Khối 3 - Bộ phận trực thuộc 1')->default('BP HC – Nhân sự'),
                        TextInput::make('metadata.org_dept_3_sub2')->label('Khối 3 - Bộ phận trực thuộc 2')->default('BP TC – Kế toán'),
                    ])->columns(3),

                Section::make('Cấu hình Khối: Lịch sử Hình thành & Phát triển (Timeline)')
                    ->description('Tùy chỉnh các cột mốc năm và thành tựu phát triển của công ty')
                    ->visible(fn ($get) => in_array($get('template'), ['about'], true) || $get('slug') === 'gioi-thieu')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.timeline_badge')
                            ->label('Huy hiệu (Badge)')
                            ->default('HÀNH TRÌNH PHÁT TRIỂN'),
                        TextInput::make('metadata.timeline_title')
                            ->label('Tiêu đề khối')
                            ->default('Lịch sử <span class="text-primary">hình thành & phát triển</span>'),
                        Textarea::make('metadata.timeline_desc')
                            ->label('Mô tả chung hành trình')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('metadata.timeline_1_year')->label('Mốc 1 - Năm')->default('2018'),
                        TextInput::make('metadata.timeline_1_title')->label('Mốc 1 - Tiêu đề')->default('Thành lập công ty'),
                        Textarea::make('metadata.timeline_1_desc')->label('Mốc 1 - Nội dung')->rows(3)->columnSpanFull(),

                        TextInput::make('metadata.timeline_2_year')->label('Mốc 2 - Năm')->default('2020'),
                        TextInput::make('metadata.timeline_2_title')->label('Mốc 2 - Tiêu đề')->default('Chuẩn hóa Luật BVMT 2020'),
                        Textarea::make('metadata.timeline_2_desc')->label('Mốc 2 - Nội dung')->rows(3)->columnSpanFull(),

                        TextInput::make('metadata.timeline_3_year')->label('Mốc 3 - Năm')->default('2022'),
                        TextInput::make('metadata.timeline_3_title')->label('Mốc 3 - Tiêu đề')->default('Mở rộng Kỹ thuật & Xử lý nước'),
                        Textarea::make('metadata.timeline_3_desc')->label('Mốc 3 - Nội dung')->rows(3)->columnSpanFull(),

                        TextInput::make('metadata.timeline_4_year')->label('Mốc 4 - Năm')->default('2024 – 2026'),
                        TextInput::make('metadata.timeline_4_title')->label('Mốc 4 - Tiêu đề')->default('Khí nhà kính & Chiến lược ESG'),
                        Textarea::make('metadata.timeline_4_desc')->label('Mốc 4 - Nội dung')->rows(3)->columnSpanFull(),
                    ])->columns(2),

                // 4. CẤU HÌNH TRANG LIÊN HỆ (TEMPLATE: CONTACT)
                Section::make('Cấu hình 3 Thẻ Tư vấn Nhanh (Consultation Cards)')
                    ->description('Tùy chỉnh 3 thẻ giới thiệu dịch vụ tư vấn trọng điểm trên trang Liên hệ')
                    ->visible(fn ($get) => in_array($get('template'), ['contact'], true) || $get('slug') === 'lien-he')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.contact_badge')->label('Huy hiệu trang liên hệ')->default('BẠN ĐANG CẦN GIẢI PHÁP PHÙ HỢP?')->columnSpanFull(),

                        TextInput::make('metadata.card_1_title')->label('Thẻ 1 - Tiêu đề')->default('Tư vấn hồ sơ & Giấy phép MT')->columnSpanFull(),
                        Textarea::make('metadata.card_1_desc_1')->label('Thẻ 1 - Đoạn mô tả 1')->rows(2),
                        Textarea::make('metadata.card_1_desc_2')->label('Thẻ 1 - Đoạn mô tả 2')->rows(2),

                        TextInput::make('metadata.card_2_title')->label('Thẻ 2 - Tiêu đề')->default('Kiểm kê Khí nhà kính – ESG – CBAM')->columnSpanFull(),
                        Textarea::make('metadata.card_2_desc_1')->label('Thẻ 2 - Đoạn mô tả 1')->rows(2),
                        Textarea::make('metadata.card_2_desc_2')->label('Thẻ 2 - Đoạn mô tả 2')->rows(2),

                        TextInput::make('metadata.card_3_title')->label('Thẻ 3 - Tiêu đề')->default('Xử lý Nước thải & Khí thải')->columnSpanFull(),
                        Textarea::make('metadata.card_3_desc_1')->label('Thẻ 3 - Đoạn mô tả 1')->rows(2),
                        Textarea::make('metadata.card_3_desc_2')->label('Thẻ 3 - Đoạn mô tả 2')->rows(2),
                    ])->columns(2),

                // 5. CẤU HÌNH TRANG TUYỂN DỤNG (TEMPLATE: RECRUITMENT)
                Section::make('Cấu hình Phúc lợi & Văn hóa Doanh nghiệp')
                    ->description('Tùy chỉnh 4 giá trị văn hóa và phúc lợi nổi bật trên trang Tuyển dụng')
                    ->visible(fn ($get) => in_array($get('template'), ['recruitment'], true) || $get('slug') === 'tuyen-dung')
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.recruitment_badge')->label('Huy hiệu trang tuyển dụng')->default('CƠ HỘI NGHỀ NGHIỆP')->columnSpanFull(),
                        TextInput::make('metadata.benefits_title')->label('Tiêu đề khối Phúc lợi')->default('Vì sao nên gia nhập Môi Trường Bảo Châu?')->columnSpanFull(),
                        Textarea::make('metadata.benefits_desc')->label('Mô tả khối Phúc lợi')->rows(2)->columnSpanFull(),

                        TextInput::make('metadata.benefit_1_title')->label('Phúc lợi 1 - Tiêu đề')->default('Thu nhập & Thưởng hấp dẫn'),
                        Textarea::make('metadata.benefit_1_desc')->label('Phúc lợi 1 - Chi tiết')->rows(2),

                        TextInput::make('metadata.benefit_2_title')->label('Phúc lợi 2 - Tiêu đề')->default('Đào tạo & Thăng tiến rõ ràng'),
                        Textarea::make('metadata.benefit_2_desc')->label('Phúc lợi 2 - Chi tiết')->rows(2),

                        TextInput::make('metadata.benefit_3_title')->label('Phúc lợi 3 - Tiêu đề')->default('Môi trường năng động & Trẻ trung'),
                        Textarea::make('metadata.benefit_3_desc')->label('Phúc lợi 3 - Chi tiết')->rows(2),

                        TextInput::make('metadata.benefit_4_title')->label('Phúc lợi 4 - Tiêu đề')->default('Chế độ phúc lợi toàn diện'),
                        Textarea::make('metadata.benefit_4_desc')->label('Phúc lợi 4 - Chi tiết')->rows(2),
                    ])->columns(2),

                // 6. CẤU HÌNH TRANG DỊCH VỤ / DỰ ÁN / TIN TỨC (TEMPLATE: SERVICES, PROJECTS, POSTS)
                Section::make('Cấu hình Khối Kêu gọi Hành động (CTA)')
                    ->description('Tùy chỉnh khối Banner kêu gọi tư vấn ở cuối trang Dịch vụ / Dự án')
                    ->visible(fn ($get) => in_array($get('template'), ['services', 'projects'], true) || in_array($get('slug'), ['dich-vu', 'du-an'], true))
                    ->collapsible()
                    ->components([
                        TextInput::make('metadata.services_badge')->label('Huy hiệu đầu trang')->default('DỊCH VỤ CỦA CHÚNG TÔI')->visible(fn ($get) => in_array($get('template'), ['services'], true) || $get('slug') === 'dich-vu'),
                        TextInput::make('metadata.projects_badge')->label('Huy hiệu đầu trang')->default('DỰ ÁN TIÊU BIỂU & HỒ SƠ NĂNG LỰC')->visible(fn ($get) => in_array($get('template'), ['projects'], true) || $get('slug') === 'du-an'),
                        TextInput::make('metadata.cta_title')->label('Tiêu đề CTA')->default('Cần tư vấn giải pháp môi trường tối ưu cho doanh nghiệp?')->columnSpanFull(),
                        Textarea::make('metadata.cta_desc')->label('Mô tả CTA')->rows(2)->columnSpanFull(),
                        TextInput::make('metadata.cta_button_text')->label('Chữ trên nút bấm')->default('Liên hệ tư vấn ngay'),
                        TextInput::make('metadata.cta_phone')->label('Hotline CTA')->default('0915 549 148'),
                    ])->columns(2),

                // 7. SEO META CHUYÊN SÂU TỪNG TRANG
                SeoSection::make(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Ảnh')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->thumbnail ? (str_starts_with($record->thumbnail, 'http') ? $record->thumbnail : (str_starts_with($record->thumbnail, 'uploads/') ? asset('storage/'.$record->thumbnail) : asset($record->thumbnail))) : null),
                TextColumn::make('title')
                    ->label('Tiêu đề trang')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => '/'.ltrim($record->slug, '/')),
                TextColumn::make('template')
                    ->label('Template')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'home' => 'success',
                        'about' => 'primary',
                        'services' => 'warning',
                        'projects' => 'info',
                        'posts' => 'secondary',
                        'recruitment' => 'danger',
                        'contact' => 'gray',
                        default => 'info',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'home' => 'Trang Chủ',
                        'about' => 'Trang Giới thiệu',
                        'services' => 'Trang Dịch vụ',
                        'projects' => 'Trang Dự án',
                        'posts' => 'Trang Tin tức',
                        'recruitment' => 'Trang Tuyển dụng',
                        'contact' => 'Trang Liên hệ',
                        default => 'Trang Tĩnh',
                    }),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge(),
                TextColumn::make('updated_at')
                    ->label('Cập nhật lần cuối')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('template')
                    ->label('Lọc theo Template')
                    ->options([
                        'home' => 'Trang Chủ',
                        'about' => 'Trang Giới thiệu',
                        'services' => 'Trang Dịch vụ',
                        'projects' => 'Trang Dự án',
                        'posts' => 'Trang Tin tức',
                        'recruitment' => 'Trang Tuyển dụng',
                        'contact' => 'Trang Liên hệ',
                        'default' => 'Trang Mặc định',
                    ]),
                SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options(ContentStatus::class),
            ])
            ->defaultSort('id', 'asc')
            ->recordActions([
                Action::make('view_page')
                    ->label('Xem trang')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->url(fn (Page $record): string => $record->getPublicUrl())
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }
}
