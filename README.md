# Barangay Bulletin – Purok Dillo

Lab Activity 11 (4-334 Full-Stack Web Development): Relationships, eager loading, and form requests.
A Barangay Matina Crossing Hall bulletin board where residents can browse published posts, comment, and view author profiles, while authorized kagawads can publish content through validated form requests.

Built with Laravel 13, SQLite, Blade, and Tailwind CSS v4.

## Personal details

- **Last name:** Dillo
- **Extra tag:** Health
- **Site title:** Barangay Bulletin – Purok Dillo
- **Custom category:** Sports & Youth
- **Posts per page:** 6 (Dillo has five letters; the Lab 10 rule uses six when the surname is shorter than six letters)
- **Kagawad login:** `kagawad.dillo@bulletin.test`
- **Resident login:** `lola.dillo@bulletin.test`
- **Shared password:** `bulletin2026`
- **Pinned post:** "Purok Dillo Clean-up Drive"
- **Required tag set:** `Purok Dillo`, `Urgent`, `Libre`, `Schedule`, `Health`

## How to run it

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install
npm run dev
php artisan serve
```

If `database/database.sqlite` does not exist, create it first (`touch database/database.sqlite` or `New-Item database/database.sqlite` in PowerShell).

The seeders create 51 posts total: 40 generated published posts, 10 drafts, and the pinned Purok Dillo post. Published posts are tagged from the required tag set.

## Main routes

| URL | What it does |
| --- | --- |
| `/` | redirects to `/posts` |
| `/login` | resident login page |
| `/posts` | published posts with search, category and tag filters |
| `/posts/create` | create a post (requires an author-linked user) |
| `/posts/{post}` | single post detail page |
| `/authors/{author}` | author profile and their posts |

## Included features

- `User hasOne Author` links the Kagawad login to the profile allowed to publish.
- `Author belongsTo User` provides the inverse account-to-profile link.
- `User hasMany Comment` and `Comment belongsTo User` link comments to their authors.
- `Author hasMany Post` and `Post belongsTo Author` assign each post to one profile.
- `Post hasMany Comment` and `Comment belongsTo Post` keep comments attached to their post.
- `Author hasManyThrough Comment via Post` counts comments received across the author's posts.
- `Post belongsToMany Tag` and `Tag belongsToMany Post` support tag badges and filtering through `post_tag`.
- Eager loading with `with()`, `load()`, and `withCount()` avoids N+1 queries on the list, detail, and author pages.
- `Model::preventLazyLoading()` in the app service provider
- Form request validation for post creation and comment submission
- Blade error UX with `@error`, `old()`, and validation summaries
