# Fix Laravel + Vue Auth Issues

## Status: [✅] 25% Complete (Frontend fixed)

### Step 1: Fix Database & Sessions (User action required)
- [ ] Run `php artisan migrate:fresh --seed` via ospanel (drops/recreates all tables from migrations + seeds data)
  - Note: Uses your sidequest.sql dump? Import manually if needed: use ospanel phpMyAdmin, drop DB tables, import sidequest.sql, then `migrate:fresh`.
  - If migrate fails again, run `php artisan migrate:status` to see pending, `php artisan migrate --force`.
- [ ] Verify sessions table created: `php artisan tinker` > `DB::table('sessions')->get()`

### Step 2: Clear Laravel Caches
- [ ] `php artisan config:clear`
- [ ] `php artisan cache:clear`
- [ ] `php artisan route:clear`
- [ ] `php artisan view:clear`

### Step 3: Fix Frontend API Calls (AI will edit)
✅ Updated resources/js/utils/api.js - added ensureCsrfToken to apiGet.

### Step 4: Rebuild Frontend
- [ ] VSCode terminal: `npm run dev` or `npm run build`

### Step 5: Test
- [ ] Reload page - expect 401 on /api/user (normal, unauth)
- [ ] Login - expect 200 OK, no 500
- [ ] Check auth succeeds, /library works
- [ ] Mark complete

**Next**: After Step 1+2, reply 'migrate done' for Step 3 edits.

**Optional**: Set SESSION_DRIVER=file in .env (no DB sessions needed, simpler).
