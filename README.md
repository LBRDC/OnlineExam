# LBRDC-OE 0.3.x-alpha
 Online Exam Management System Redesigned.

 #### Features
 1. Manage employment cluster
 2. Manage examinations
 3. Manage applicants
 4. View and generate exam results
 5. Examination Page

#### Files
* Database Diagram
  - Editor: https://app.diagrams.net
  - File: [LBRDC-OE_db.drawio](https://drive.google.com/file/d/1mbHmHw8Nv_y2JifhUMT8JeutROFpM7oF/view?usp=sharing)

#### Requirements

1. XAMPP [apachefriends.org](https://www.apachefriends.org/)
2. Visual Studio Code (For Coding)
3. Composer [getcomposer.org](https://getcomposer.org/)

#### instructions

1. Install XAMPP, VSCode, Composer
2. delete files inside htdocs folder (C:\xampp\htdocs)
3. clone repository to htdocs folder (make sure path is "C:\xampp\htdocs")
4. Launch CMD in htdocs folder, run 'composer install'  
   4.1 If error edit php.ini, remove ";" on "extension=gd" and "extension=zip"  
6. Launch XAMPP Control Panel
7. Start Apache, MySQL
8. Go to MySQL Admin Page
9. Import latest lbrdc-oe_DBS_*.sql located inside _MiscFiles folder
10. For ADMIN, go to web browser and input "localhost/adminpanel"
11. For EXAMINEE, go to web browser and input "localhost/online-exam"

## Reminders

1. Follow Test Format  
   ```
   Test 1: ...  
   Test 2: ... (Part 1)  
   Test 2: ... (Part 2)  
   Test 3: ...  
   Applicant Risk Profiler  
   ```
   *The System sorts the exam for the examinee based on the title with tests being the first and the applicant risk profiler being the last.

## Dependencies Information
#### CSS
<b>Bootstrap:</b> 4.1.3  
<b>Animate.css:</b> 3.7.0  
<b>Font Awesome Free:</b> 5.6.3  
<b>Font Awesome:</b> 4.0.3  
<b>Hamburgers:</b> ???  
<b>FullCalendar:</b> 3.9.0  
#### JS
<b>JQuery:</b> 3.3.1  
<b>Sizzle CSS Selector:</b> 2.3.3  
<b>Perfect Scrollbar:</b> 1.4.0  
<b>Bootstrap-JS:</b> 4.2.1  
<b>Kickass:</b> 1.14.6  
<b>metismenu:</b> 3.0.3  
<b>FullCalendar:</b> 3.10.0  
<b>ChartJS:</b> 2.7.3  
#### EXTERNAL
<b>ffmpeg</b> 7.0  
<b>Composer</b> 2.7.2  
<b>PHPOffice</b> 2.0.0  
