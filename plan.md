# YouQianRen (有钱人) – Web-Based Money Management App
**Development Plan using Laravel Filament v4**

---

## 1. Project Overview

**App Name**: YouQianRen (有钱人)
**Purpose**: A personal and household finance management application that enables users to track income, expenses, savings, loans, transfers, and financial goals with multi-currency support and customizable dashboards.

**Target Users**: Individuals in Indonesia and globally who want to manage their finances digitally.

**Core Tech Stack**:
- **Backend**: Laravel ^12
- **Admin Panel / UI Framework**: Filament PHP v4
- **Database**: MariaDB
- **File Storage**: Cloudflare R2
- **Deployment**: Shared hosting with DirectAdmin + GitHub Actions automation

**Licensing & Monetization Model**: 
- **Open-Source Donationware**: Full source code available under an open-source license (MIT/Apache 2.0). Users can self-host freely.
- **Cloud-Hosted Version**: Optional managed hosting with tiered subscription plans for convenience.

---

## 2. Feature Breakdown by Module

### 2.1. Authentication & User Management
- Standard email/password login with email verification.
- Profile management (name, email, timezone, language preference).
- Role-based access control (not multi-tenant; one user = one account).
- Cloud plan management (Hobby/Plus/Team) — self-hosted version has no restrictions.

### 2.2. Dashboard (Root Page)
The dashboard is the landing page after login and includes the following **widgets**:
- **Interactive Calendar Widget**:
  - Displays current month.
  - Each date shows a dot indicator if transactions exist.
  - Clicking a date navigates to `/transactions?date=YYYY-MM-DD`.
- **Analytics Widget**:
  - Toggle between Daily / Weekly / Monthly views.
  - Shows net cash flow, category breakdown (pie/bar chart), and comparison vs budget.
  - Uses Filament's ChartJS integration.
- **Budgets Widget**:
  - Lists active budgets with progress bars.
  - Quick-add button to create new budget.
  - Shows overspending alerts.

> *All widgets are user-customizable: can be hidden, reordered, or resized via drag-and-drop (using Livewire + Alpine.js).*

### 2.3. Transaction Management
- **CRUD interface** for transactions with fields matching the Excel structure:
  - `date`, `account_id`, `category_id`, `type` (Income/Expense/Transfer), `amount`, `currency`, `note`, `created_at`.
- Supports **multi-currency per transaction**.
- Default currency applied automatically unless overridden.
- Bulk import/export (CSV/XLSX) support planned for v2.
- Filtering by date range, account, category, type, and currency.

### 2.4. Accounts (Money Accounts)
- Manage multiple accounts: Cash, Bank (Mandiri, SeaBank), E-Wallet (Dana, ShopeePay, Mandiri E-Money), Savings, Emergency Fund, etc.
- Each account has:
  - Name, type (cash/bank/e-wallet/investment), balance, currency, icon.
- Balance auto-calculated from transaction history.
- "Transfer" transactions affect two accounts.

### 2.5. Categories
- Predefined categories based on sample data (e.g., Food, Fuel, Charity, Salary, Education).
- Users can create, edit, delete, assign icons, and group into parent categories.
- Categories are scoped per user.

### 2.6. Budgets
- Create time-bound budgets (daily/weekly/monthly/yearly).
- Assign to specific categories or all categories.
- Track spending against budget with visual indicators.
- Notifications when nearing or exceeding limit.

### 2.7. Financial Goals
- Goal name, target amount, deadline, current progress, optional image upload.
- Image stored in Cloudflare R2.
- Progress auto-updated when linked transactions are added (manual linking or auto-suggestion).

### 2.8. Currency Management
- System supports global currencies (USD, IDR, EUR, etc.) via ISO 4217.
- **Default currency**: Configurable in user settings.
- **Custom currencies** (e.g., crypto, local tokens):
  - Users can define symbol, code, and exchange rate (manual or API-sync planned later).
- All monetary values stored in base currency (or as-is with currency field); no automatic conversion in v1.

<!-- ### 2.9. Indonesian Payment Integration (Mayar.id)
- Optional payment method for cloud subscription checkout in Indonesia.
- Used during cloud plan checkout (not for transaction logging).
- Will be integrated via Mayar.id's official API (redirect or embedded checkout).
- Fallback to standard bank transfer or QRIS if not available. -->

### 2.9. Settings & Preferences
- Language (ID/EN)
- Timezone
- Default currency
- Dashboard layout preferences (stored as JSON)
- Notification preferences
- Subscription status display (cloud-hosted version only)

---

## 3. Licensing & Cloud Hosting Plans

### Open-Source (Self-Hosted)
- **License**: MIT/Apache 2.0 (user-friendly, permissive)
- **Cost**: Free (donations appreciated via GitHub Sponsors, Ko-fi, etc.)
- **Features**: Full access to all features, unlimited everything
- **Source Code**: Complete access on GitHub
- **Support**: Community support via GitHub Issues/Discussions
- **Responsibilities**: User handles their own hosting, backups, updates, and security

