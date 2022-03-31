# chat_server



Chat application created for learning purpose and fun. 
Application requires authorization. App provides rooms with chat, rooms can be public or private. You connecting to room by yourself. 
After connecting the **room_token** is stored, and until
leaving the room or logging out you cannot connect to 
another room. There is realtime user panel in room, 
displays which user is connected/disconnected. 
Chat uses lazy_loading, means that  all messages are not stored on the server, but are automaticly get form api when users scroll up.



## Check out my app
https://russian-messenger.herokuapp.com/login 


## Stack
    - PHP
    - Laravel
    - Vue.js
    - Pusher
    - Bootstrap
    - MySQL
    - Docker

## Tests
    - PHPUnit
    - Jest
    - vue/test-utils

To run tests:
 -  PHP
`php aritsan test / vendor/bin/phpunit`
 - Vue `npm test`

Not all test for vue are done, I had problem with mocking pusher - workin on it
