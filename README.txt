Please create database name "stunner" (username root, password='')
	run migration (git bash)
	 - type "php artisan migrate"
	run seeder
	 - type "php artisan db:seed --class=AdminAccount" and "php artisan db:seed --class=PreLyrics"

	run server
	 - type "php artisan serve" (localhost:8000)

Navigate to (localhost:8000)
 - to login as admin 
    username = "admin@gmail.com"
    password = "letmein"

 - to register hit "register button"

 Once authenticated, redirected to (localhost:8000/lyrics)
  - to create new lyrics  hit ("Create new lyrics" link)
    - all field should be filled, error throw if incomplete
    - hit save button to record
  - Edit/Delete selection box is pre-loaded if data exist, based on user id
    - select title name to display lyrics
    - hit update to "save"
    - hit delete to "remove from db"
  - to show lists 
    - hit "Show lists of lyrics" link

 To logout
  - hit log-out button



  --- This application does'nt have a theme, i haven't use bootstrap 3 yet, it will take time for me to sink in.
  --- All the functionality required are all working.
