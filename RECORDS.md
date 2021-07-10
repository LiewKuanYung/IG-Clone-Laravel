# Important Records

### Learning resouces

1. [freeCodeCamp](https://www.youtube.com/watch?v=ImtZ5yENzgE) (Following this tutorial for this project)
2. [TraversyMedia](https://www.youtube.com/watch?v=MFh0Fd7BsjE)

### Useful records

1. **(2:07)** Many ways of installation, i.e., [Discussion about installing laravel through docker](https://laracasts.com/discuss/channels/laravel/curl-s-httpslaravelbuildexample-app-bash) or [Composer](https://getcomposer.org/)
2. **(11:42)** [PHP authentication](https://laravel.com/docs/8.x/authentication) or [Simpler explanation](https://laravelarticle.com/laravel-8-authentication-tutorial)
3. **(12:04) \& (26:00)** Front-end
- When changing anything in front end (like the .sass files), need to use `npm run dev` to refresh.
4. **(20:00)** [Data migration](https://laravel.com/docs/8.x/migrations) 
- Why data migration? simple answer is it helps you modify database with a more systematic ways (avoid you screw things up due to human error), and good for team collaboration.
5. **(42.12)** Adding username to the regirstration flow (inside Auth folder)
```
- First, add the markup in register.blade.php
- Second, access the app/Http/Controllers/Auth/RegisterController.php and modify validator() and create()
  Add new attribute "username"
- Third, access the database/migrations/create_users_table.php and modify the up()
  Add new attribute "username"
- Fourth, access Tinker in powershell using `php artisan tinker` to interact with the database of application.
  To check user table, use command `User::all();`
- Last, you will find out that username attribute is still not added
  Because whenever you made changes to database, we need to recreate the database 
  Use command `php artisan migrate:fresh` to recreate database
  Be aware that previous data will be deleted!!
- Also, need to access app/Models/User.php and add username into $fillable 
  Laravel provides another level of protection at Model to confirm what data can be filled
```
6. **(58:35)** Creating profiles controller 
- use `make:controller`.
- Also, can use `php artisan help command` to check what is the required parameters or arg for this command. For example, `php artisan help make:controller`.
- This part needs to deal with ProfilesController.php and routes/**web.php**.
7. **(1:04:00)** RESTful Resource Controller. 
- Read Laravel [RESTful Resources Controller](https://laravel.com/docs/8.x/controllers)
- The command `User::find($user)` is used to find the data from Models\User.php
- **dd()** is useful function to echo out what's inside the variable
- Explanation of the codes is inside ProfilesController
8. **(1:10:20)** Adding the Profiles Mode, Migration and Table
- **Eloquent** is what laravel calls the database layer of the framework. Implementation that fecth quries, and database agnostic (can use diff database platform with the same database query)
- command used is `php artisan make:model Profile -m
- Manipulate database inside **Tinker** to test Profile model
```
>>> $profile = new \App\Models\Profile();
=> App\Models\Profile {#3415}
>>> $profile->title = 'Cool Title';
=> "Cool Title"
>>> $profile->description = 'Description'
=> "Description"
>>> $profile->user_id = 1;
=> 1
>>> $profile->save();
=> true
>>> $profile->user
=> App\Models\User {#4140
     id: "1",
     name: "Test user",
     email: "test@gmail.com",
     username: "Test username",
     email_verified_at: null,
     #password: "$2y$10$l.6j2.ZaQOyKzr1gYBB3JumH9pefemwDmyAl8sXFJ5AwcpvbCdHcG",
     #remember_token: null,
     created_at: "2021-07-07 12:31:25",
     updated_at: "2021-07-07 12:31:25",
   }
```
8. **(1:17:30)** Adding Eloquent Relationships
- Read more about [relationships in Eloquent](https://laravel.com/docs/8.x/eloquent-relationships)
- Example of accessing data through relationship
```
>>> $user = App\Models\User::find(1);
>>> $user->profile
```
9. Saving changes in database
```
>>> $user->profile->url = 'www.kuanyung.com';
=> "www.kuanyung.com"
>>> $user->save();
=> true
>>> $user->push();
=> true
```
- The command `$user->save()` won't work because the change happens in profile table. Hence, use `$user->push()` to save everything changed using $user
10. (1:30:00) Adding Posts to the Database & Many To Many Relationship
- More about post and get
- `@csrf` a security features that strictly allows authorized user (accessing specific web page) to hit the server
11. More about [Validation and rules](https://laravel.com/docs/8.x/validation#rule-image)
12. **(2:01:48)** Mass assignment issue
13. **(2:03:17)** Integrity constraint violation (sign in)
- Solution to this is (2:04:24) Creating Through a Relationship
- Also created a **middleware** to hide sensitive information
14. **(2:08:12)** Uploading/Saving the Image to the Project
- How to upload the picture, save at the correct path
- The store() method can save files in diff places, example Amazon s3
- `php artisan storage:link` to link storage/app/public/uploads 
- After finished post, redirect back to profile page
- To delete data (or clear database), use `Post::truncate();` inside tinker. The "Post" should be your database table name
15. **(2:19:19)** Resizing Images with Intervention Image PHP Library
- Adding new library using `composer require library`
- Issue 1: Installation of Intervention\Image requires guzzlehttp\prs7:^1.7 version. Learn more about [composer CLI](https://getcomposer.org/doc/03-cli.md#composer-root-version) and I post my solution in [stackoverflow](https://stackoverflow.com/questions/68260822/image-intervention-package-not-install-for-laravel-8) 
- Issue 2: GD Library extension not available with this PHP installation. And the [solution](http://www.webassist.com/tutorials/Enabling-the-GD-library-setting) is to enable it in php.ini file (for windows). After enabled, don't forget to restart the application.
16. **(2:31:48)** Editing the Profile
- Repeat the same steps
- Add edit.blade.php -> Configure route in web.php -> Add edit and update function for ProfilesController.php
17. **(2:46:46)** Restricting/Authorizing Actions with a Model Policy
- Use `php artisan help make:policy` for more information
18. **(3:00:00)** Automatically Creating A Profile Using Model Events
- boot method, read more about [Eloquent Event](https://laravel.com/docs/8.x/eloquent#events)
- Inside event, "saved" means already saved, and "saving" means before saving. The ed is pass, and the ing is before the action being done.
19. **(3:19:48)** Follow/Unfollow Profiles Using a **Vue.js** Component
- `npm run dev` only run dev for once, in order to run for long time, use `npm run watch`
- vue component is stored inside \resources\js\component\
- Laravel is shipped with **axios** as well
- vue property
- Many to many relationship (need to create a pivot table, like a bridge in relational database).
- First, we don't really need a new model, we need to create migration and use existing data field, use `php artisan make:migration creates_profile_user_pivot_table --create  profile_user` (naming convention, follow alphabetic order, P first then U (Profile User), and everything is lower case, then add a _ in between)
- After created migration and defined the data field, add m-2-m relationship into User.php and Profile.php
- Laravel toggle feature (if you `console.log(response.data);` and click the follow button a few times, you will find out that the toggle will attach / detach depends on whether you followed or not followed that person)
- [migrate:fresh specific table](https://stackoverflow.com/questions/45473624/laravel-5-4-specific-table-migration)
- refresh tinker using $attribute->fresh()->data 
20. **(3:48:55)** Laravel Telescope
- Read [Telescope](https://laravel.com/docs/8.x/telescope)
- Go to http://localhost:8000/telescope/requests
- RouteServiceProvider.php inside /Auth defines what is the HOME directory. And this HOME is used by loginController, RegistrationController etc.
23. **(4:01:03)** Pagination with Eloquent
- change from `->get()` to `->paginate(num)` 
- [Pagination with bootsrap](https://laravel.com/docs/8.x/pagination#using-bootstrap)
22. **(4:03:25)** N + 1 Problem & Solution 
- By using the `->with('user')`
23. **(4:05:21)** Make Use of Cache for Expensive Query
- cache is inside Illuminate\Support\Facades\Cache
- telescope has a cache bar for you to view your cache hit or miss or set
- All you need to do is at controller, do the `Cache::remember()` and return the $variable to view.
24. **(4:11:44)** Sending Emails to New Registered Users
- Laravel is build in with mailtrap.io
- Use `php artisan make:mail NewUserWelcomeMail -m emails.welcome-email`. The "NewUserWelcomeMail" is required name, the -m is a markdown template, and the "emails.welcome-email" is where you wanna store this mailable, and it will ultimately be in your view directory. 
25. Additional resources
- [freeCodeGram GitHub](https://github.com/coderstape/freecodegram), [Coderstape YouTube Channel](https://www.youtube.com/coderstape)
- Read the laravel documentation! It has awesome open community documentation!
- News about laravel at [laravel-news](https://laravel-news.com/)


### Improvement / Continue Learning
1. Prevent multiple click / post to server
- If you accidentally clicked the post button multiple times when creating the post, the server will get hit multiple times and in turn storing multiple samve value/data.
- Looking for potential solution for [front-end](https://www.the-art-of-web.com/javascript/doublesubmit/) and back-end 
- sometimes when you change env, you might need to refresh your php artisan serve

### Tmp records

```
.env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
