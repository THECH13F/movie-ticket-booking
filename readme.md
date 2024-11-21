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

![Home](https://github.com/user-attachments/assets/830fb9cd-b557-4157-9f07-9cd55114abf8)
![Show](https://github.com/user-attachments/assets/67c1951d-3381-4aa7-8d7e-14d0f613b03e)
![image](https://github.com/user-attachments/assets/8dddf89d-5aa7-476d-a312-2cfc7e323e33)
![image](https://github.com/user-attachments/assets/93db6965-4671-4d4d-8e90-b84ff25fcc62)
![image](https://github.com/user-attachments/assets/2a2e8448-82e0-469d-b79c-0bd2b3e341f2)
![image](https://github.com/user-attachments/assets/ee4f7412-1f7e-451e-9772-cfcb48b07b1b)

---