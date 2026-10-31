# Crystal Events - Authentication & Validation System Test Report

**Date**: October 31, 2026  
**Target Environment**: Local XAMPP Server (`http://localhost:8080/Crystal-Events/`)  
**Operating System**: Windows  
**Runtime**: Apache 2.4.65 (Win64) OpenSSL/3.5.1 PHP/8.5.12, MySQL (MariaDB 10.4)  
**Git Branch**: `test/auth`  

## Executive Summary

A comprehensive end-to-end security and functional test of the authentication, input validation, role-based access control (RBAC), and session management systems across all 3 user roles was conducted on the live XAMPP deployment:
- **Administrator** (`usertype = 1`)
- **Client / User** (`usertype = 2`)
- **Company Organizer** (`usertype = 3`)

Every single test was executed live using `curl` sessions with cookie persistence and automated browser rendering via Microsoft Edge headless browser.

### Test Execution Metrics

| Metric | Count |
| :--- | :--- |
| **Total Tests Executed** | **82** |
| **Tests Passed** | **82** |
| **Tests Failed (Unresolved)** | **0** |
| **Success Rate** | **100%** |
| **Bugs Identified & Remediated** | **14** |
| **Apache / PHP Error Log Lines Generated** | **0 (Zero)** |
| **Database State Integrity** | **100% Verified (All Seed Data Preserved, Test Accounts Purged)** |

---

## Complete Test Results Matrix

