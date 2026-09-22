## Preparation Before Starting

Before you write any PHP logic, you must complete the following preparation steps:

1. **Import the Database:**
   - Open **phpMyAdmin** (make sure your Apache and MySQL modules are running).
   - Create a new database, name it something like: `db_upload_exercise`.
   - Select the newly created database, go to the **Import** tab, and upload the `database.sql` file located in this folder.
   - The `users` and `files` tables will be created automatically.

2. **Prepare the Storage Directory:**
   - Create a new folder named `uploads` in the root directory of this project (at the same level as `index.php`).
   - This folder will serve as the physical storage location for the files uploaded by users.

*(Please read the comments starting with `//` inside each of those files for detailed, step-by-step instructions).*

## ⚠️ Warning for the Next Phase

The code you write today will act as the foundation for our **Vulnerability Patching Exercise** in the upcoming session. Write the logic to the best of your ability now. Later, we will dissect your code together to uncover all the security vulnerabilities hidden within it!

Good luck and happy coding! :)