### Cloud-Hosted Plans
For users who prefer a managed, hassle-free experience:

| Feature | Hobby (Free) | Plus ($5/mo) | Team ($12/mo) |
|--------|-------------|--------------|---------------|
| Users | 1 | 1 | Up to 5 |
| Max Goals | Unlimited | Unlimited | Unlimited |
| Custom Categories | ✅ | ✅ | ✅ |
| Custom Currencies | ✅ | ✅ | ✅ |
| Data Export | ✅ | ✅ | ✅ |
| Priority Support | ❌ | ✅ | ✅ |
| Automated Backups | ❌ | ✅ | ✅ |
| Custom Domain | ❌ | ❌ | ✅ |
| Ads | ❌ | ❌ | ❌ |

> All cloud plans include: managed hosting, automatic updates, SSL, daily backups (varies by plan), and email support. Self-hosted users have no feature restrictions.

---

## 4. Data Model Outline (Logical Entities)

- `User`
- `Account` (name, type, currency, balance_snapshot)
- `Category` (name, icon, is_system, user_id)
- `Transaction` (date, account_id, to_account_id*, type, category_id, amount, currency, note)
- `Budget` (name, category_id?, amount, period, start_date, end_date)
- `Goal` (name, target_amount, currency, deadline, image_path, current_amount)
- `Currency` (code, symbol, is_custom, exchange_rate, user_id?)
- `Subscription` (plan_tier, status, stripe_id?, current_period_end) — cloud-hosted only

> \* `to_account_id` used only for Transfer-type transactions.

---

## 5. Development Phases

### Phase 1: Core Infrastructure (Weeks 1–2)
- Setup Laravel ^12 project with MariaDB.
- Install Filament v4, configure auth, theme, and basic layout.
- Configure Cloudflare R2 disk in `filesystems.php`.
- Implement user model and settings system.
- Add open-source license file (LICENSE.md).

### Phase 2: Transaction & Account System (Weeks 3–4)
- Build `Account` and `Transaction` Filament resources.
- Implement CRUD, validation, and filtering.
- Add multi-currency support in forms and tables.
- Auto-balance calculation logic.

### Phase 3: Dashboard & Widgets (Week 2–3, parallel)
- Develop custom Filament dashboard widgets.
- Integrate full-calendar or lightweight date grid.
- Build analytics charts (ChartJS via Filament plugin).
- Enable widget customization (save layout to user meta).

### Phase 4: Budgets, Goals, Categories (Weeks 5–6)
- Implement `Budget`, `Goal`, and `Category` modules.
- Add image upload for goals (Cloudflare R2).

### Phase 5: Settings, Currency, and Localization (Week 7)
- Build settings panel.
- Add currency management (system + custom).
- Implement Indonesian language support.
- Integrate payment gateway for cloud subscriptions (Stripe/Mayar.id).

### Phase 6: Testing, Polish & Documentation (Week 8)
- Manual QA on all user flows.
- Write user guide and admin documentation.
- Prepare initial open-source release on GitHub.
- Set up donation links (GitHub Sponsors, Ko-fi, Buy Me a Coffee).
- Build cloud-hosted landing page with pricing comparison.

---

## 6. Non-Functional Requirements

- **Performance**: Optimize queries with eager loading; paginate large lists.
- **Security**: Sanitize inputs, enforce CSRF, use HTTPS, validate file uploads.
- **UX**: Mobile-responsive Filament theme; intuitive form flows.
- **Maintainability**: Follow Laravel best practices; modular service layer if needed.
- **Scalability**: Designed for single-user use; multi-tenancy not required.
- **Open-Source Friendly**: Clean commit history, contribution guidelines, issue templates, and clear documentation.

---

## 7. Community & Open-Source Considerations

- **Contributing Guide**: Clear CONTRIBUTING.md with coding standards, PR process, and branch strategy.
- **Code of Conduct**: Standard contributor covenant.
- **Donation Infrastructure**: GitHub Sponsors, Open Collective, or Ko-fi integration.
- **Issue Labels**: `good first issue`, `help wanted`, `bug`, `enhancement`, `documentation`.
- **Release Strategy**: Semantic versioning (v1.0.0, v1.1.0, etc.) with changelog.
- **Self-Hosted Deployment**: One-click deploy scripts (Docker Compose, Railway, Render).

---

## 8. Future Considerations (Post v1)

- Bank sync (via Plaid-like services or local APIs)
- Recurring transactions
- Report PDF export
- Multi-user households (shared budgets/goals)
- Exchange rate auto-sync (OpenExchangeRates, etc.)
- Mobile app (React Native / Flutter wrapper)