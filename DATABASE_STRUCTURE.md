# LadyLingo Database Structure

## Created Migrations

1. **users** (updated existing migration)
   - Added `role` enum ('user', 'translator', 'admin') - default: 'user'
   - Added `status` enum ('active', 'blocked') - default: 'active'

2. **available_languages**
   - `id` (primary key)
   - `lang_name` varchar

3. **translator_portfolios**
   - `id` (primary key)
   - `user_id` (foreign key to users)
   - `bio` text (nullable)
   - `profile_image_url` varchar (nullable)
   - `total_earnings` decimal(10,2) - default: 0
   - `average_rating` decimal(3,2) - default: 0

4. **works**
   - `id` (primary key)
   - `title` varchar
   - `original_language_id` (foreign key to available_languages)
   - `author_name` varchar
   - `created_at`, `updated_at` timestamps

5. **uploads**
   - `id` (primary key)
   - `translator_id` (foreign key to translator_portfolios)
   - `translation_id` (foreign key to translations, nullable)
   - `file_path` varchar
   - `created_at`, `updated_at` timestamps

6. **translations**
   - `id` (primary key)
   - `work_id` (foreign key to works)
   - `translator_id` (foreign key to translator_portfolios)
   - `language_id` (foreign key to available_languages)
   - `status` enum ('draft', 'published', 'blocked') - default: 'draft'
   - `price` decimal(10,2)
   - `upload_id` (foreign key to uploads, nullable)
   - `preview_pages_cnt` integer
   - `created_at`, `updated_at` timestamps

7. **ratings**
   - `id` (primary key)
   - `translation_id` (foreign key to translations)
   - `user_id` (foreign key to users)
   - `stars` integer
   - `comment` text (nullable)
   - `created_at` timestamp

8. **comments**
   - `id` (primary key)
   - `translation_id` (foreign key to translations)
   - `user_id` (foreign key to users)
   - `content` text
   - `created_at`, `updated_at` timestamps

9. **orders**
   - `id` (primary key)
   - `user_id` (foreign key to users)
   - `translator_id` (foreign key to translator_portfolios)
   - `work_id` (foreign key to works)
   - `language_id` (foreign key to available_languages)
   - `status` enum ('pending', 'accepted', 'rejected', 'in_progress', 'completed', 'cancelled') - default: 'pending'
   - `deadline` datetime
   - `created_at`, `updated_at` timestamps

## Created Models with Relationships

### User Model
- **Relationships:**
  - `hasOne(TranslatorPortfolio::class)`
  - `hasMany(Rating::class)`
  - `hasMany(Comment::class)`
  - `hasMany(Order::class)`
- **Helper Methods:**
  - `isTranslator()`
  - `isAdmin()`

### AvailableLanguage Model
- **Relationships:**
  - `hasMany(Work::class, 'original_language_id')`
  - `hasMany(Translation::class, 'language_id')`
  - `hasMany(Order::class, 'language_id')`

### Work Model
- **Relationships:**
  - `belongsTo(AvailableLanguage::class, 'original_language_id')`
  - `hasMany(Translation::class)`
  - `hasMany(Order::class)`

### TranslatorPortfolio Model
- **Relationships:**
  - `belongsTo(User::class)`
  - `hasMany(Translation::class, 'translator_id')`
  - `hasMany(Upload::class, 'translator_id')`
  - `hasMany(Order::class, 'translator_id')`

### Translation Model
- **Relationships:**
  - `belongsTo(Work::class)`
  - `belongsTo(TranslatorPortfolio::class, 'translator_id')`
  - `belongsTo(AvailableLanguage::class, 'language_id')`
  - `belongsTo(Upload::class)`
  - `hasMany(Rating::class)`
  - `hasMany(Comment::class)`

### Rating Model
- **Relationships:**
  - `belongsTo(Translation::class)`
  - `belongsTo(User::class)`

### Comment Model
- **Relationships:**
  - `belongsTo(Translation::class)`
  - `belongsTo(User::class)`

### Order Model
- **Relationships:**
  - `belongsTo(User::class)`
  - `belongsTo(TranslatorPortfolio::class, 'translator_id')`
  - `belongsTo(Work::class)`
  - `belongsTo(AvailableLanguage::class, 'language_id')`

### Upload Model
- **Relationships:**
  - `belongsTo(TranslatorPortfolio::class, 'translator_id')`
  - `belongsTo(Translation::class)`

## Database Seeder

Created `LanguageSeeder` with sample languages:
- English, Spanish, French, German, Italian
- Portuguese, Russian, Chinese, Japanese, Korean

## Status

✅ All migrations created and run successfully
✅ All models created with proper relationships
✅ No syntax errors detected
✅ Sample data seeder created

## Usage Examples

```php
// Create a new translator portfolio
$user = User::find(1);
$portfolio = $user->translatorPortfolio()->create([
    'bio' => 'Professional translator with 5 years experience',
    'total_earnings' => 0,
    'average_rating' => 0
]);

// Create a work
$language = AvailableLanguage::where('lang_name', 'English')->first();
$work = Work::create([
    'title' => 'Sample Book',
    'original_language_id' => $language->id,
    'author_name' => 'John Doe'
]);

// Create a translation
$translation = Translation::create([
    'work_id' => $work->id,
    'translator_id' => $portfolio->id,
    'language_id' => AvailableLanguage::where('lang_name', 'Spanish')->first()->id,
    'status' => 'draft',
    'price' => 99.99,
    'preview_pages_cnt' => 10
]);
```
