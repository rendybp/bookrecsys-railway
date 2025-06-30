# Admin Dashboard Guide

This Laravel application now includes a comprehensive admin dashboard for book and user management.

## Features

### 1. **Role-Based Access Control**
- Two user roles: `admin` and `user`
- Admin users can access the admin dashboard
- Regular users can only access the catalog

### 2. **Admin Dashboard**
- Dashboard overview with statistics
- Book management (CRUD operations)
- User management (CRUD operations)
- Admin profile management

### 3. **Book Management**
- Create, Read, Update, Delete books
- Search and filter books
- Export book data as CSV
- Train AI recommendation system

### 4. **User Management (Admin Only)**
- View all users
- Create new users
- Edit user information
- Delete users
- Search users

### 5. **CSV Export & AI Training**
- Export all book data as CSV file
- Test FastAPI server connectivity
- Send CSV data to FastAPI recommendation system for training
- Real-time feedback with success/error messages
- Improved error handling and timeout management

## Default Login Credentials

After running the seeder, you can use these accounts:

### Admin Account
- **Email**: `admin@example.com`
- **Password**: `password`
- **Role**: Admin

### Regular User Account
- **Email**: `test@example.com`
- **Password**: `password`
- **Role**: User

## Setup Instructions

1. **Run Database Migrations**:
   ```bash
   php artisan migrate
   ```

2. **Seed the Database**:
   ```bash
   php artisan db:seed
   ```

3. **Start the Application**:
   ```bash
   php artisan serve
   ```

4. **Access the Application**:
   - Main catalog: `http://localhost:8000`
   - Admin login: `http://localhost:8000/admin/login`

## Navigation

### For Admin Users:
1. Login at `/admin/login`
2. Access admin dashboard from the navbar link
3. Navigate between:
   - Dashboard (`/admin`)
   - Books Management (`/admin/books`)
   - Users Management (`/admin/users`)
   - Profile Settings (`/admin/profile`)

### For Regular Users:
- Can only access the main catalog
- Admin dashboard link is visible but access is restricted

## Admin Features in Detail

### Book Management
- **List Books**: View all books with search and pagination
- **Add New Book**: Create new book entries with validation
- **Edit Books**: Update existing book information
- **Delete Books**: Remove books from the system
- **Export CSV**: Download all book data as CSV file
- **Train AI Model**: Send book data to FastAPI endpoint for ML training

### User Management
- **List Users**: View all users with their roles and information
- **Add New User**: Create new user accounts
- **Edit Users**: Update user information and roles
- **Delete Users**: Remove user accounts

### CSV Export Feature
- Exports: `id`, `title`, `category`, `description`
- Filename format: `books_export_YYYY-MM-DD_HH-mm-ss.csv`
- Downloads directly to browser

### AI Training Feature
- Sends CSV data to FastAPI endpoint
- Endpoint: `https://21fd-34-27-50-17.ngrok-free.app/sync/train`
- **Processing Time**: A few minutes (optimized for efficiency)
- Provides real-time feedback on training status
- Handles errors gracefully with user-friendly messages

## FastAPI Integration

The admin dashboard can communicate with a FastAPI-based recommendation system:

### Endpoint Configuration
- **URL**: `https://21fd-34-27-50-17.ngrok-free.app/sync/train`
- **Method**: POST
- **Content**: Multipart form data with CSV file
- **Timeout**: 5 minutes (300 seconds)
- **Processing Time**: Typically a few minutes for training completion

### Expected Response Format
```json
{
  "message": "Model training completed successfully"
}
```

## Security Features

- **Middleware Protection**: Admin routes protected by authentication and role-based middleware
- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Comprehensive validation on all user inputs
- **SQL Injection Prevention**: Using Eloquent ORM for database queries

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AdminController.php
│   │   │   ├── AdminBookController.php
│   │   │   └── AdminUserController.php
│   │   └── Auth/
│   │       └── LoginController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── AuthMiddleware.php
resources/
├── views/
│   ├── admin/
│   │   ├── layouts/
│   │   ├── books/
│   │   ├── users/
│   │   ├── dashboard.blade.php
│   │   └── profile.blade.php
│   └── auth/
│       └── login.blade.php
routes/
└── web.php (admin routes)
```

## Troubleshooting

### Common Issues

1. **403 Forbidden Error**
   - Make sure you're logged in as an admin user
   - Check that your user's role is set to 'admin'

2. **CSV Export Not Working**
   - Check file permissions on storage directory
   - Ensure books exist in the database

3. **AI Training Fails**
   - Verify FastAPI endpoint is accessible
   - Check internet connection
   - Ensure CSV data is valid

### FastAPI Connection Issues

If you're getting timeout errors when training the AI model:

1. **Check FastAPI Server Status**
   - Click the "Test Connection" button in the Books management page
   - This will test if the FastAPI server is running and the endpoint is accessible
   - **Note**: The test doesn't require a `/health` endpoint - it tests the actual training endpoint

2. **Common Timeout Causes**
   - FastAPI server is not running
   - Incorrect URL endpoint (currently: `https://21fd-34-27-50-17.ngrok-free.app/sync/train`)
   - Firewall blocking the connection
   - Network connectivity issues
   - NGrok tunnel expired (if using NGrok)

3. **Understanding Test Results**
   - **Success (200)**: Server and endpoint working perfectly
   - **Method Not Allowed (405)**: Server and endpoint exist, normal for GET on POST endpoint
   - **Unprocessable Entity (422)**: Server ready, just needs proper CSV data
   - **Not Found (404)**: Server exists but `/sync/train` endpoint missing
   - **Connection Error**: Server unreachable or network issues

4. **Update FastAPI URL**
   - You can change the FastAPI base URL by setting `FASTAPI_URL` in your `.env` file
   - Example: `FASTAPI_URL=https://your-new-server.com` (without endpoint path)
   - The application automatically appends the correct endpoints (/recommend, /sync/train)

5. **Verify NGrok Tunnel**
   - If using NGrok, make sure the tunnel is active
   - NGrok URLs change when restarted
   - Update the URL in config or environment variable

### Error Messages

- **"Akses ditolak"**: User doesn't have admin privileges
- **"Tidak ada data buku"**: No books in database for export/training
- **"Gagal memperbarui sistem rekomendasi"**: FastAPI endpoint error
- **"Koneksi timeout ke FastAPI server"**: FastAPI server unreachable or too slow
- **"FastAPI endpoint tidak dapat diakses"**: Server connectivity test failed

### Quick Fixes

1. **For Connection Timeouts:**
   ```bash
   # Check if FastAPI server is running
   curl -X GET "https://your-fastapi-url/health"
   ```

2. **For NGrok Issues:**
   - Restart NGrok tunnel
   - Update the URL in your Laravel config
   - Use the "Test Connection" button to verify

3. **For Network Issues:**
   - Check firewall settings
   - Try from a different network
   - Verify internet connectivity

## Performance Considerations

- Book and user listings are paginated (15 items per page)
- Search functionality uses database indexes
- CSV export streams data to avoid memory issues
- File cleanup after AI training requests
- **AI Training**: Optimized 5-minute timeout for efficient processing
- **User Experience**: Progress indicators and real-time feedback

## Future Enhancements

Potential improvements for the admin system:
- Bulk book import from CSV/Excel
- Advanced filtering and sorting options
- User activity logging
- Dashboard analytics and charts
- Email notifications for admin actions
- Backup and restore functionality
