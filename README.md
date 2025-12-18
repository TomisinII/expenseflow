# 💰 ExpenseFlow

> A modern, intuitive expense tracking application built with Laravel 11 and Livewire 3

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=flat-square)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-38B2AC?style=flat-square&logo=tailwind-css)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 📋 Overview

ExpenseFlow is a personal finance management application that helps individuals gain control over their finances through smart categorization, visual analytics, real-time notifications, and a seamless user experience. Built with modern Laravel and Livewire, it provides a reactive, SPA-like experience without the complexity of a JavaScript framework.

### ✨ Key Features

- **💳 Expense Management** - Quick expense entry with comprehensive tracking
- **📊 Visual Analytics** - Beautiful charts showing spending patterns and trends
- **🎯 Budget Tracking** - Set monthly budgets with smart alerts at 90% and 100% thresholds
- **🏷️ Custom Categories** - Organize expenses with personalized categories, icons, and colors
- **🔔 Real-time Notifications** - Instant feedback for actions and budget alerts
- **🌙 Dark Mode** - Full dark mode support throughout the application
- **📱 Responsive Design** - Works seamlessly on mobile, tablet, and desktop
- **📤 CSV Export** - Export your expense data for external analysis
- **🔍 Advanced Filtering** - Filter by category, date range, payment method, and amount

## 🎯 Target Audience

- Young professionals (25-35)
- Students
- Freelancers
- Anyone wanting to track personal expenses with smart alerts

## 🚀 Tech Stack

### Backend
- **Framework:** Laravel 11.x
- **Database:** MySQL 8.0+
- **Authentication:** Laravel Breeze (Livewire stack)
- **Storage:** Local (development) / S3 (production ready)

### Frontend
- **UI Framework:** Livewire 3.x
- **Styling:** Tailwind CSS 3.x
- **JavaScript:** Alpine.js (bundled with Livewire)
- **Icons:** Material Design Icons
- **Charts:** Chart.js

## 📦 Installation

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & npm

### Setup Instructions

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/expenseflow.git
cd expenseflow
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install NPM dependencies**
```bash
npm install
```

4. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure your database** in `.env`
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expenseflow
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Run migrations and seed default categories**
```bash
php artisan migrate --seed
```

7. **Build frontend assets**
```bash
npm run dev
```

8. **Start the development server**
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser!

## 🗄️ Database Schema

### Core Tables
- **users** - User authentication and preferences
- **categories** - Expense categories with icons and colors
- **expenses** - Individual expense transactions
- **budgets** - Monthly budget limits per category
- **notifications** - User notifications for actions and alerts

## 🎨 Features Breakdown

### 1️⃣ Dashboard
- Summary cards (today, week, month, year)
- Recent expenses list
- Quick-add floating action button
- Recent notifications display

### 2️⃣ Expense Management
- Create, read, update, delete expenses
- Real-time search and filtering
- Bulk selection and actions
- Receipt upload support
- Multiple payment methods (Cash, Card, Bank Transfer, Other)
- Soft deletes with confirmation modals

### 3️⃣ Category System
- Pre-seeded default categories (Food, Transport, Entertainment, etc.)
- Custom category creation
- Icon and color selection
- Category usage statistics
- Visual category breakdown

### 4️⃣ Budget Management
- Monthly budget per category
- Visual progress bars
- Smart notifications:
  - ⚠️ Warning at 90% usage
  - 🚨 Danger at 100%+ usage
- Budget summary overview

### 5️⃣ Analytics & Reports
- Spending by category (pie chart)
- Spending trends (line chart)
- Top expenses list
- Custom date range filtering

### 6️⃣ Notification System
- ✅ Success notifications (create/update)
- ⚠️ Warning notifications (budget alerts)
- 🚨 Danger notifications (budget exceeded)
- ℹ️ Info notifications (deletions)
- Notification center with unread badge
- Mark as read/unread functionality
- Auto-archive after 30 days

### 7️⃣ User Experience
- 🌙 Dark mode toggle (persisted to database)
- 📱 Fully responsive mobile design
- 🔔 Toast notifications for instant feedback
- ⏳ Loading states on all operations
- 🎭 Empty states with helpful messages
- 📤 Export data to CSV

## 🎯 User Flow Examples

### Adding an Expense
1. Click "Add Expense" button or floating action button
2. Fill in amount, category, date, description, payment method
3. Optional: Add notes or upload receipt
4. Save → Instant success notification
5. Budget checker runs automatically
6. If budget threshold reached → Alert notification appears

### Setting a Budget
1. Navigate to Budgets page
2. Click "Add Budget"
3. Select category, amount, month, and year
4. Save → Budget created notification
5. Progress tracked automatically as expenses are added

### Dark Mode Toggle
1. Click theme toggle in navigation
2. Preference saved to database
3. Entire app switches instantly
4. Setting persists across sessions

## 🔒 Security Features

- Laravel's built-in CSRF protection
- SQL injection prevention via Eloquent ORM
- Authorization via Laravel Policies
- XSS protection (Blade auto-escaping)
- Rate limiting on expense creation
- User-scoped data (users only see their own data)

## 📊 Performance Considerations

- Livewire's `wire:loading` for better UX
- Lazy loading for charts and analytics
- `wire:model.defer` for optimized form inputs
- Cached category lists
- Eager loading to prevent N+1 queries
- Debounced search inputs
- Auto-archive old notifications

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

### Test Coverage
- Authentication flows
- Expense CRUD operations
- Category management
- Budget calculations and alerts
- Notification creation and delivery
- Dashboard data aggregation

## 📈 Future Enhancements

- 📸 Receipt OCR using Tesseract
- 🔄 Recurring expenses/subscriptions
- 💱 Multiple currency support
- 🏦 Bank account integration (Plaid API)
- 📧 Email notifications
- 📱 PWA/Native mobile app
- 👥 Shared expenses (family/roommate mode)
- 📊 Advanced analytics and insights

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request


## 👨‍💻 Author

Built and designed by Olutomisin Oluwajuwon using Laravel & Livewire

## 🙏 Acknowledgments

- Laravel team for the amazing framework
- Livewire team for the reactive magic
- Tailwind CSS for the beautiful styling

## 📞 Support

If you have any questions or need help, please open an issue on GitHub.

---

**⭐ Star this repo if you find it helpful!**
