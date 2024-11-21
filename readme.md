# Movie Ticket Booking System - Mini Project

## Overview  
This **Movie Ticket Booking System** is a PHP-based project designed for booking movie tickets online. The system is simple, user-friendly, and incorporates a **powerful admin panel** to manage all database-related operations. This is a prototype version developed as part of a college mini-project.

### Key Features  
1. **Powerful Admin Panel**  
   - Delete, remove, edit all database entries effortlessly.  
   - Manage movies, shows, and seat availability dynamically.

2. **Dynamic Seat Selection**  
   - **Seat Grid Design**: Displays **available**, **selected**, and **booked** seats visually.  
   - Two seat categories: **Gold** and **Silver**, each with dynamic pricing and unique grid designs.

3. **View Past Orders**  
   - Users can view their previous ticket bookings.

4. **Simple UI/UX**  
   - Clean and responsive design using **HTML, CSS, and JavaScript**.

5. **SQL Database**  
   - Uses **movie_booking.sql** to store all data, including user details, movies, and seat booking information.

---

## Installation Guide  

Follow these steps to set up the project locally:  

1. **Upload the Database**  
   - Import the `movie_booking.sql` file into your MySQL database.

2. **Update Configuration**  
   - Open the `config.php` file and update the database connection details:
     ```php
     $dbHost = "localhost";  
     $dbUser = "your_db_username";  
     $dbPass = "your_db_password";  
     $dbName = "movie_booking";  
     ```

3. **Run the Project**  
   - Start your local server (e.g., XAMPP or WAMP).  
   - Place the project folder in the server's root directory (e.g., `htdocs` for XAMPP).  
   - Access the project in your browser using `http://localhost/your_project_folder`.

---

## Admin Panel Login Credentials  

- **Email**: `admin@admin.com`  
- **Password**: `admin123`

---

## Tools & Technologies Used  

- **Backend**: PHP (MySQLi for database connection)  
- **Frontend**: HTML, CSS, JavaScript (for a responsive and user-friendly UI)  
- **Database**: MySQL  

---

## Notes  

- This project is a **prototype version** developed for a college mini-project.  
- While functional, this system is not intended for production use without further development and testing.  

---

## Screenshots  

![image](https://github.com/user-attachments/assets/4861842d-bef1-4fda-8d65-f9ed95f3977b)
![image](https://github.com/user-attachments/assets/194eac39-c1ba-4026-9f3e-0d1310d86f59)
![image](https://github.com/user-attachments/assets/7bc74d9f-c730-4bae-a638-0243c946311b)
![image](https://github.com/user-attachments/assets/3055ec66-62ae-477e-9574-f373a52ad929)
![image](https://github.com/user-attachments/assets/88ad3501-e210-4392-90d6-5f1246a4f490)
![image](https://github.com/user-attachments/assets/4631ece0-7019-4d66-add8-a27380e1a0e0)
![image](https://github.com/user-attachments/assets/ceac5ae9-3d14-4281-b103-8cf5d9cd03e2)


---