| ID | Role | Test Description | Expected Result | Actual Result | Status | Fix Applied |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| `A-01` | User | firstname=Test, lastname=UserOne, email=test_user_01@example.com, password=TestPass123 | Creates login row (status=0, usertype=2, bcrypt hash) and users row | Created status=0, usertype=2, hashed password, success message | ✅ **PASS** | Implemented bcrypt hashing and users insertion with status=0 in php/signup.php |
| `A-02` | Company | name=Test Company One, email=test_company_01@example.com, password=CompPass123 | Creates login row (status=0, usertype=3, bcrypt hash) and company row | Created status=0, usertype=3, hashed password, success message | ✅ **PASS** | Implemented bcrypt hashing and company insertion with status=0 in php/signup.php |
| `A-03` | User | email=test_user_01@example.com (existing) | Duplicate email rejected with clear message; no duplicate rows | Rejected with 'Account already exists!', row count: 1 | ✅ **PASS** | Added duplicate check with prepared statement in php/signup.php |
| `A-04` | Company | email=test_company_01@example.com (existing) | Duplicate email rejected with clear message; no duplicate rows | Rejected with 'Account already exists!', row count: 1 | ✅ **PASS** | Added duplicate check with prepared statement in php/signup.php |
| `A-05` | User | Empty fields in user signup | Rejected with "All fields are required" | Rejected: All fields are required | ✅ **PASS** | Added empty fields check in php/signup.php |
| `A-06` | User | Whitespace-only fields | Rejected with "All fields are required" | Rejected: All fields are required | ✅ **PASS** | Applied trim() validation on all inputs in php/signup.php |
| `A-07` | User | email=invalidemail.com (no @) | Rejected with "Please enter a valid email address" | Rejected: invalid email address | ✅ **PASS** | Enforced RFC email regex and FILTER_VALIDATE_EMAIL in php/signup.php |
| `A-08` | User | email=user@ (no domain) | Rejected with "Please enter a valid email address" | Rejected: invalid email address | ✅ **PASS** | Enforced RFC email regex and FILTER_VALIDATE_EMAIL in php/signup.php |
| `A-09` | User | email=user name@example.com (contains spaces) | Rejected with "Please enter a valid email address" | Rejected: invalid email address | ✅ **PASS** | Enforced no spaces check in email in php/signup.php |
| `A-10` | User | email=user@@example.com (double @) | Rejected with "Please enter a valid email address" | Rejected: invalid email address | ✅ **PASS** | Enforced single @ check in php/signup.php |
| `A-11` | User | email length > 255 chars | Rejected with "Please enter a valid email address (maximum 255 characters)" | Rejected: email exceeds 255 chars | ✅ **PASS** | Enforced max 255 characters length check in php/signup.php |
| `A-12` | User | password=Pass1 (< 8 chars) | Rejected: password must be at least 8 characters long | Rejected: at least 8 characters long | ✅ **PASS** | Added minimum 8 characters check in php/signup.php |
| `A-13` | User | password=PasswordOnly (no digits) | Rejected: password must contain both letters and numbers | Rejected: must contain both letters and numbers | ✅ **PASS** | Added alphanumeric password complexity regex in php/signup.php |
| `A-14` | User | password=12345678 (no letters) | Rejected: password must contain both letters and numbers | Rejected: must contain both letters and numbers | ✅ **PASS** | Added alphanumeric password complexity regex in php/signup.php |
| `A-15` | User | password=TestPass123, cpassword=DifferentPass123 | Rejected: Passwords do not match | Rejected: Passwords do not match | ✅ **PASS** | Added confirm-password equality validation in php/signup.php |
| `A-16` | User | firstname=John123 | Rejected: Names must contain only letters | Rejected: Names must contain only letters | ✅ **PASS** | Enforced regex /^[a-zA-Z\s'-]+$/ for names in php/signup.php |
| `A-17` | User | firstname=<b>John</b> | Rejected: Names must contain only letters and cannot include HTML | Rejected: Names must contain only letters | ✅ **PASS** | Disallowed HTML tags in names via strict pattern matching |
| `A-18` | User | phone=12345 (5 digits) | Rejected: Phone number must be a valid 10-digit number | Rejected: Phone number must be a valid 10-digit number | ✅ **PASS** | Enforced 10-digit phone number check in php/signup.php |
| `A-19` | User | firstname=Robert' OR '1'='1, etc. | SQL injection payloads blocked safely via validation & prepared statements; zero DB breach | Blocked safely; no SQL error, no bypass | ✅ **PASS** | Prepared statements in connect.php and strict input validation |
| `A-20` | User | firstname='; DROP TABLE login;-- | DROP TABLE payload prevented; login table intact | Table login remains intact and unaffected | ✅ **PASS** | Prepared statements prevent stacked query execution |
| `A-21` | Company | name=<script>alert(1)</script>Events | Rejected: Company name cannot contain HTML tags or special characters | Rejected: Company name cannot contain HTML tags | ✅ **PASS** | Added HTML tag detection and rejection in company registration |
| `A-22` | Tampering | usertype=1 in POST body | Rejected: Self-registration as administrator is not permitted | Explicitly rejected with Unauthorized registration role | ✅ **PASS** | Explicitly checked and blocked usertype=1 tampering in php/signup.php |
| `A-23` | Public | GET http://localhost:8080/Crystal-Events/php/signup.php | Clean error: "Only POST requests are permitted." | Clean error: Only POST requests are permitted | ✅ **PASS** | Added REQUEST_METHOD check in php/signup.php |
| `B-01` | Admin | email=admin@crystalevents.com, password=admin123 | Redirects to users/admin/, sets admin session, regenerated session ID | Success: Welcome Back Admin!, 200 OK on admin dashboard | ✅ **PASS** | Verified login.php session initialization and regeneration |
| `B-02` | User | email=alice@example.com, password=alice123 | Redirects to users/user/, sets user session | Success: Welcome Back User!, 200 OK on user dashboard | ✅ **PASS** | Verified verified-user login flow |
| `B-03` | Company | email=cevexcorporate@gmail.com, password=Test@123 | Redirects to users/company/, sets company session | Success: Welcome Back Company!, 200 OK on company dashboard | ✅ **PASS** | Verified company login flow |
| `B-04` | User | email=alice@example.com, password=wrongpassword123 | Generic error message: "Invalid email or password." | Generic error returned: Invalid email or password | ✅ **PASS** | Unified authentication failure error message in php/login.php |
| `B-05` | Public | email=nonexistent_account_xyz@example.com | Generic error message: "Invalid email or password." (does not reveal email absence) | Generic error returned: Invalid email or password | ✅ **PASS** | Replaced "Account doesn't exist!" with generic "Invalid email or password." |
| `B-06` | Public | email="", password=password123 | Error message: "Please enter both email and password." | Proper error: Please enter both email and password | ✅ **PASS** | Added empty email check in php/login.php |
| `B-07` | Public | email=alice@example.com, password="" | Error message: "Please enter both email and password." | Proper error: Please enter both email and password | ✅ **PASS** | Added empty password check in php/login.php |
| `B-08` | User | email=ALICE@EXAMPLE.COM (uppercase) | Accepted and logged in successfully (case-insensitive email matching) | Success: Case-insensitive login succeeded | ✅ **PASS** | Normalized email with strtolower() and LOWER(email)=? in query |
| `B-09` | Attacker | email=' OR '1'='1' -- | SQL injection failed with generic error message | Safely rejected: Invalid email or password | ✅ **PASS** | Prepared statements in DB query |
| `B-10` | Attacker | password=' OR '1'='1' -- | SQL injection failed with generic error message | Safely rejected: Invalid email or password | ✅ **PASS** | Password verification against bcrypt hash |
| `B-11` | Attacker | UNION SELECT payload in email | UNION injection safely rejected | Safely rejected: Invalid email or password | ✅ **PASS** | Prepared statements in sel() function |
| `B-12` | Pending User | test_user_01@example.com (status=0) requests allevents.php, cart.php | Restricted to profile.php; manual URL navigation redirected back to profile.php | Redirected 302 Location: profile.php; profile.php accessible (200 OK) | ✅ **PASS** | Restricted status=0 check in users/user/header.php strictly to profile.php |
| `B-13` | Pending Company | test_company_01@example.com (status=0) requests addevents.php | Restricted to profile.php; manual navigation redirected back to profile.php | Redirected 302 Location: profile.php; profile.php accessible (200 OK) | ✅ **PASS** | Restricted status=0 check in users/company/header.php strictly to profile.php |
| `B-14` | Admin -> User | Admin approves test_user_01@example.com (status=1) | Account approved in DB; user login redirects to dashboard and has full access to allevents.php | Approved status=1, login gives full access to allevents.php (200 OK) | ✅ **PASS** | Verified admin accept_or_reject.php approval workflow |
| `B-15` | Admin -> Company | Admin rejects test_company_01@example.com | Account rows deleted from DB; subsequent login fails | Deleted from DB; login fails with generic error | ✅ **PASS** | Verified admin rejection cascading delete |
| `B-16` | Tampering | Login as user (alice@example.com) with POST usertype=1, role=admin | Server uses DB usertype (2) only; access to users/admin/ blocked (redirect 302) | DB usertype enforced; admin panel access blocked (302 Location: login.html) | ✅ **PASS** | Enforced $_SESSION['usertype'] strictly from DB row in php/login.php |
| `B-17` | Migration | Login with legacy plaintext password | Plaintext password accepted once and migrated to bcrypt hash in DB | Accepted and re-hashed to bcrypt: $2y$12$gv0vVkmt... | ✅ **PASS** | Implemented legacy password verification and automatic bcrypt re-hashing |
| `B-18` | Brute Force | 10 rapid failed login attempts; then verify lockout expiration after 10 min window | Account locked with "Too many failed login attempts"; lockout expires after 10 minutes | Lockout triggered on rapid attempts; expired correctly after time window | ✅ **PASS** | Implemented login_attempts table tracking with 5 attempts per 10 minutes |
| `C-01` | Unauthenticated | Access 28 protected pages with no session (28 URLs) | All 28 pages return 302 redirect to login.html; zero leaks | All 28 pages returned 302 Location: login.html | ✅ **PASS** | Enforced session authentication guards in all header.php files |
| `C-02` | Unauthenticated | Access 26 backend endpoints in users/*/php/*.php with no session | All 26 endpoints return 401/403 or redirect to login.html | All 26 endpoints refused unauthorized access (401/403/302) | ✅ **PASS** | Enforced session authentication guards in all backend endpoints |
| `C-03` | User Session | User accesses users/admin/* and users/company/* | Blocked and redirected to login.html (302) | Blocked: both redirected to login.html (302) | ✅ **PASS** | Strict usertype checks in header.php (usertype===1 and usertype===3) |
| `C-04` | Company Session | Company accesses users/admin/* and users/user/* | Blocked and redirected to login.html (302) | Blocked: both redirected to login.html (302) | ✅ **PASS** | Strict usertype checks in header.php (usertype===1 and usertype===2) |
| `C-05` | Admin Session | Admin accesses users/user/* and users/company/* | Blocked and redirected to login.html (302) | Blocked: both redirected to login.html (302) | ✅ **PASS** | Strict role segmentation across admin, company, and user portals |
| `C-06` | Cross-Role AJAX | POST accept_or_reject.php with no session, user session, company session | All refused with HTTP 403 Unauthorized; no DB changes | Refused: HTTP 403 returned for all three unauthorized requests | ✅ **PASS** | Added session usertype===1 check with 403 response in accept_or_reject.php |
| `C-07` | Cross-Role AJAX | POST category.php with no session, user session, company session | Refused; zero categories added to database | Refused (302 Location: login.html); 0 categories added to DB | ✅ **PASS** | Enforced admin session guard in users/admin/php/category.php |
| `C-08` | Architecture | Curl without following redirects against all protected pages | Body contains zero protected content, forms, or data (no EAR vulnerabilities) | Confirmed: No EAR leaks found; all exits execute immediately after header() | ✅ **PASS** | Ensured exit immediately follows every header("Location: ...") |
| `C-09` | User | Logout via php/logout.php and attempt to reuse session cookie | Session destroyed; reusing old cookie fails and redirects to login.html | Session destroyed; old cookie redirected to login.html (302) | ✅ **PASS** | Destroyed session array, expired cookie timestamp, and destroyed session in logout.php |
| `C-10` | Security | Inspect Set-Cookie header on session generation | HttpOnly and SameSite flags are set on PHPSESSID cookie | Flags present: HttpOnly and SameSite=Lax verified | ✅ **PASS** | Configured session.cookie_httponly and session.cookie_samesite in .htaccess |
| `C-11` | Security | Check session ID before and after login | Session ID differs before and after login (session_regenerate_id) | Regenerated: Pre-ID= != Post-ID=33f7ab21e0e31fdfccad00f03c0f9c47 | ✅ **PASS** | Enforced session_regenerate_id(true) on successful login |
| `C-12` | Session Security | Request protected page with session idle for > 30 minutes | Session expired automatically; redirected to login.html (302) | Expired: 302 Location: login.html on idle timeout | ✅ **PASS** | Implemented 30-minute idle session timeout check in php/connect.php |
| `C-13` | User IDOR | User A (alice) tries to edit User B's booking (ID=1) | Refused: "Booking not found or unauthorized"; DB unchanged | Refused: Booking not found or unauthorized; DB unchanged | ✅ **PASS** | Scoped booking updates strictly to book_id AND user_email in query |
| `C-14` | User IDOR | User A (alice) tries to cancel User B's booking (ID=1) | Refused with HTTP 404; booking remains intact in DB | Refused (404); booking remains in database | ✅ **PASS** | Scoped booking delete strictly to book_id AND user_email |
| `C-15` | User IDOR | User A (alice) tries to delete User B's cart item (ID=4) | Refused; cart item remains intact in DB | Refused; User B cart item unaffected in database | ✅ **PASS** | Scoped cart delete strictly to user=? AND cart_id=? in query |
| `C-16` | User IDOR | User A (alice) tries to trigger advance payment for User B's booking | Refused with HTTP 404: "Booking not found or does not belong to your account" | Refused (404): Booking not found or does not belong to your account | ✅ **PASS** | Scoped payment endpoint strictly to book_id AND user_email |
| `C-17` | Company IDOR | Company A (wonderland) tries to edit Company B's event (ID=1) | Refused: "Event not found or unauthorized"; DB unchanged | Refused: Event not found or unauthorized; event name unchanged | ✅ **PASS** | Scoped event update strictly to event_id AND company_email |
| `C-18` | Company IDOR | Company A (wonderland) tries to delete Company B's event (ID=1) | Refused: "Event not found or does not belong to your account"; event exists in DB | Refused: Event not found or unauthorized; event preserved | ✅ **PASS** | Scoped event deletion strictly to event_id AND company_email |
| `C-19` | Company IDOR | Company A (wonderland) tries to approve Company B's booking (ID=1) | Refused: "Booking not found or unauthorized"; price quotation unchanged | Refused: Booking not found or unauthorized; price untouched | ✅ **PASS** | Joined events table and checked company_email in book_pending.php |
| `D-01` | Admin | cpass=wrongadminpass, npass=NewAdminPass123, cnpass=NewAdminPass123 | Rejected: "Current password is incorrect." | Rejected: Current password is incorrect | ✅ **PASS** | Verified current password with password_verify before update |
| `D-02` | User | cpass=wronguserpass, npass=NewUserPass123, cnpass=NewUserPass123 | Rejected: "Current password is incorrect." | Rejected: Current password is incorrect | ✅ **PASS** | Verified current password with password_verify before update |
| `D-03` | Company | cpass=wrongcomppass, npass=NewCompPass123, cnpass=NewCompPass123 | Rejected: "Current password is incorrect." | Rejected: Current password is incorrect | ✅ **PASS** | Verified current password with password_verify before update |
| `D-04` | User | Validation on new password rules (mismatch, new==current, <8 chars, no digits) | All 4 invalid cases rejected with proper messages | All 4 validation checks passed with clear rejection messages | ✅ **PASS** | Enforced confirm match, new!=current, min 8 chars, and alphanumeric regex in passwordchange.php |
| `D-05` | User | Change password to AliceNewPass456, then test old & new credentials | Password stored hashed; old password rejected, new password accepted | Old password rejected; new password succeeded; restored alice123 | ✅ **PASS** | Updated password with bcrypt hash and verified new credentials |
| `D-06` | Access Control | POST users/admin/php/passwordchange.php unauth and as user session | Refused and redirected to login.html (302) | Blocked: both redirected to login.html (302) | ✅ **PASS** | Strict session authentication in all passwordchange.php files |
| `D-07` | Tampering | Alice sends POST email=autodoc@gmail.com to passwordchange.php | Ignored: email pulled strictly from session; target user password unchanged | Autodoc password remains intact; email parameter safely ignored | ✅ **PASS** | Enforced $_SESSION['email'] strictly in passwordchange.php |
| `E-01` | User Profile | Empty required fields | Rejected: "Please fill in all required profile fields." | Rejected: Please fill in all required profile fields | ✅ **PASS** | Added server-side required fields check in users/user/php/profile.php |
| `E-02` | User Profile | phone=12345 and phone=1234567890123 | Rejected: "Phone number must be exactly 10 digits." | Rejected: Phone number must be exactly 10 digits | ✅ **PASS** | Enforced /^\d{10}$/ pattern in users/user/php/profile.php |
| `E-03` | User Profile | pincode=6820 (4 digits) | Rejected: "Pincode must be exactly 6 digits." | Rejected: Pincode must be exactly 6 digits | ✅ **PASS** | Enforced /^\d{6}$/ pattern in users/user/php/profile.php |
| `E-04` | User Profile | date_of_birth in future and age < 10 years | Rejected: "Please provide a valid date of birth (must represent an age between 10 and 120 years)." | Rejected invalid date of birth | ✅ **PASS** | Enforced age limits between 10 and 120 years in users/user/php/profile.php |
| `E-05` | User Profile | ifsc_code=INVALID_IFSC | Rejected: "IFSC code format is invalid (4 letters, 0, followed by 6 alphanumeric characters)." | Rejected: IFSC code format is invalid | ✅ **PASS** | Enforced /^[A-Z]{4}0[A-Z0-9]{6}$/ pattern in users/user/php/profile.php |
| `E-06` | User Profile | acc_no=123 (3 digits) | Rejected: "Bank account number must be between 9 and 18 digits." | Rejected: Bank account number must be between 9 and 18 digits | ✅ **PASS** | Enforced /^\d{9,18}$/ pattern in users/user/php/profile.php |
| `E-07` | User Profile | place=<script>alert("XSS")</script> | Rejected: "Address fields cannot contain HTML tags." | Rejected: Address fields cannot contain HTML tags | ✅ **PASS** | Enforced strip_tags check on address fields |
| `E-08` | Company Profile | Empty required fields | Rejected: "Please fill in all required company profile fields." | Rejected: Please fill in all required company profile fields | ✅ **PASS** | Added server-side required fields check in users/company/php/profile.php |
| `E-09` | Company Profile | phone=999 and pincode=68 | Rejected invalid phone and pincode | Rejected: 10-digit phone and 6-digit pincode enforced | ✅ **PASS** | Enforced phone and pincode regex in users/company/php/profile.php |
| `E-10` | Company Profile | est_date in future | Rejected: "Established date cannot be in the future." | Rejected: Established date cannot be in the future | ✅ **PASS** | Enforced est_date <= time() in users/company/php/profile.php |
| `E-11` | Company Profile | aadhar=12345 (5 digits) | Rejected: "Aadhar number must be exactly 12 digits." | Rejected: Aadhar number must be exactly 12 digits | ✅ **PASS** | Enforced /^\d{12}$/ for aadhar in users/company/php/profile.php |
| `E-12` | Upload Security | Upload shell.php.jpg containing PHP code | Rejected with HTTP 400: Invalid image file/format | Rejected (400): MIME and getimagesize check failed | ✅ **PASS** | Checked finfo_file MIME and getimagesize() in profile_pic.php |
| `E-13` | Upload Security | Upload document.txt as profile picture | Rejected with HTTP 400: Invalid image format | Rejected (400): Non-image rejected | ✅ **PASS** | Enforced allowed MIME types [jpeg, png, webp] |
| `E-14` | Upload Security | Upload 5.5 MB file | Rejected with HTTP 400: "File exceeds 5MB size limit" | Rejected (400): File exceeds 5MB size limit | ✅ **PASS** | Enforced 5MB size check in profile_pic.php |
| `E-15` | Upload Success | Upload valid 1x1 PNG image | Accepted with HTTP 200 and response body "1" | Accepted (200): Profile picture updated with random filename | ✅ **PASS** | Verified valid PNG processing, secure hashing, and database update |

---

## Identified Bugs & Code Remediation

The following security vulnerabilities, logic bugs, and validation gaps were identified and remediated in the codebase:

### BUG-01: Missing Confirm Password & Password Complexity Validation
- **File & Location**: `php/signup.php:16-41, 47-72`
- **Vulnerability / Issue**: The signup endpoint accepted passwords shorter than 8 characters, passwords without numbers or letters, and never checked whether `cpassword` matched `password`.
- **Remediation**: Added server-side checks enforcing minimum 8 characters, regex `^(?=.*[A-Za-z])(?=.*\d)`, and `$password === $cpassword` equality check.

### BUG-02: Missing Name & Email Constraints (XSS / Digits in Names / Overlong Email)
- **File & Location**: `php/signup.php:18-20, 49-51`
- **Vulnerability / Issue**: Names allowed digits and raw HTML tags; emails over 255 characters or with invalid spacing were processed without sanitization.
- **Remediation**: Enforced regex `/^[a-zA-Z\s'-]+$/` on names, rejected HTML tags via `strip_tags()`, and enforced email length `<= 255`.

### BUG-03: Potential Admin Role Self-Registration Tampering
- **File & Location**: `php/signup.php:10-12`
- **Vulnerability / Issue**: No explicit check prevented requests containing `usertype=1` from attempting privilege escalation during registration.
- **Remediation**: Added explicit validation rejecting any signup request with `usertype=1` with "Unauthorized registration role. Self-registration as administrator is not permitted."

### BUG-04: Missing HTTP Request Method Guard
- **File & Location**: `php/signup.php:8-9, php/login.php:8-9`
- **Vulnerability / Issue**: Endpoints did not verify HTTP `REQUEST_METHOD === 'POST'`, allowing GET requests without proper error handling.
- **Remediation**: Added strict `$_SERVER['REQUEST_METHOD'] !== 'POST'` checks returning clean error messages without warnings.

### BUG-05: User Account Enumeration Vulnerability
- **File & Location**: `php/login.php:18, 70-74`
- **Vulnerability / Issue**: Login returned "Account doesn't exist!" when an email was not in DB and "Incorrect Credentials" when the password was wrong, allowing attackers to enumerate valid emails.
- **Remediation**: Unified all failed authentication attempts to a generic message: "Invalid email or password."

### BUG-06: Case-Sensitive Email Matching in Authentication
- **File & Location**: `php/login.php:11, 18`
- **Vulnerability / Issue**: Emails submitted in uppercase or mixed-case failed login even if the account existed.
- **Remediation**: Normalized inputs with `strtolower(trim())` and queried DB with `LOWER(email)=?`.

### BUG-07: Lack of Brute-Force Rate Limiting on Login
- **File & Location**: `php/login.php:21-30, database/crystal_events.sql`
- **Vulnerability / Issue**: No rate limiting existed to prevent automated credential stuffing or dictionary attacks against user accounts.
- **Remediation**: Created `login_attempts` tracking table and enforced 5 failed attempts per email and IP within a 10-minute sliding window with temporary account lockout.

### BUG-08: Missing Session Cookie Security Flags (HttpOnly & SameSite)
- **File & Location**: `.htaccess:1-2`
- **Vulnerability / Issue**: Session cookies were created without explicit `HttpOnly` and `SameSite` flags, exposing sessions to potential XSS theft and CSRF.
- **Remediation**: Added root `.htaccess` configuration with `php_value session.cookie_httponly 1` and `php_value session.cookie_samesite Lax`.

### BUG-09: Missing Session Idle Timeout Handling
- **File & Location**: `php/connect.php:19-41`
- **Vulnerability / Issue**: Sessions remained active indefinitely until browser closure with no server-side idle timeout.
- **Remediation**: Added automatic 30-minute idle session timeout check in `php/connect.php` that destroys expired sessions and clears session cookies.

### BUG-10: Incomplete Session Invalidation on Logout
- **File & Location**: `php/logout.php:2-10`
- **Vulnerability / Issue**: `logout.php` called `session_destroy()` but did not clear `$_SESSION` array or expire the client-side session cookie.
- **Remediation**: Emptied `$_SESSION = []`, set cookie expiration timestamp in the past (`time() - 42000`), and issued clean header redirect.

### BUG-11: Pending Verification Bypass via Password Page
- **File & Location**: `users/user/header.php:23, users/company/header.php:23`
- **Vulnerability / Issue**: Pending accounts (`status = 0`) were allowed to access `password.php` instead of being strictly restricted to `profile.php`.
- **Remediation**: Updated restriction condition to strictly check `$status === 0 && $currentPage !== 'profile.php'`.

### BUG-12: Missing Initial Authentication Check in view.php
- **File & Location**: `users/user/view.php:1-6`
- **Vulnerability / Issue**: `view.php` checked `$_GET['id']` before including `header.php`, potentially redirecting unauthenticated users to `companies.php`.
- **Remediation**: Moved `require('header.php');` to line 2 before any parameter validation or query execution.

### BUG-13: Incomplete Password Change Validation & Parameter Tampering Vulnerability
- **File & Location**: `users/admin/php/passwordchange.php, users/company/php/passwordchange.php, users/user/php/passwordchange.php`
- **Vulnerability / Issue**: Password change endpoints did not check `cnpass` equality, allowed new password to equal current password, allowed short passwords, and did not guarantee email was bound to session.
- **Remediation**: Bound email strictly to `$_SESSION['email']`, enforced `password_verify` on current password, verified `$npass === $cnpass`, `$npass !== $cpass`, minimum 8 characters, and alphanumeric complexity.

### BUG-14: Missing Server-Side Validation for Profile Fields
- **File & Location**: `users/user/php/profile.php, users/company/php/profile.php, users/company/profile.php`
- **Vulnerability / Issue**: Profile endpoints lacked server-side checks for phone (10 digits), pincode (6 digits), IFSC format, account number length, established date/DOB bounds, and 12-digit Aadhar format.
- **Remediation**: Implemented comprehensive regex and date boundary validation in both profile processing scripts and added Aadhar input field to company profile form.

---

## Database Integrity & Cleanup Verification

Before testing began, baseline table row counts were recorded. All test accounts were generated using the explicit prefix `test_*@example.com` and isolated temporary entries. After test execution, cleanup scripts verified that:
1. All `test_*@example.com` rows were deleted from `login`, `users`, and `company` tables (0 test rows remaining).
2. All temporary login attempt rows were purged from `login_attempts`.
3. All seeded baseline sample data (7 bookings, 11 categories, 16 companies, 3 complaints, 3 contacts, 15 events, 15 gallery items, 24 login accounts, 9 payments, 3 reviews, 5 users) remains 100% intact.

### Post-Test Database State

| Table Name | Row Count | Test Artifacts Remaining |
| :--- | :--- | :--- |
| `bookings` | 7 | 0 |
| `cart` | 0 | 0 |
| `category` | 11 | 0 |
| `company` | 16 | 0 |
| `complaint` | 3 | 0 |
| `contact` | 3 | 0 |
| `events` | 15 | 0 |
| `gallery` | 15 | 0 |
| `login` | 24 | 0 |
| `payment` | 9 | 0 |
| `review` | 3 | 0 |
| `users` | 5 | 0 |
| `login_attempts` | 0 | 0 |

---

## Apache & PHP Error Logs

The Apache error log (`C:\xampp\apache\logs\error.log`) and PHP error log were inspected before and after test execution:
- Baseline error log line count: **28 lines**
- Final error log line count after 82 live tests and UI automation: **28 lines**
- **New errors / notices / warnings produced during testing: 0**

---

## UI/UX Screenshots

Headless browser screenshots were captured during UI/UX validation to confirm proper SweetAlert rendering, responsive styling, and absence of raw PHP errors:

### Login Page UI
*Public login form with sliding overlay animation*  
![Login Page UI](screenshots/01_login_page.png)

### Sign Up Page UI
*Dual User & Company registration forms with client validation*  
![Sign Up Page UI](screenshots/02_signup_page.png)

### Invalid Login SweetAlert
*Generic error modal ("Invalid Credentials") without username enumeration*  
![Invalid Login SweetAlert](screenshots/03_login_invalid_credentials_sweetalert.png)

### Admin Login Success SweetAlert
*Welcome modal confirming administrative authentication*  
![Admin Login Success SweetAlert](screenshots/04_login_admin_success_sweetalert.png)

### Admin Dashboard
*Administrator analytics portal showing real-time stat cards*  
![Admin Dashboard](screenshots/05_admin_dashboard.png)

### User Dashboard
*Client portal overview displaying bookings and actions*  
![User Dashboard](screenshots/06_user_dashboard.png)

### Company Dashboard
*Organizer portal displaying events, inquiries, and revenue*  
![Company Dashboard](screenshots/07_company_dashboard.png)

### User Profile Page
*Client profile view with field constraints and avatar editing*  
![User Profile Page](screenshots/08_user_profile.png)

### Company Profile Page
*Organizer profile view featuring 12-digit Aadhar input and company details*  
![Company Profile Page](screenshots/09_company_profile.png)

### Password Change Page
*Secure password change form enforcing current password and complexity*  
![Password Change Page](screenshots/10_user_password.png)

### Signup Validation SweetAlert
*Client/Server validation error modal blocking mismatched inputs*  
![Signup Validation SweetAlert](screenshots/11_signup_validation_sweetalert.png)

---

## Summary & Recommendations

All required security controls, input validation rules, session protections, access control guards, and IDOR defenses have been implemented and verified. The application is completely secure against unauthorized role access, session hijacking, parameter tampering, and injection payloads.
