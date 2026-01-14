#!/usr/bin/env python3
"""
Admin Bot - Visits reported URLs with admin cookie
"""

import time
import os
import json
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.chrome.service import Service

REPORTS_FILE = '/var/www/html/data/reports.json'
FLAG = open('/flag.txt').read().strip()
ADMIN_COOKIE = f"admin_session={FLAG}"

def get_chrome_driver():
    """Create headless Chrome driver"""
    options = Options()
    options.add_argument('--headless')
    options.add_argument('--no-sandbox')
    options.add_argument('--disable-dev-shm-usage')
    options.add_argument('--disable-gpu')
    options.add_argument('--window-size=1920,1080')
    options.binary_location = '/usr/bin/chromium'
    
    service = Service('/usr/bin/chromedriver')
    driver = webdriver.Chrome(service=service, options=options)
    return driver

def visit_url(url):
    """Visit URL as admin with cookie"""
    driver = None
    try:
        print(f"[BOT] Visiting: {url}")
        driver = get_chrome_driver()
        
        # First visit the base domain to set cookie
        driver.get('http://localhost/')
        driver.add_cookie({
            'name': 'admin_session',
            'value': FLAG,
            'domain': 'localhost',
            'path': '/'
        })
        
        # Now visit the reported URL
        driver.get(url)
        time.sleep(3)  # Wait for JS to execute
        
        print(f"[BOT] Visited successfully: {url}")
        return True
    except Exception as e:
        print(f"[BOT] Error visiting {url}: {e}")
        return False
    finally:
        if driver:
            driver.quit()

def process_reports():
    """Process pending URL reports"""
    if not os.path.exists(REPORTS_FILE):
        return
    
    try:
        with open(REPORTS_FILE, 'r') as f:
            reports = json.load(f)
    except:
        return
    
    if not reports:
        return
    
    # Process each report
    pending = [r for r in reports if r.get('status') == 'pending']
    
    for report in pending:
        url = report.get('url', '')
        if url.startswith('http://localhost') or url.startswith('http://127.0.0.1'):
            visit_url(url)
        report['status'] = 'visited'
    
    # Save updated reports
    with open(REPORTS_FILE, 'w') as f:
        json.dump(reports, f)

def main():
    print("[BOT] Admin bot started...")
    while True:
        process_reports()
        time.sleep(5)  # Check every 5 seconds

if __name__ == '__main__':
    main()
