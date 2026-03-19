# TESD_1500-and-1700_Final-Project

This project is a library management website for my final project for the TESD_1700 Server-Side Web Development Course at Southwest Technical College.

The `library.php` page is the main page for this website, but if you try to open any page before `login.php`, you will be automatically routed back to `login.php` to login, then routed back to the page you originally opened.

To try this for yourself, import the `library_management.sql` file into your sql database server (I am using MAMP).

If this were a real website, the `lib` folder would be located outside the document tree, so it could not be accessed by web users, but since I am using MAMP to test this, this note will have to suffice for "security".

Next steps:
- [ ] Add a search page (that is kind of the purpose of having a database like this)
- [ ] Allow users to create their own custom columns
