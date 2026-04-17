# TravelBuddy Database Setup Guide

## 🚀 Quick Start (Recommended)

### Option 1: Automatic Setup (Easiest)
1. Make sure **XAMPP is running** (MySQL service must be active)
2. Visit: **http://localhost/TravelBuddy/setup.php**
3. Click the **"🔧 AUTO SETUP DATABASE"** button
4. Done! Your database is ready

### Option 2: Semi-Automatic with phpMyAdmin
1. Open phpMyAdmin: **http://localhost/phpmyadmin**
2. Click **"New"** in left sidebar
3. Create database named: `travel_db`
4. Select `travel_db` database
5. Go to **Import** tab
6. Upload file: `C:\xampp\htdocs\TravelBuddy\project_root\sql\database.sql`
7. Click **Import**

---

## ⚠️ Troubleshooting

### Error: "Unknown database 'travel_db'"

**Problem:** The database doesn't exist

**Solutions (in order):**
1. ✓ Make sure MySQL is running (check XAMPP Control Panel)
2. ✓ Use the setup.php script above
3. ✓ Create database manually in phpMyAdmin

### Error: "MySQL Connection Failed"

**Problem:** Can't connect to MySQL at all

**Solutions:**
1. Open XAMPP Control Panel
2. Click **START** next to MySQL
3. Wait 5-10 seconds for it to start
4. Try again

### Error: "No tables in travel_db"

**Problem:** Database exists but is empty

**Solutions:**
1. Use setup.php (it imports tables automatically)
2. Manually import `project_root/sql/database.sql` in phpMyAdmin

---

## 🔍 Diagnostic Tools

### Tool 1: Full Diagnostic Report
**URL:** http://localhost/TravelBuddy/diagnostic.php

Shows:
- MySQL connection status
- All databases on system
- Whether travel_db exists
- Tables in travel_db
- Row counts per table
- One-click fixes

### Tool 2: Auto Setup
**URL:** http://localhost/TravelBuddy/setup.php

Features:
- Beautiful UI
- Step-by-step progress
- Automatic database creation
- Automatic schema import
- Verification of setup

### Tool 3: Simple Verification
**URL:** http://localhost/TravelBuddy/verify_db.php

Shows:
- Connection status
- List of tables
- Simple pass/fail result

---

## 📋 Database Details

**Database Name:** `travel_db`

**Tables Created:**
- `users` - User signup details
- `trips` - Travel information
- `trip_participants` - Trip membership tracking

**Credentials:**
- Host: `localhost`
- Username: `root`
- Password: (empty)
- Database: `travel_db`

---

## 🛠️ Files Modified

### ai.php (Improved Error Handling)
- Updated: `project_root/public/ai.php`
- Shows detailed error messages
- Links to setup tools
- Better debugging information

### Setup Scripts Created
- `setup.php` - Beautiful one-click setup
- `diagnostic.php` - Full diagnostic report
- `verify_db.php` - Simple verification tool

---

## ✅ Verification Steps

After setup, verify everything works:

### Step 1: Check Database Exists
```
Visit: http://localhost/phpmyadmin
Look for "travel_db" in left sidebar
```

### Step 2: Check Tables Exist
```
Select travel_db in phpMyAdmin
Should see: users, trips, trip_participants
```

### Step 3: Test Connection
```
Visit: http://localhost/TravelBuddy/project_root/public/ai.php
Should show page content (not connection error)
```

---

## 🆘 Still Having Issues?

1. **Run Full Diagnostic:**
   - Visit: http://localhost/TravelBuddy/diagnostic.php
   - Note any error messages
   - Click the suggested fix button

2. **Check MySQL Status:**
   - Open XAMPP Control Panel
   - Verify MySQL shows "Running" in green
   - If not, click "Start"

3. **Verify File Paths:**
   - SQL file should be at: `C:\xampp\htdocs\TravelBuddy\project_root\sql\database.sql`
   - PHP files should be in: `C:\xampp\htdocs\TravelBuddy\`

4. **Check Database Name:**
   - Must be exactly: `travel_db` (lowercase, underscore not dash)
   - Not: travel-db, Travel_db, travelDB

---

## 💡 Tips

- Always start MySQL and Apache in XAMPP before testing
- phpMyAdmin is a great tool for visual database management
- The diagnostic.php script can auto-fix most issues
- Check the browser console (F12) for additional error details

---

**For questions or issues, use the diagnostic tools above!**
