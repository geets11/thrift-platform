#!/usr/bin/env python3
"""
SQLite Database Initialization Script
Initializes the database with all tables and dummy product data

Usage: python3 init-db.py
"""

import sqlite3
import os
import sys
from pathlib import Path

def init_database():
    # Get paths
    db_path = Path(__file__).parent / 'database' / 'database.sqlite'
    sql_path = Path(__file__).parent / 'database' / 'init-database.sql'
    
    print(f'[Database Init] Starting database initialization...')
    print(f'[Database Init] Database path: {db_path}')
    print(f'[Database Init] SQL file path: {sql_path}')
    
    # Check if SQL file exists
    if not sql_path.exists():
        print(f'[Database Init] ERROR: SQL file not found at {sql_path}')
        return False
    
    # Read the SQL file
    try:
        with open(sql_path, 'r') as f:
            sql = f.read()
        print('[Database Init] SQL file loaded successfully')
    except Exception as e:
        print(f'[Database Init] ERROR: Failed to read SQL file: {str(e)}')
        return False
    
    # Connect to database
    try:
        conn = sqlite3.connect(str(db_path))
        cursor = conn.cursor()
        print('[Database Init] Connected to SQLite database')
        
        # Enable foreign keys
        cursor.execute('PRAGMA foreign_keys = ON')
        
        # Execute SQL script
        cursor.executescript(sql)
        conn.commit()
        print('[Database Init] ✓ Database initialized successfully!')
        print('[Database Init] ✓ All tables created')
        print('[Database Init] ✓ Dummy products inserted (24 products across 6 categories)')
        
        # Verify the data
        cursor.execute("SELECT COUNT(*) as count FROM products")
        product_count = cursor.fetchone()[0]
        print(f'[Database Init] ✓ Total products in database: {product_count}')
        
        cursor.execute("SELECT COUNT(*) as count FROM categories")
        category_count = cursor.fetchone()[0]
        print(f'[Database Init] ✓ Total categories in database: {category_count}')
        
        print('[Database Init] ✓ Ready to start the application!')
        print('[Database Init] ✓ Run: php artisan serve')
        
        conn.close()
        return True
        
    except Exception as e:
        print(f'[Database Init] ERROR: Failed to initialize database: {str(e)}')
        return False

if __name__ == '__main__':
    success = init_database()
    sys.exit(0 if success else 1)
