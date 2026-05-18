#!/usr/bin/env node

/**
 * SQLite Database Initialization Script
 * Runs the init-database.sql file to populate the database with tables and dummy data
 * 
 * Usage: node init-db.js
 */

const sqlite3 = require('sqlite3').verbose();
const fs = require('fs');
const path = require('path');

const dbPath = path.join(__dirname, 'database', 'database.sqlite');
const sqlPath = path.join(__dirname, 'database', 'init-database.sql');

console.log('[Database Init] Starting database initialization...');
console.log(`[Database Init] Database path: ${dbPath}`);
console.log(`[Database Init] SQL file path: ${sqlPath}`);

// Check if SQL file exists
if (!fs.existsSync(sqlPath)) {
    console.error(`[Database Init] ERROR: SQL file not found at ${sqlPath}`);
    process.exit(1);
}

// Read the SQL file
let sql;
try {
    sql = fs.readFileSync(sqlPath, 'utf8');
    console.log('[Database Init] SQL file loaded successfully');
} catch (err) {
    console.error('[Database Init] ERROR: Failed to read SQL file:', err.message);
    process.exit(1);
}

// Connect to database
const db = new sqlite3.Database(dbPath, (err) => {
    if (err) {
        console.error('[Database Init] ERROR: Failed to connect to database:', err.message);
        process.exit(1);
    }
    console.log('[Database Init] Connected to SQLite database');
    
    // Execute SQL script
    db.exec(sql, (err) => {
        if (err) {
            console.error('[Database Init] ERROR: Failed to execute SQL:', err.message);
            db.close();
            process.exit(1);
        }
        
        console.log('[Database Init] ✓ Database initialized successfully!');
        console.log('[Database Init] ✓ All tables created');
        console.log('[Database Init] ✓ Dummy products inserted (24 products across 6 categories)');
        
        // Verify the data
        db.get("SELECT COUNT(*) as count FROM products", (err, row) => {
            if (!err && row) {
                console.log(`[Database Init] ✓ Total products in database: ${row.count}`);
            }
            
            db.get("SELECT COUNT(*) as count FROM categories", (err, row) => {
                if (!err && row) {
                    console.log(`[Database Init] ✓ Total categories in database: ${row.count}`);
                }
                
                console.log('[Database Init] ✓ Ready to start the application!');
                console.log('[Database Init] ✓ Run: php artisan serve');
                
                db.close((err) => {
                    if (err) {
                        console.error('[Database Init] Warning: Error closing database:', err.message);
                    }
                    process.exit(0);
                });
            });
        });
    });
});
